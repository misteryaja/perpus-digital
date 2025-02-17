<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?= $header; ?></h1>
                </div>
                <div class="col-sm-6 d-none d-sm-block">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><?= $header; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="nav-icon fas fa-book"></i>
                    Books
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tableBooks" data-toggle="tab">Table</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#createBooks" data-toggle="tab">Create</a>
                        </li>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <!-- Table Books -->
                    <div class="card tab-pane card-secondary active" id="tableBooks">
                        <div class="card-header">
                            <h3 class="card-title">Table of Books</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table class="table table-head-fixed table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Judul Buku</th>
                                        <th>Penerbit</th>
                                        <th>Tanggal Terbit</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th style="width: 105px;" class="text-center">Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($books)) : ?>
                                        <?php
                                        $no = 1;
                                        foreach ($books as $index => $item) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($item['judul']) ?></td>
                                                <td><?= esc($item['penerbit']) ?></td>
                                                <td><?= esc(date('d/m/Y', strtotime($item['tgl_terbit']))); ?></td>
                                                <td><?= esc($item['kategori']) ?></td>
                                                <td><?= esc($item['stok']) ?></td>
                                                <td>
                                                    <button class="btn-warning" data-toggle="modal" data-target="#updateData<?= $index ?>">
                                                        <i class="nav-icon fas fa-pen" aria-hidden="true"></i>
                                                    </button>
                                                    <a href="<?php echo base_url('books/delete/' . $item['id']) ?>" onclick="return confirm('Are you sure?')">
                                                        <button class="btn-danger">
                                                            <i class="nav-icon fas fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Form Update Data -->
                                            <form action="<?php echo base_url('books/update/' . $item['id']) ?>" name="input" method="post" enctype="multipart/form-data">
                                                <div class="modal fade" id="updateData<?= $index ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Form Update Books</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Card Input Data -->
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="formJudul">Judul Buku</label>
                                                                        <input type="text" id="formJudul" placeholder="Masukkan Judul Buku" class="form-control" name="judul" value="<?= esc($item['judul']) ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="formPenerbit">Penerbit</label>
                                                                        <input type="text" id="formPenerbit" placeholder="Masukkan Penerbit" class="form-control" name="penerbit" value="<?= esc($item['penerbit']) ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="formTglTerbit">Tanggal Terbit</label>
                                                                        <input type="date" id="formTglTerbit" class="form-control" name="tgl_terbit" value="<?= esc($item['tgl_terbit']) ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kategori</label>
                                                                        <select class="form-control" name="kategori" required>
                                                                            <option value="" disabled <?= !$item['kategori'] ? 'selected' : '' ?>>-- Pilih Kategori --</option>
                                                                            <option value="romance" <?= $item['kategori'] === 'romance' ? 'selected' : '' ?>>Romance</option>
                                                                            <option value="horror" <?= $item['kategori'] === 'horror' ? 'selected' : '' ?>>Horror</option>
                                                                            <option value="fiksi" <?= $item['kategori'] === 'fiksi' ? 'selected' : '' ?>>Fiksi</option>
                                                                            <option value="pendidikan" <?= $item['kategori'] === 'pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="formStok">Stok</label>
                                                                        <input type="number" id="formStok" placeholder="Masukkan Stok" class="form-control" name="stok" value="<?= esc($item['stok']) ?>" required>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <!-- Jika Tidak Ada Data -->
                                        <tr>
                                            <td colspan="7" class="text-center">No Books Found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <?= $bookscount; ?> Total Data
                        </div>

                    </div>

                    <!-- Form Input Data -->
                    <div class="card tab-pane card-secondary" id="createBooks">
                        <div class="card-header">
                            <h3 class="card-title">Form Input Books</h3>
                        </div>
                        <!-- form start -->
                        <form action="<?php echo base_url('books/save') ?>"method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="formJudul">Judul Buku</label>
                                    <input type="text" id="formJudul" placeholder="Masukkan Judul Buku" class="form-control" name="judul" required>
                                </div>
                                <div class="form-group">
                                    <label for="formPenerbit">Penerbit</label>
                                    <input type="text" id="formPenerbit" placeholder="Masukkan Penerbit" class="form-control" name="penerbit" required>
                                </div>
                                <div class="form-group">
                                    <label for="formTglTerbit">Tanggal Terbit</label>
                                    <input type="date" id="formTglTerbit" class="form-control" name="tgl_terbit" required>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control" name="kategori" required>
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        <option value="romance" <?= set_select('kategori', 'romance'); ?>>Romance</option>
                                        <option value="horror" <?= set_select('kategori', 'horror'); ?>>Horror</option>
                                        <option value="fiksi" <?= set_select('kategori', 'fiksi'); ?>>Fiksi</option>
                                        <option value="pendidikan" <?= set_select('kategori', 'pendidikan'); ?>>Pendidikan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="formStok">Stok</label>
                                    <input type="number" id="formStok" placeholder="Masukkan Stok" class="form-control" name="stok" required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>