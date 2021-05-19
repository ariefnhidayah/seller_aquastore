    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <?php $seller = $this->session->userdata('seller'); ?>

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <?php if ($seller->status == 'non-active') : ?>
            <ul class="navbar-nav mr-auto">
              <div class="alert alert-danger" style="margin-bottom:0px;">
                Harap aktivasi akun anda <a href="<?= base_url('profile/verification_account') ?>">disini!</a>
              </div>
            </ul>
          <?php endif; ?>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="<?= base_url('assets/admin/') ?>#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $seller->name ?></span>
                <img class="img-profile rounded-circle" src="https://www.searchpng.com/wp-content/uploads/2019/02/Profile-ICon.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a href="<?= base_url('profile') ?>" class="dropdown-item">
                  <i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  <?= lang('profile') ?>
                </a>
                <a class="dropdown-item" href="<?= base_url('assets/admin/') ?>#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->