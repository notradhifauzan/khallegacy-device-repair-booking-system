<?php require APPROOT . '/views/inc/header.php'; ?>
<header class="pb-3 mb-4 border-bottom" style="margin-top:10px">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="https://d1fdloi71mui9q.cloudfront.net/LZ4ym0mAQjWBAdg21hA9_q976wtAHHvgJ71vl" width="40" height="40" class="me-2">
        <title>Daftar Pengguna</title>
        </img>
        <span class="fs-4">Daftar Pengguna</span>
    </a>
</header>
<div class="form-container" style="padding-left: 25%;padding-right:25%">
    <img src="" alt="">
    <form action="<?php echo URLROOT; ?>/customers/register" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama panggilan</label>
            <input value="<?php echo $data['name']; ?>" type="text" class="form-control <?php if (!empty($data['name_err'])) echo 'is-invalid'; ?>" name="name">
            <?php if (!empty($data['name_err'])) : ?>
                <p style="color: red;"><?php echo $data['name_err']; ?></p>
            <?php endif ?>
            <div id="emailHelp" class="form-text">Nama pengguna hendaklah mengandungi sekurang-kurangnya satu huruf besar dan satu nombor</div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">No Telefon</label>
            <input value="<?php echo $data['phone']; ?>" type="text" class="form-control <?php if (!empty($data['phone_err'])) echo 'is-invalid'; ?>" name="phone">
            <?php if (!empty($data['phone_err'])) : ?>
                <p style="color: red;"><?php echo $data['phone_err']; ?></p>
            <?php endif ?>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Emel</label>
            <input value="<?php echo $data['email']; ?>" type="text" class="form-control <?php if (!empty($data['email_err'])) echo 'is-invalid'; ?>" name="email">
            <?php if (!empty($data['email_err'])) : ?>
                <p style="color: red;"><?php echo $data['email_err']; ?></p>
            <?php endif ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata Laluan</label>
            <input value="<?php echo $data['password']; ?>" type="password" class="form-control <?php if (!empty($data['password_err'])) echo 'is-invalid'; ?>" name="password">
            <?php if (!empty($data['password_err'])) : ?>
                <p style="color: red;"><?php echo $data['password_err']; ?></p>
            <?php endif ?>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Sah Kata Laluan</label>
            <input value="<?php echo $data['confirm_password']; ?>" type="password" class="form-control <?php if (!empty($data['confirm_password_err'])) echo 'is-invalid'; ?>" name="confirm_password">
            <?php if (!empty($data['confirm_password_err'])) : ?>
                <p style="color: red;"><?php echo $data['confirm_password_err']; ?></p>
            <?php endif ?>
        </div>
        <button type="submit" class="btn btn-outline-secondary">Daftar Pengguna</button>
        <small class="text-muted">Pengguna sedia ada? <a href="<?php echo URLROOT; ?>/customers/login">Log masuk</a></small>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>