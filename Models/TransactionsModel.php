<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tgl_pinjam', 'tgl_pengembalian', 'status', 'id_buku', 'id_user', 'denda'];

    public function getTransactionsByAllId()
    {
        $builder = $this->db->table('transaksi');
        $builder->select('transaksi.*, buku.judul as judul_buku, buku.id as id_buku');
        $builder->join('user', 'transaksi.id_user = user.id', 'left');
        $builder->join('buku', 'transaksi.id_buku = buku.id', 'left');
        return $builder->get();
    }
}
