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
                    <i class="nav-icon fas fa-table"></i>
                    Transactions
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

                    <!-- Notifikasi Flashdata -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <!-- Table Transactions -->
                    <div class="card tab-pane card-secondary active" id="tableBooks">
                        <div class="card-header">
                            <h3 class="card-title">Table of Transactions</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table class="table table-head-fixed table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Status</th>
                                        <th>Judul Buku</th>
                                        <th style="width: 180px;">Tanggal Pinjam</th>
                                        <th style="width: 235px;">Tanggal Pengembalian</th>
                                        <th>Denda</th>
                                        <th style="width: 105px;" class="text-center">Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($transactions)): ?>
                                        <?php
                                        $no = 1;
                                        foreach ($transactions as $index => $item): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($item['status']) ?></td>
                                                <td><?= esc($item['judul_buku']) ?></td>
                                                <td><?= esc(date('d/m/Y', strtotime($item['tgl_pinjam']))); ?></td>
                                                <td><?= esc(date('d/m/Y', strtotime($item['tgl_pengembalian']))); ?></td>
                                                <td><?= esc($item['denda'] > 0 ? 'Rp ' . number_format($item['denda'], 0, ',', '.') : 'Rp 0') ?></td>
                                                <td>
                                                    <button class="btn-warning" data-toggle="modal"
                                                        data-target="#updateData<?= $index ?>">
                                                        <i class="nav-icon fas fa-pen" aria-hidden="true"></i>
                                                    </button>
                                                    <a href="<?php echo base_url('transactions/delete/' . $item['id']) ?>"
                                                        onclick="return confirm('Are you sure?')">
                                                        <button class="btn-danger">
                                                            <i class="nav-icon fas fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Form Update Data -->
                                            <form action="<?php echo base_url('transactions/update/' . $item['id']) ?>"
                                                name="input" method="post" enctype="multipart/form-data">
                                                <div class="modal fade" id="updateData<?= $index ?>" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Form Update Books</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Card Input Data -->
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select class="form-control formStatusUpdate"
                                                                            name="status" required>
                                                                            <option value="" disabled selected>-- Pilih Status
                                                                                --</option>
                                                                            <option value="pinjam" <?= $item['status'] === 'pinjam' ? 'selected' : '' ?>>Pinjam</option>
                                                                            <option value="pengembalian"
                                                                                <?= $item['status'] === 'pengembalian' ? 'selected' : '' ?>>Pengembalian</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Judul Buku</label>
                                                                        <select class="form-control formJudulBukuUpdate"
                                                                            name="id_buku" required>
                                                                            <option value="" disabled selected>-- Pilih Judul
                                                                                Buku --</option>
                                                                            <?php foreach ($books as $book): ?>
                                                                                <option value="<?= esc($book['id']) ?>"
                                                                                    <?= esc($book['id'] == $item['id_buku'] ? 'selected' : '') ?>             <?= esc($book['stok'] == 0 ? 'disabled' : '') ?>>
                                                                                    <?= esc($book['judul']) ?> (Stok:
                                                                                    <?= esc($book['stok']) ?>
                                                                                    <?= $book['stok'] == 0 ? '| Buku tidak bisa dipinjam' : '' ?>)
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Pinjam</label>
                                                                        <input type="date"
                                                                            class="form-control formTglPinjamUpdate"
                                                                            name="tgl_pinjam"
                                                                            value="<?= esc($item['tgl_pinjam']) ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Pengembalian</label>
                                                                        <input type="date"
                                                                            class="form-control formTglPengembalianUpdate"
                                                                            name="tgl_pengembalian"
                                                                            value="<?= esc($item['tgl_pengembalian']) ?>">
                                                                        <small
                                                                            class="form-text text-primary notifTglPengembalianUpdate"
                                                                            style="display: none;">
                                                                            Tanggal pengembalian otomatis terisi 7 hari setelah
                                                                            tanggal pinjam.
                                                                        </small>
                                                                        <small
                                                                            class="form-text text-danger notifPengembalianManualUpdate"
                                                                            style="display: none;">
                                                                            Isi tanggal pengembalian secara manual jika
                                                                            statusnya <b>"Pengembalian"</b>.
                                                                        </small>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Denda (RP)</label>
                                                                        <input type="number"
                                                                            class="form-control formDendaUpdate" name="denda"
                                                                            value="<?= esc($item['denda']) ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        <?php endforeach; ?>
                                    <?php else: ?>
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
                            <?= $transactionscount; ?> Total Data
                        </div>

                    </div>

                    <!-- Form Input Data -->
                    <div class="card tab-pane card-secondary" id="createBooks">
                        <div class="card-header">
                            <h3 class="card-title">Form Input Transactions</h3>
                        </div>
                        <!-- form start -->
                        <form action="<?php echo base_url('transactions/save') ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select id="formStatus" class="form-control" name="status" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="pinjam">Pinjam</option>
                                        <option value="pengembalian">Pengembalian</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <select id="formJudulBuku" class="form-control" name="id_buku" required>
                                        <option value="" disabled selected>-- Pilih Judul Buku --</option>
                                        <?php foreach ($books as $item): ?>
                                            <option value="<?= esc($item['id']) ?>" data-stok="<?= esc($item['stok']) ?>">
                                                <?= esc($item['judul']) ?> (Stok: <?= esc($item['stok']) ?>
                                                <?= $item['stok'] == 0 ? '| Buku tidak bisa dipinjam' : '' ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" id="formTglPinjam" class="form-control" name="tgl_pinjam"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengembalian</label>
                                    <input type="date" id="formTglPengembalian" class="form-control"
                                        name="tgl_pengembalian">
                                    <small id="notifTglPengembalian" class="form-text text-primary"
                                        style="display: none;">
                                        Tanggal pengembalian otomatis terisi 7 hari setelah tanggal pinjam.
                                    </small>
                                    <small id="notifPengembalianManual" class="form-text text-danger"
                                        style="display: none;">
                                        Isi tanggal pengembalian secara manual jika statusnya <b>"Pengembalian"</b>.
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>Denda (RP)</label>
                                    <input type="number" id="formDenda" class="form-control" name="denda" value="0"
                                        readonly>
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

<!-- [Input] JavaScript Setup Tanggal Pengembalian & Perhitungan Denda -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tglPinjamInput = document.getElementById("formTglPinjam");
        const tglPengembalianInput = document.getElementById("formTglPengembalian");
        const dendaInput = document.getElementById("formDenda");
        const notifTglPengembalian = document.getElementById("notifTglPengembalian");
        const notifPengembalianManual = document.getElementById("notifPengembalianManual");
        const statusInput = document.getElementById("formStatus");
        const judulBukuInput = document.getElementById("formJudulBuku");
        const options = judulBukuInput.options;

        // Fungsi untuk mengatur tanggal pengembalian otomatis
        function setTanggalPengembalian() {
            if (statusInput.value === "pinjam" && tglPinjamInput.value) {
                const tglPinjam = new Date(tglPinjamInput.value);
                if (!isNaN(tglPinjam)) {
                    const tglPengembalian = new Date(tglPinjam);
                    tglPengembalian.setDate(tglPengembalian.getDate() + 7);
                    tglPengembalianInput.value = tglPengembalian.toISOString().split("T")[0];
                    notifTglPengembalian.style.display = "block";
                }
            }
        }

        // Fungsi untuk menghitung denda
        function hitungDenda() {
            if (statusInput.value === "pengembalian" && tglPinjamInput.value && tglPengembalianInput.value) {
                const tglPinjam = new Date(tglPinjamInput.value);
                const tglPengembalian = new Date(tglPengembalianInput.value);

                // Validasi: Tanggal pengembalian tidak boleh mundur dari tanggal pinjam
                if (tglPengembalian < tglPinjam) {
                    alert("Tidak bisa memilih tanggal pengembalian lebih awal dari tanggal peminjaman.");
                    tglPengembalianInput.value = ""; // Reset nilai tanggal pengembalian
                    dendaInput.value = 0; // Reset nilai denda
                    return;
                }

                if (!isNaN(tglPinjam) && !isNaN(tglPengembalian)) {
                    const selisihHari = Math.ceil((tglPengembalian - tglPinjam) / (1000 * 60 * 60 * 24));
                    if (selisihHari > 7) {
                        const denda = (selisihHari - 7) * 1000; // Denda Rp1000 per hari
                        dendaInput.value = denda;
                    } else {
                        dendaInput.value = 0;
                    }
                }
            } else {
                dendaInput.value = 0;
            }
        }

        // Fungsi untuk memperbarui opsi judul buku
        function updateJudulBukuOptions() {
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const stok = parseInt(option.getAttribute("data-stok"));
                if (option.value === "") continue; // Abaikan opsi default

                if (statusInput.value === "pinjam") {
                    option.disabled = stok === 0;
                } else {
                    option.disabled = false;
                }
            }
        }

        // Fungsi untuk memperbarui form berdasarkan status
        function updateForm() {
            if (statusInput.value === "pinjam") {
                tglPengembalianInput.setAttribute("readonly", "readonly");
                notifTglPengembalian.style.display = "block";
                notifPengembalianManual.style.display = "none";
                setTanggalPengembalian();
            } else {
                tglPengembalianInput.removeAttribute("readonly");
                notifTglPengembalian.style.display = "none";
                notifPengembalianManual.style.display = "block";
            }
            updateJudulBukuOptions();
            hitungDenda(); // Hitung denda saat form diperbarui
        }

        // Event listeners
        statusInput.addEventListener("change", updateForm);
        tglPinjamInput.addEventListener("change", function () {
            setTanggalPengembalian();
            hitungDenda(); // Hitung denda jika tanggal pinjam diubah
        });
        tglPengembalianInput.addEventListener("change", function () {
            const tglPinjam = new Date(tglPinjamInput.value);
            const tglPengembalian = new Date(tglPengembalianInput.value);

            // Validasi: Tanggal pengembalian tidak boleh mundur dari tanggal pinjam
            if (tglPengembalian < tglPinjam) {
                alert("Tidak bisa memilih tanggal pengembalian lebih awal dari tanggal peminjaman.");
                tglPengembalianInput.value = ""; // Reset nilai tanggal pengembalian
                dendaInput.value = 0; // Reset nilai denda
                return;
            }

            hitungDenda(); // Hitung denda jika validasi lolos
        });

        // Set kondisi awal
        updateForm();
    });
</script>

<!-- [Update] JavaScript Setup Tanggal Pengembalian & Perhitungan Denda -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil semua elemen form berdasarkan class
        const rows = document.querySelectorAll(".card-body");

        rows.forEach((row) => {
            const tglPinjamInput = row.querySelector(".formTglPinjamUpdate");
            const tglPengembalianInput = row.querySelector(".formTglPengembalianUpdate");
            const dendaInput = row.querySelector(".formDendaUpdate");
            const notifTglPengembalian = row.querySelector(".notifTglPengembalianUpdate");
            const notifPengembalianManual = row.querySelector(".notifPengembalianManualUpdate");
            const statusInput = row.querySelector(".formStatusUpdate");

            // Fungsi untuk validasi tanggal pengembalian
            function validateTanggalPengembalian() {
                const tglPinjam = new Date(tglPinjamInput.value);
                const tglPengembalian = new Date(tglPengembalianInput.value);

                if (tglPengembalianInput.value && tglPengembalian < tglPinjam) {
                    alert("Tidak bisa memilih tanggal pengembalian lebih awal dari tanggal peminjaman.");
                    tglPengembalianInput.value = ""; // Reset nilai tanggal pengembalian
                    dendaInput.value = 0; // Reset nilai denda
                }
            }

            // Fungsi untuk menghitung denda
            function hitungDenda() {
                if (statusInput.value === "pengembalian" && tglPinjamInput.value && tglPengembalianInput.value) {
                    const tglPinjam = new Date(tglPinjamInput.value);
                    const tglPengembalian = new Date(tglPengembalianInput.value);

                    if (!isNaN(tglPinjam) && !isNaN(tglPengembalian)) {
                        const selisihHari = Math.ceil((tglPengembalian - tglPinjam) / (1000 * 60 * 60 * 24));
                        if (selisihHari > 7) {
                            const denda = (selisihHari - 7) * 1000; // Denda Rp1000 per hari
                            dendaInput.value = denda;
                        } else {
                            dendaInput.value = 0;
                        }
                    }
                } else {
                    dendaInput.value = 0;
                }
            }

            // Fungsi untuk memperbarui form berdasarkan status
            function updateForm() {
                if (statusInput.value === "pinjam") {
                    tglPengembalianInput.setAttribute("readonly", "readonly");
                    notifTglPengembalian.style.display = "block";
                    notifPengembalianManual.style.display = "none";
                } else {
                    tglPengembalianInput.removeAttribute("readonly");
                    notifTglPengembalian.style.display = "none";
                    notifPengembalianManual.style.display = "block";
                }
                hitungDenda();
            }

            // Event listeners untuk setiap baris
            statusInput.addEventListener("change", updateForm);
            tglPinjamInput.addEventListener("change", function () {
                updateForm();
                validateTanggalPengembalian();
            });
            tglPengembalianInput.addEventListener("change", function () {
                validateTanggalPengembalian();
                hitungDenda();
            });

            // Set kondisi awal untuk setiap baris
            updateForm();
        });
    });
</script>