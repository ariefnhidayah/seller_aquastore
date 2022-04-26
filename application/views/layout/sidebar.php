  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php $seller = $this->session->userdata('seller'); ?>

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?= $seller->store_name ?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?= $menu == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span><?= lang('dashboard') ?></span></a>
      </li>

      <li class="nav-item <?= $menu == 'product' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('product') ?>">
          <i class="fas fa-fw fa-file"></i>
          <span><?= lang('product') ?></span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none my-0 d-md-block">

      <li class="nav-item <?= $menu == 'profile' ? 'active' : '' ?>">
        <a href="<?= base_url('profile') ?>" class="nav-link">
          <i class="fas fa-user-alt"></i>
          <span><?= lang('profile') ?></span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->