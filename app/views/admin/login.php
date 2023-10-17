<?php require APPROOT . '/views/inc/header.php'; ?>
<header class="pb-3 mb-4 border-bottom" style="margin-top:10px">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <span class="fs-4" style="text-align: center;">Log Masuk</span>
    </a>
</header>
<div class="form-container" style="padding-left: 25%;padding-right:25%">
    <img style="position: relative;left:35%;margin-bottom:4px;" src="https://d1fdloi71mui9q.cloudfront.net/LZ4ym0mAQjWBAdg21hA9_q976wtAHHvgJ71vl" width="150" height="150" alt="khallegacy_brand">
    <br>
    <?php flash('admin_register_success');  ?>
    <form action="<?php echo URLROOT; ?>/admins/login" method="POST" >
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input value="<?php echo $data['name']; ?>" type="text" class="form-control <?php if(!empty($data['name_err'])) echo 'is-invalid'; ?>" name="name">
            <?php if(!empty($data['name_err'])): ?>
                <p style="color: red;"><?php echo $data['name_err']; ?></p>
            <?php endif ?>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Kata Laluan</label>
            <input value="<?php echo $data['password']; ?>" type="password" class="form-control <?php if(!empty($data['password_err'])) echo 'is-invalid'; ?>" name="password">
            <?php if(!empty($data['password_err'])): ?>
                <p style="color: red;"><?php echo $data['password_err']; ?></p>
            <?php endif ?>
        </div>
        
        <button type="submit" class="btn btn-outline-secondary">Masuk</button> <br> <br>
        <small class="text-muted"> <a href="<?php echo URLROOT; ?>/admins/register">Pentadbir baharu?</a></small>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>