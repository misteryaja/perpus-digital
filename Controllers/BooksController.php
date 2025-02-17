<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BooksModel;

class BooksController extends Controller
{
    protected $books;

    function __construct()
    {
        helper('form');
        $this->books = new BooksModel();
    }

    public function index()
    {
        $text = [
            'title' => "Books | Perpus Digital",
            'header' => "Books Administration"
        ];

        $db['books'] = $this->books->findAll();
        $db['bookscount'] = $this->books->countAll();

        $data['page'] = view('admin/v_books', array_merge($text, $db));

        echo view("admin/v_homepage", $data);
    }

    public function save()
    {
        $data = [
            'judul'     => $this->request->getVar('judul'),
            'penerbit'     => $this->request->getVar('penerbit'),
            'tgl_terbit'     => $this->request->getVar('tgl_terbit'),
            'kategori'     => $this->request->getVar('kategori'),
            'stok'     => $this->request->getVar('stok'),
        ];

        $this->books->save($data);

        session()->setFlashdata('title', 'Great!');
        return redirect()->back()
            ->with('text', 'New Book was Saved!');
    }

    public function update($id)
    {
        $data = [
            'judul'     => $this->request->getVar('judul'),
            'penerbit'     => $this->request->getVar('penerbit'),
            'tgl_terbit'     => $this->request->getVar('tgl_terbit'),
            'kategori'     => $this->request->getVar('kategori'),
            'stok'     => $this->request->getVar('stok'),
        ];

        $this->books->update($id, $data);

        session()->setFlashdata('title', 'Great!');
        return redirect()->back()
            ->with('text', 'Book was Updated!');
    }

    public function delete($id)
    {
       $this->books->delete($id);

       session()->setFlashdata('title', 'Great!');
       return redirect()->back()
        ->with('text', 'Book was Deleted!');
    }
}
