<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/cust_navbar.php'; ?>
<main>
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="<?php echo URLROOT; ?>/img/logo.png" alt="" width="72" height="72">
        <h2>Borang pesanan e-baiki peranti</h2>
    </div>

    <div class="row g-5">

        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Sila isi borang tempahan di bawah</h4>
            <form action="<?php echo URLROOT; ?>/customers/bookings" class="needs-validation" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="brand" class="form-label">Jenama peranti</label>
                        <input type="text" class="form-control <?php if (!empty($data['brand_err'])) echo 'is-invalid'; ?>" name="brand" placeholder="" value="<?php echo $data['brand'] ?>" required>
                        <div class="invalid-feedback">
                            <?php echo $data['brand_err']; ?>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Model peranti</label>
                        <input type="text" class="form-control <?php if (!empty($data['model_err'])) echo 'is-invalid'; ?>" name="model" placeholder="" value="<?php echo $data['model'] ?>" required>
                        <div class="invalid-feedback">
                            <?php echo $data['model_err']; ?>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="description" class="form-label">Nyatakan masalah berkaitan peranti anda</label>
                        <textarea class="form-control <?php if (!empty($data['description_err'])) echo 'is-invalid'; ?>" name="description" placeholder="" required><?php echo $data['description'] ?></textarea>
                        <div class="invalid-feedback">
                            <?php echo $data['description_err']; ?>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="image-input" class="form-label">Gambar kondisi peranti <small class="text-muted">jika berkaitan</small></label>
                        <input type="file" name="image" accept="image/*" class="form-control <?php if (!empty($data['img_err'])) echo 'is-invalid'; ?>">
                        <div class="invalid-feedback">
                            <?php echo $data['img_err']; ?>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-sm" type="submit">Hantar pesanan</button>
            </form>
        </div>
    </div>
</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>