<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('register') ?>" method="post">
    <?= csrf_field(); ?>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Full Name" name="name" value="<?= set_value('name'); ?>" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Username" name="username" value="<?= set_value('username'); ?>" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirm" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <select class="form-control" name="role" required>
            <option value="" disabled selected>-- Select Role --</option>
            <option value="admin" <?= set_select('role', 'admin'); ?>>Admin</option>
            <option value="petugas" <?= set_select('role', 'petugas'); ?>>Petugas</option>
            <option value="peminjam" <?= set_select('role', 'peminjam'); ?>>Peminjam</option>
        </select>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-bars"></span>
            </div>
        </div>
    </div>
    <div class="text-center mt-2 mb-3">
        <button type="submit" class="btn bg-gray-dark btn-block">Register</button>
    </div>
</form>

<p class="mb-1 text-dark">Already have an account? <a href="<?php echo base_url('login') ?>">Login here</a></p>