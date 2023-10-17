<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/cust_navbar.php'; ?>

<?php flash('order_success'); ?>
<?php flash('order_fail'); ?>
<?php flash('cancel_success'); ?>
<?php flash('cancel_fail'); ?>
<?php flash('payment_success'); ?>
<?php flash('payment_fail'); ?>
<?php flash('cash_success'); ?>
<?php flash('cash_fail'); ?>

<table class="table caption-top">
    <caption>Pesanan saya</caption>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tarikh</th>
            <th scope="col">Jenama peranti</th>
            <th scope="col">Model peranti</th>
            <th scope="col">Info</th>
            <th scope="col">Staf</th>
            <th scope="col">Status</th>
            <th scope="col">RM</th>
            <th scope="col">Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['bookings'] as $bookings) : ?>
            <?php $bookingDate = dateTimeConverter($bookings->datetime); ?>
            <!-- Modal (to view problem description and phone image) -->
            <div class="modal fade" id="order<?php echo $bookings->orderid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Maklumat tambahan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control mb-3" disabled name="" id="" cols="30" rows="3"><?php echo $bookings->problem_description; ?></textarea>
                            <?php if (!empty($bookings->img_address)) : ?>
                                <img width="100%" height="100%" style="text-align: center;" src="<?php echo URLROOT; ?>/img/uploads/<?php echo $bookings->img_address; ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of modal -->

            <!-- Modal for order cancellation -->
            <div class="modal fade" id="cancel<?php echo $bookings->orderid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Pesanan #<?php echo $bookings->orderid; ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h4>Sahkan pembatalan?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            <button onclick="location.href='<?php echo URLROOT; ?>/customers/cancelOrder/<?php echo $bookings->orderid; ?>'" type="button" class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-trash-can"></i> Batal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal to choose payment method -->
            <div class="modal fade" id="method<?php echo $bookings->orderid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih mod pembayaran</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Mod pembayaran : <button onclick="location.href='<?php echo URLROOT; ?>/customers/cashPayment/<?php echo $bookings->orderid; ?>'" class="btn btn-sm btn-outline-success">Tunai</button> <button onclick="location.href='<?php echo URLROOT; ?>/customers/onlinePayment/<?php echo $bookings->orderid; ?>'" class="btn btn-sm btn-outline-warning">Transaksi atas talian</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <tr>
                <th scope="row"><?php echo $bookings->orderid; ?></th>
                <td><?php echo $bookingDate; ?></td>
                <td><?php echo $bookings->phone_brand ?></td>
                <td><?php echo $bookings->phone_model ?></td>
                <td><button data-bs-toggle="modal" data-bs-target="#order<?php echo $bookings->orderid; ?>" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-info"></i> Klik</button></td>
                <td>
                    <?php if (empty($bookings->staffname)) : ?>
                        <small class="text-muted">Tiada maklumat</small>
                    <?php else : ?>
                        <?php echo $bookings->staffname; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($bookings->order_status == 'hantar') : ?>
                        <span class="badge rounded-pill text-bg-light"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'diterima') : ?>
                        <span class="badge rounded-pill text-bg-secondary"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'dibaiki') : ?>
                        <span class="badge rounded-pill text-bg-primary"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'siap') : ?>
                        <span class="badge rounded-pill text-bg-info"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'semakan') : ?>
                        <span class="badge rounded-pill text-bg-warning"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'ambil') : ?>
                        <span class="badge rounded-pill text-bg-primary"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'tidak sah') : ?>
                        <span class="badge rounded-pill text-bg-danger"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'selesai') : ?>
                        <span class="badge rounded-pill text-bg-success"><?php echo $bookings->order_status; ?></span>
                    <?php elseif ($bookings->order_status == 'terbatal') : ?>
                        <span class="badge rounded-pill text-bg-danger"><?php echo $bookings->order_status; ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (empty($bookings->order_price)) : ?>
                        <small class="text-muted">Tiada maklumat</small>
                    <?php else : ?>
                        <?php echo $bookings->order_price; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($bookings->order_status == 'hantar' || $bookings->order_status == 'diterima') : ?>
                        <button data-bs-toggle="modal" data-bs-target="#cancel<?php echo $bookings->orderid; ?>" class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-trash-can"></i> Batal</button>
                    <?php elseif ($bookings->order_status == 'siap') : ?>
                        <button data-bs-toggle="modal" data-bs-target="#method<?php echo $bookings->orderid; ?>" type="button" class="btn btn-sm btn-outline-success">Bayar</button>
                    <?php elseif ($bookings->order_status == 'tidak sah') : ?>
                        <button data-bs-toggle="modal" data-bs-target="#method<?php echo $bookings->orderid; ?>" type="button" class="btn btn-sm btn-outline-success">Bayar</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>