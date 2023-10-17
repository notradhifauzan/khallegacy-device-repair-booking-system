<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/cust_navbar.php'; ?>
<main>
    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Jenama peranti</h6>
                    </div>
                    <span class="text-muted"><?php echo $data['order']->phone_brand; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Model peranti</h6>
                    </div>
                    <span class="text-muted"><?php echo $data['order']->phone_model; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Staf bertugas</h6>
                    </div>
                    <span class="text-muted"><?php echo $data['order']->staffname; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>JUMLAH (RM)</span>
                    <strong>RM&nbsp;<?php echo $data['order']->order_price; ?></strong>
                </li>
            </ul>

        </div>
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Pembayaran atas talian</h4>
            <form action="<?php echo URLROOT; ?>/customers/onlinePayment/<?php echo $data['order']->orderid; ?>" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="order" class="form-label">ID Pesanan: </label>
                        <input disabled type="text" class="form-control" id="order" placeholder="" value="<?php echo $data['order']->orderid; ?>" required>
                    </div>

                    <div class="card">
                        <h5 class="card-header">NO. AKAUN </h5>
                        <div class="card-body">
                            <h5 class="card-title">MAYBANK 551584060895</h5>
                            <p class="card-text">KHAL LEGACY TRADING</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="image-input" class="form-label">Muat naik resit pembayaran</label>
                            <input type="file" name="image" accept="image/*" class="form-control form-control-sm <?php if (!empty($data['img_err'])) echo 'is-invalid'; ?>">
                            <div class="invalid-feedback">
                                <?php echo $data['img_err']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-sm" type="submit">Hantar</button>
            </form>
        </div>
    </div>
</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>