<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TransactionsModel;
use App\Libraries\PdfLibrary;

class ReportsController extends Controller
{
    protected $transactions;

    function __construct()
    {
        $this->transactions = new TransactionsModel();
    }

    public function index()
    {
        $text = [
            'title' => "Reports | Perpus Digital",
            'header' => "Prints Summary"
        ];

        $db['transactions'] = $this->transactions->getTransactionsByAllId()->getResultArray();
        $db['transactionscount'] = $this->transactions->countAll();

        $data['page'] = view('admin/v_reports', array_merge($text, $db));

        echo view("admin/v_homepage", $data);
    }

    public function generatePdf()
    {
        // Inisialisasi PDF
        $pdf = new PdfLibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('https://instagram.com/ansdyi');
        $pdf->SetTitle('Perpus Digital');
        $pdf->SetSubject('Report generated using CodeIgniter and TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, CodeIgniter');

        // Konfigurasi margin, header, dan footer
        $pdf->SetMargins(15, 27, 15); // Margin kiri, atas, kanan
        $pdf->SetHeaderMargin(5); // Margin header
        $pdf->SetFooterMargin(10); // Margin footer
        $pdf->SetAutoPageBreak(TRUE, 15); // Otomatis memotong halaman
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); // Skala gambar

        // Set font default
        $pdf->SetFont('dejavusans', '', 8);

        // Tambahkan halaman
        $pdf->AddPage();

        // Ambil data dari model
        $print = $this->transactions->getTransactionsByAllId()->getResultArray();

        // Siapkan header tabel
        $html = '<table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr style="background-color:#CDC5BF; text-align:center; font-weight:bold;">
                        <th style="width: 40px;">No</th>
                        <th>Status</th>
                        <th style="width: 170px;">Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>';

        // Siapkan isi tabel
        $no = 1; // Inisialisasi nomor
        foreach ($print as $item) {
            $html .= '<tr style="text-align:center;">
                    <td style="width: 40px;">' . $no++ . '</td>
                    <td>' . (isset($item['status']) ? $item['status'] : '-') . '</td>
                    <td style="width: 170px;">' . (isset($item['judul_buku']) ? $item['judul_buku'] : '-') . '</td>
                    <td>' . (isset($item['tgl_pinjam']) && $item['tgl_pinjam'] ? date('d/m/Y', strtotime($item['tgl_pinjam'])) : '-') . '</td>
                    <td>' . (isset($item['tgl_pengembalian']) && $item['tgl_pengembalian'] ? date('d/m/Y', strtotime($item['tgl_pengembalian'])) : '-') . '</td>
                    <td>' . (isset($item['denda']) ? 'Rp ' . number_format($item['denda'], 0, ',', '.') : 'Rp 0') . '</td>
                  </tr>';
        }

        $html .= '</tbody></table>';

        // Tulis HTML tabel ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Tutup halaman terakhir
        $pdf->lastPage();

        // Unduh file PDF
        $pdf->Output('print_perpusdigi_' . date('YmdHis') . '.pdf', 'D');
    }
}
