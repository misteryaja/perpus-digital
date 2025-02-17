<?php

namespace App\Models;

use CodeIgniter\Model;

class BooksModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'penerbit', 'tgl_terbit', 'kategori', 'stok'];
}
