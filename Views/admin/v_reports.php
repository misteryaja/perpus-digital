<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width:
            100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $header; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><?= $header; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box Update -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="nav-icon fas fa-print"></i>
                    Prints
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">
                <!-- Generate PDF Button -->
                <?php
                echo '<a href="reports/generatePdf" class="btn btn-primary mb-3">Generate PDF Report</a>'; // Tombol berwarna biru
                ?>

                <!-- Tabel -->
                <table class="table table-bordered table-striped text-center"> <!-- Tambahkan kelas text-center -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($transactions as $item) :
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($item['status']) ?></td>
                                <td><?= esc($item['judul_buku']) ?></td>
                                <td><?= esc(date('d/m/Y', strtotime($item['tgl_pinjam']))); ?></td>
                                <td><?= esc(date('d/m/Y', strtotime($item['tgl_pengembalian']))); ?></td>
                                <td><?= esc($item['denda'] > 0 ? 'Rp ' . number_format($item['denda'], 0, ',', '.') : 'Rp 0') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?= $transactionscount; ?> Total Data
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>