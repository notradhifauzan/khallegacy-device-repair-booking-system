<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <img src="<?php echo URLROOT; ?>/img/logo.png" class="bi me-2" width="40" height="40" role="img" aria-label="Bootstrap"></img>
      </a>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="<?php echo URLROOT; ?>/customers/home" class="nav-link px-2 <?php if(isset($_SESSION['current_method']) && $_SESSION['current_method']=='home') echo 'link-secondary'; else echo 'link-dark';?>">Laman utama</a></li>
        <li><a href="<?php echo URLROOT; ?>/customers/bookings" class="nav-link px-2 <?php if(isset($_SESSION['current_method']) && $_SESSION['current_method']=='tempahan') echo 'link-secondary'; else echo 'link-dark';?>">Tempahan</a></li>
        <li><a href="<?php echo URLROOT; ?>/customers/myBookings" class="nav-link px-2 <?php if(isset($_SESSION['current_method']) && $_SESSION['current_method']=='pesanan') echo 'link-secondary'; else echo 'link-dark';?>">Pesanan</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
      </ul>

      <div class="col-md-3 text-end">
        <button type="button" class="btn btn-sm btn-outline-primary me-2"><?php echo $_SESSION['currentUser']->nama; ?></button>
        <button onclick="location.href='<?php echo URLROOT; ?>/customers/logout'" type="button" class="btn btn-sm btn-secondary">Log-keluar</button>
      </div>
    </header>
  </div>