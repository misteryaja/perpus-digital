<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success">You are now logged out.</div>
<?php endif; ?>

<form action="<?php echo base_url('login') ?>" method="post">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Username" name="username" value="<?= set_value('username') ?>" required>
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
    <div class="text-center mt-2 mb-3">
        <button type="submit" class="btn bg-gray-dark btn-block">Login</button>
    </div>
</form>
<p class="mb-1 text-dark">Does not have an account? <a href="<?php echo base_url('register') ?>">Register here</a></p>