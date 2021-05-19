<style>
    .text-danger {
        margin-left:0px !important;
        margin-bottom: 0px !important;
    }
</style>
<div class="container">

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-12 col-md-10">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?= lang('register_page') ?></h1>
                                </div>
                                <?php if($this->session->flashdata('error')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('error'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <form class="user" method="POST" action="">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <span class="font-weight-bold">1. <?= lang('personal_information') ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label><?= lang('name') ?></label>
                                            <input type="text" name="name" id="name" class="form-control <?= form_error('name') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('name_placeholder') ?>" value="<?= set_value('name') ?>">
                                            <?= form_error('name') ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?= lang('store_name') ?></label>
                                            <input type="text" name="store_name" id="store_name" class="form-control <?= form_error('store_name') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('store_name_placeholder') ?>" value="<?= set_value('store_name') ?>">
                                            <?= form_error('store_name') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label><?= lang('email') ?></label>
                                            <input type="email" name="email" id="email" class="form-control <?= form_error('email') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('email_placeholder') ?>" value="<?= set_value('email') ?>">
                                            <?= form_error('email') ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?= lang('phone') ?></label>
                                            <input type="text" name="phone" id="phone" class="form-control <?= form_error('phone') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('phone_placeholder') ?>" value="<?= set_value('phone') ?>">
                                            <?= form_error('phone') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label><?= lang('password') ?></label>
                                            <input type="password" name="password" id="password" class="form-control <?= form_error('password') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('password') ?>">
                                            <?= form_error('password') ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?= lang('confirm_password') ?></label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control <?= form_error('confirm_password') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('confirm_password') ?>">
                                            <?= form_error('confirm_password') ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <span class="font-weight-bold">2. <?= lang('address_information') ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label><?= lang('address') ?></label>
                                            <textarea name="address" id="address" cols="30" rows="3" class="form-control <?= form_error('address') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('address_placeholder') ?>"><?= set_value('address') ?></textarea>
                                            <?= form_error('address') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label><?= lang('province') ?></label>
                                            <select name="province" id="province" class="form-control <?= form_error('province') != '' ? 'is-invalid' : '' ?>">
                                                <option value=""><?= lang('province_placeholder') ?></option>
                                                <?php foreach ($provincies->result() as $province) : ?>
                                                    <option value="<?= $province->id ?>"><?= $province->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?= form_error('province') ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?= lang('city') ?></label>
                                            <select name="city" id="city" class="form-control <?= form_error('city') != '' ? 'is-invalid' : '' ?>">
                                                <option value=""><?= lang('city_placeholder') ?></option>
                                            </select>
                                            <?= form_error('city') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label><?= lang('district') ?></label>
                                            <select name="district" id="district" class="form-control <?= form_error('district') != '' ? 'is-invalid' : '' ?>">
                                                <option value=""><?= lang('district_placeholder') ?></option>
                                            </select>
                                            <?= form_error('district') ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?= lang('postcode') ?></label>
                                            <input type="text" class="form-control <?= form_error('postcode') != '' ? 'is-invalid' : '' ?>" name="postcode" id="postcode" placeholder="<?= lang('postcode_placeholder') ?>" value="<?= set_value('postcode') ?>">
                                            <?= form_error('postcode') ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <span class="font-weight-bold">3. <?= lang('other_information') ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label><?= lang('courier') ?></label>
                                            <div>
                                                <?php foreach ($shippings as $shipping) : ?>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="checkbox-<?= $shipping ?>" value="<?= $shipping ?>" name="couriers[]">
                                                        <label class="form-check-label" for="checkbox-<?= $shipping ?>"><?= strtoupper($shipping) ?></label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?= form_error('couriers[]') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label><?= lang('bank_name') ?></label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control <?= form_error('bank_name') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('bank_name_placeholder') ?>" value="<?= set_value('bank_name') ?>">
                                            <?= form_error('bank_name') ?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label><?= lang('account_number') ?></label>
                                            <input type="text" name="account_number" id="account_number" class="form-control <?= form_error('account_number') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('account_number_placeholder') ?>" value="<?= set_value('account_number') ?>">
                                            <?= form_error('account_number') ?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label><?= lang('account_holder') ?></label>
                                            <input type="text" name="account_holder" id="account_holder" class="form-control <?= form_error('account_holder') != '' ? 'is-invalid' : '' ?>" placeholder="<?= lang('account_holder_placeholder') ?>" value="<?= set_value('account_holder') ?>">
                                            <?= form_error('account_holder') ?>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-user btn-block" type="submit">Register!</button>
                                        </div>
                                    </div>
                                    <div class="form-group text-center mt-3">
                                        <span class="text-muted">Sudah punya akun? <a href="<?= base_url('auth') ?>">Login Sekarang!</a></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>