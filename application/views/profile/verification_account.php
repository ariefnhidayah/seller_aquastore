<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= lang('verification_page') ?></h1>
  </div>

  <div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('profile') ?>"><?= lang('profile') ?></a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('profile/change_password') ?>" class="nav-link"><?= lang('change_password') ?></a>
            </li>
            <?php if ($seller->status == 'non-active') : ?>
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0)"><?= lang('verification_account') ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="col-sm-12 mt-4">
        <form action="" method="post">
            <div class="card">
              <div class="card-body">

                <?php if ($this->session->flashdata('message_success')) : ?>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="alert alert-success">
                      <?= $this->session->flashdata('message_success') ?>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('message_error')) : ?>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="alert alert-danger">
                      <?= $this->session->flashdata('message_error') ?>
                    </div>
                  </div>
                </div>
                <?php endif; ?>

                <div class="row">
                  <div class="col-sm-4">
                    <label><?= lang('verification_code') ?></label>
                    <input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="<?= lang('verification_code_placeholder') ?>" />
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col">
                    <button type="submit" class="btn btn-primary"><?= lang('send') ?></button>
                    <button class="btn btn-secondary" type="button" id="resend_code"><?= lang('resend') ?></button>
                  </div>
                </div>
              </div>
            </div>
        </form>
    </div>
  </div>

</div>