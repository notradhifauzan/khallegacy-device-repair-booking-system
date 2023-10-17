<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/admin_navbar.php'; ?>
<table id="allBookings" class="table table-striped caption-top" width="100%">
    <caption>Sejarah pesanan</caption>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tarikh</th>
            <th scope="col">Nama</th>
            <th scope="col">Nombor Tel.</th>
            <th scope="col">Status</th>
            <th scope="col">Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['bookings'] as $bookings) : ?>
            <?php $bookingDate = dateTimeConverter($bookings->datetime); ?>
            <!-- Modal -->
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
            <tr>
                <th scope="row"><?php echo $bookings->orderid; ?></th>
                <td><?php echo $bookingDate; ?></td>
                <td><?php echo $bookings->custname ?></td>
                <td><?php echo $bookings->custphone ?></td>
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
                <td><button onclick="location.href='<?php echo URLROOT; ?>/admins/viewOrder/<?php echo $bookings->orderid; ?>'" class="btn btn-sm btn-outline-primary"> Lihat</button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#allBookings').DataTable({
            "language": {
                "lengthMenu": "Papar _MENU_ rekod per halaman",
                "info": "Paparan _PAGE_ daripada _PAGES_ halaman",
                "infoEmpty": "Tiada rekod yang ditemui",
                "infoFiltered": "(disaring daripada jumlah _MAX_ rekod)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Seterusnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>