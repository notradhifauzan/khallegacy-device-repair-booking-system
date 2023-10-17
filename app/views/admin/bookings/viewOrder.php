<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/admin_navbar.php'; ?>
<main>
    <?php flash('update_fail'); ?>
    <!-- Modal gambar phone -->
    <div class="modal fade" id="phone_photo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Gambar peranti</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($data['order']->img_address)) : ?>
                        <img width="100%" height="100%" style="text-align: center;" src="<?php echo URLROOT; ?>/img/uploads/<?php echo $data['order']->img_address; ?>" alt="">
                    <?php else : ?>
                        <p class="text-muted" style="text-align: center;">Tiada gambar tersedia</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->

    <!-- Modal for viewing payment receipt -->
    <div class="modal fade" id="receipt_photo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Resit pembayaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($data['order']->receipt_img)) : ?>
                        <img width="100%" height="100%" style="text-align: center;" src="<?php echo URLROOT; ?>/img/receipts/<?php echo $data['order']->receipt_img; ?>" alt="">
                    <?php else : ?>
                        <p class="text-muted" style="text-align: center;">Tiada gambar tersedia</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->

    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Informasi pelanggan</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Nama: <?php echo $data['order']->custname; ?> </h6>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Telefon: <?php echo $data['order']->custphone; ?></h6>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Emel: <?php echo $data['order']->custmail; ?></h6>
                    </div>
                </li>
            </ul>
            <div class="input-group mb-3">
                <input disabled type="text" class="form-control" placeholder="Status pesanan">
                <button disabled type="button" class="btn 
                <?php if ($data['order']->order_status == 'hantar') : ?>
                    text-bg-light
                <?php elseif ($data['order']->order_status == 'diterima') : ?>
                    text-bg-secondary
                <?php elseif ($data['order']->order_status == 'dibaiki') : ?>
                    text-bg-primary
                <?php elseif ($data['order']->order_status == 'siap') : ?>
                    text-bg-info
                <?php elseif ($data['order']->order_status == 'semakan') : ?>
                    text-bg-warning
                <?php elseif ($data['order']->order_status == 'ambil') : ?>
                    text-bg-primary
                <?php elseif ($data['order']->order_status == 'tidak sah') : ?>
                    text-bg-danger
                <?php elseif ($data['order']->order_status == 'selesai') : ?>
                    text-bg-success
                <?php elseif ($data['order']->order_status == 'terbatal') : ?>
                    text-bg-danger
                <?php endif; ?>
                "><?php echo $data['order']->order_status; ?></button>
            </div>
            <?php if (!empty($data['order']->receipt_img)) : ?>
                <div class="input-group">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#receipt_photo" class="btn btn-outline-secondary"><i class="fa-regular fa-image"></i> Lihat</button>
                    <input disabled type="text" class="form-control" placeholder="Resit bayaran">
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Pesanan #<?php echo $data['order']->orderid; ?></h4>
            <form action="<?php echo URLROOT; ?>/admins/updateOrder/<?php echo $data['order']->orderid; ?>" class="needs-validation" method="POST">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">Jenama peranti</label>
                        <input disabled type="text" class="form-control" placeholder="" value="<?php echo $data['order']->phone_brand; ?>" required>
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Model peranti</label>
                        <input disabled type="text" class="form-control" placeholder="" value="<?php echo $data['order']->phone_model; ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="problem" class="form-label">Penyata masalah</label>
                        <div class="input-group has-validation mb-1">
                            <textarea disabled class="form-control" name="" id="problem" cols="30" rows="2"><?php echo $data['order']->problem_description; ?></textarea>
                        </div>
                        Gambar Peranti <button data-bs-toggle="modal" data-bs-target="#phone_photo" type="button" class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-image"></i> klik</button>
                    </div>
                </div>

                <hr>
                <h4 class="mb-3">Kemaskini pesanan</h4>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">Harga (RM)</label>
                        <input name="price" type="number" class="form-control" placeholder="" value="<?php if (isset($data['price'])) echo $data['price'];
                                                                                                        else echo $data['order']->order_price; ?>" required>
                        <div class="invalid-feedback">
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="problem" class="form-label">Nota</label>
                        <div class="input-group has-validation mb-1">
                            <textarea required class="form-control" name="remarks" cols="30" rows="2"><?php if (isset($data['remarks'])) echo $data['remarks'];
                                                                                                        else echo $data['order']->order_remarks; ?></textarea>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <label for="problem" class="form-label">Kemaskini status</label>
                        <div class="input-group has-validation mb-1">
                            <select name="status" class="form-select form-select-sm <?php if (isset($data['status_err']) && !empty($data['status_err'])) echo 'is-invalid'; ?>" aria-label=".form-select-sm example">
                                <option selected value="0">Pilih satu</option>
                                <option value="diterima">diterima</option>
                                <option value="dibaiki">dibaiki</option>
                                <option value="siap">siap</option>
                                <option value="semakan">semakan</option>
                                <option value="ambil">ambil</option>
                                <option value="tidak sah">tidak sah</option>
                                <option value="selesai">selesai</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                </div>

                <button <?php if($data['order']->order_status=='selesai' || $data['order']->order_status=='terbatal') echo 'disabled'; ?> class="w-80 btn btn-success btn-sm" type="submit">Kemaskini</button>
            </form>
        </div>
    </div>
</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>