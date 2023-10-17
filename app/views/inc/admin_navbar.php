<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="https://d1fdloi71mui9q.cloudfront.net/LZ4ym0mAQjWBAdg21hA9_q976wtAHHvgJ71vl" class="bi me-2" width="40" height="40" role="img" aria-label="Bootstrap"></img>
            <span class="fs-4">Pentadbir</span>
        </a>
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="<?php echo URLROOT; ?>/admins/bookings" class="nav-link px-2 <?php if(isset($_SESSION['current_method']) && $_SESSION['current_method']=='tempahan') echo 'link-secondary'; else echo 'link-dark';?>">Tempahan</a></li>
            <li><a href="<?php echo URLROOT; ?>/admins/report" class="nav-link px-2 <?php if(isset($_SESSION['current_method']) && $_SESSION['current_method']=='laporan') echo 'link-secondary'; else echo 'link-dark';?>">Laporan</a></li>
            <li><a href="<?php echo URLROOT; ?>/admins/history" class="nav-link px-2 <?php if(isset($_SESSION['current_method']) && $_SESSION['current_method']=='sejarah') echo 'link-secondary'; else echo 'link-dark';?>">Sejarah</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2"><?php echo $_SESSION['currentUser']->nama; ?></button>
            <button onclick="location.href='<?php echo URLROOT; ?>/admins/logout'" type="button" class="btn btn-secondary">Log-keluar</button>
        </div>
    </header>
</div>