<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TransactionsModel;
use App\Models\BooksModel;

class TransactionsController extends Controller
{
    protected $transactions;
    protected $books;

    function __construct()
    {
        helper('form');
        $this->transactions = new TransactionsModel();
        $this->books = new BooksModel();
    }

    public function index()
    {
        $text = [
            'title' => "Transactions | Perpus Digital",
            'header' => "Library Transactions"
        ];

        $db['books'] = $this->books->findAll();

        // Ambil data transaksi dengan relasi ke tabel buku dan user (opsional)
        $db['transactions'] = $this->transactions->getTransactionsByAllId()->getResultArray();
        $db['transactionscount'] = $this->transactions->countAll();


        // Kirim data ke view
        $data['page'] = view('admin/v_transactions', array_merge($text, $db));

        echo view("admin/v_homepage", $data);
    }

    public function save()
    {
        $session = session(); // Inisialisasi session

        // Ambil data dari form input
        $data = $this->request->getPost();

        // Validasi input
        if (
            !$this->validate([
                'status' => 'required',
                'id_buku' => 'required',
                'tgl_pinjam' => 'required|valid_date',
                'tgl_pengembalian' => 'permit_empty|valid_date',
            ])
        ) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil ID user dari session
        $data['id_user'] = $session->get('id'); // Pastikan session 'id' diatur saat login
        if (!$data['id_user']) {
            return redirect()->back()->withInput()->with('error', 'ID user tidak ditemukan dalam session. Pastikan Anda sudah login.');
        }

        // Ambil informasi buku dari database
        $book = $this->books->find($data['id_buku']);
        if (!$book) {
            return redirect()->back()->withInput()->with('error', 'Buku tidak ditemukan.');
        }
        // validasi stok buku berdasarkan status transaksi
        if ($data['status'] == 'pinjam') {
            if ($book['stok'] <= 0) {
                return redirect()->back()->withInput()->with('error', 'Stok buku tidak mencukupi untuk dipinjam.');
            }
            $book['stok']--; // Kurangi Stok
        } elseif ($data['status'] == 'pengembalian') {
            $book['stok']++; // Tambah stok
        }

        // Hitung denda jika di perlukan
        $data['denda'] = 0;
        if (!empty($data['tgl_pengembalian'])) {
            $tglPinjam = new \DateTime($data['tgl_pinjam']);
            $tglPengembalian = new \DateTime($data['tgl_pengembalian']);
            $selisihHari = $tglPengembalian->diff($tglPinjam)->days;

            if ($data['status'] === 'pengembalian' && $selisihHari > 7) {
                $data['denda'] = ($selisihHari - 7) * 1000; // Denda Rp1000 per hari
            }
        }

        // Simpan data ke database
        if ($this->transactions->save($data)); {
            // Perbarui stok buku
            $this->books->update($data['id_buku'], ['stok' => $book['stok']]);
            session()->setFlashdata('title', 'Great!');
            return redirect()->back()->with('text', 'New Transaction was Saved!');
        }

        return redirect()->back()->with('error', 'New Transaction was Failed to Save!');
    }



    public function update($id)
    {
        $session = session(); // Inisialisasi session

        // Ambil data dari form input
        $data = $this->request->getPost();

        // Validasi input
        if (
            !$this->validate([
                'status' => 'required',
                'id_buku' => 'required',
                'tgl_pinjam' => 'required|valid_date',
                'tgl_pengembalian' => 'permit_empty|valid_date',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // ambil informasi dari transaksi yang ada
            $transaction = $this->transactions->find($id);
            if (!$transaction) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memperbarui transaksi ini.');
            }

            // Ambil informasi buku dari database
            $book = $this->books->find($data['id_buku']);
            if (!$book) {
                return redirect()->back()->withInput()->with('errors', 'Buku tidak ditemukan.');
            }

            // Validasi stok buku berdasarkan status transaksi
            if ($data['status'] === 'pinjam') {
                if ($book['stok'] <= 0) {
                    return redirect()->back()->withInput()->with('errors', 'Stok buku tidak mencukupi untuk dipinjam.');
                }
                
                // jika buku sebelumnya telah dikembalikan, kembalikan stok sebelumnya
                if ($transaction['status'] === 'pengembalian') {
                    $book['stok']--;
                }
            } elseif ($data['status'] === 'pengembalian') {
                // Tambahkan stok jika status sebelumnya adalah pinjam
                if ($transaction['status'] === 'pinjam') {
                    $book['stok']++;
                }
            }

            // Hitung denda jiika di perlukan
            $data['denda'] = 0;
            if (!empty($data['tgl_pengembalian'])) {
                $tglPinjam = new \DateTime($data['tgl_pinjam']);
                $tglPengembalian = new \DateTime($data['tgl_pengembalian']);
                $selisihHari = $tglPengembalian->diff($tglPinjam)->days;

                if ($data['status'] === 'pengembalian' && $selisihHari > 7) {
                    $data['denda'] = ($selisihHari - 7) * 1000; // Denda Rp1000 per hari
                }
           }

           // Simpan perubahan transaksi ke database
           if ($this->transactions->update($id, $data)) {
            // perbarui stok buku
            $this->books->update($data['id_buku'], ['stok' => $book['stok']]);
            session()->setFlashdata('title', 'Success!');
            return redirect()->back()->with('text', 'Transaction was Updated!');
           }

           return redirect()->back()->with('error', 'Failed to update transaction.');
    }

    public function delete($id)
    {
        // Ambil informasi transaksi berdasarkan ID
        $transaction = $this->transactions->find($id);
        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        // ambil informasi buku yang terkait dengan transaksi
        $book = $this->books->find($transaction['id_buku']);
        if (!$book) {
            return redirect()->back()->with('errors', 'Buku terkait tidak ditemukan.');
        }

        // Atur stok buku berdasarkan status transaksi
        if ($transaction['status'] === 'pinjam') {
            // jika transaksi adalah peminjaman, kurangi stok buku
            $book['stok']++;
        } elseif ($transaction['status'] === 'pengembalian') {
            if ($book['stok'] > 0) {
                $book['stok']--;
            }
        }

        // Mulai proses penghapusan
        if ($this->transactions->delete($id)) {
            // Perbarui stok buku di database
            $this->books->update($transaction['id_buku'], ['stok' => $book['stok']]);
            session()->setFlashdata('title', 'Success!');
            return redirect()->back()->with('text', 'Transaction was Deleted!');
        }

        return redirect()->back()->with('error', 'Failed to delete transaction.');
    }
}
