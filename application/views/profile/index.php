<style>
    .text-danger {
        margin-left:0px !important;
        margin-bottom: 0px !important;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $deskripsi ?></h1>
  </div>

  <div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0)"><?= lang('profile') ?></a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('profile/change_password') ?>" class="nav-link"><?= lang('change_password') ?></a>
            </li>
            <?php if ($seller->status == 'non-active') : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('profile/verification_account') ?>"><?= lang('verification_account') ?></a>
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
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="font-weight-bold">1. <?= lang('personal_information') ?></span> (<?= $seller->email ?>)
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?= lang('name') ?></label>
                                <input type="text" class="form-control <?= form_error('name') != '' ? 'is-invalid' : '' ?>" name="name" id="name" placeholder="<?= lang('name_placeholder') ?>" value="<?= set_value('name') != '' ? set_value('name') : $seller->name ?>">
                                <?= form_error('name') ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?= lang('store_name') ?></label>
                                <input type="text" class="form-control <?= form_error('store_name') != '' ? 'is-invalid' : '' ?>" name="store_name" id="store_name" placeholder="<?= lang('store_name_placeholder') ?>" value="<?= set_value('store_name') != '' ? set_value('store_name') : $seller->store_name ?>">
                                <?= form_error('store_name') ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?= lang('phone') ?></label>
                                <input type="text" class="form-control <?= form_error('phone') != '' ? 'is-invalid' : '' ?>" name="phone" id="phone" placeholder="<?= lang('phone_placeholder') ?>" value="<?= set_value('phone') != '' ? set_value('phone') : $seller->phone ?>">
                                <?= form_error('phone') ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="font-weight-bold">2. <?= lang('address_information') ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <label><?= lang('address') ?></label>
                            <textarea name="address" id="address" cols="30" rows="3" class="form-control <?= form_error('address') != '' ? 'is-invalid' : '' ?>"><?= set_value('address') != '' ? set_value('address') : $seller->address ?></textarea>
                            <?= form_error('address') ?>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-3">
                            <label><?= lang('province') ?></label>
                            <select name="province" id="province" class="form-control <?= form_error('province') != '' ? 'is-invalid' : '' ?>">
                                <option value=""><?= lang('province_placeholder') ?></option>
                                <?php foreach ($provincies->result() as $province) : ?>
                                    <?php if (set_value('province') != '') : ?>
                                        <option value="<?= $province->id ?>" <?= $province->id == set_value('province') ? 'selected' : '' ?>><?= $province->name ?></option>
                                    <?php else : ?>
                                        <option value="<?= $province->id ?>" <?= $province->id == $seller->province_id ? 'selected' : '' ?>><?= $province->name ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label><?= lang('city') ?></label>
                            <select name="city" id="city" class="form-control <?= form_error('city') != '' ? 'is-invalid' : '' ?>">
                                <option value=""><?= lang('city_placeholder') ?></option>
                                <?php foreach ($cities->result() as $city) : ?>
                                    <?php if (set_value('city') != '') : ?>
                                        <option value="<?= $city->id ?>" <?= $city->id == set_value('city') ? 'selected' : '' ?>><?= $city->type . ' ' . $city->name ?></option>
                                    <?php else : ?>
                                        <option value="<?= $city->id ?>" <?= $city->id == $seller->city_id ? 'selected' : '' ?>><?= $city->type . ' ' . $city->name ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('city') ?>
                        </div>
                        <div class="col-sm-3">
                            <label><?= lang('district') ?></label>
                            <select name="district" id="district" class="form-control <?= form_error('district') != '' ? 'is-invalid' : "" ?>">
                                <option value=""><?= lang('district_placeholder') ?></option>
                                <?php foreach ($districts->result() as $district) : ?>
                                    <?php if (set_value('district') != '') : ?>
                                        <option value="<?= $district->id ?>" <?= $district->id == set_value('district') ? 'selected' : '' ?>><?= $district->name ?></option>
                                    <?php else : ?>
                                        <option value="<?= $district->id ?>" <?= $district->id == $seller->district_id ? 'selected' : '' ?>><?= $district->name ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('district') ?>
                        </div>
                        <div class="col-sm-3">
                            <label><?= lang('postcode') ?></label>
                            <input type="text" class="form-control <?= form_error('postcode') != '' ? 'is-invalid' : '' ?>" name="postcode" id="postcode" value="<?= set_value('postcode') != '' ? set_value('postcode') : $seller->postcode ?>" placeholder="<?= lang('postcode_placeholder') ?>">
                            <?= form_error('postcode') ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="font-weight-bold">3. <?= lang('other_information') ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <label><?= lang('courier') ?></label>
                            <div>
                                <?php foreach ($shippings as $shipping) : ?>
                                    <div class="form-check form-check-inline">
                                        <?php if (set_value('couriers')) : ?>
                                            <input class="form-check-input" type="checkbox" id="checkbox-<?= $shipping ?>" value="<?= $shipping ?>" name="couriers[]" <?= in_array($shipping, set_value('couriers')) ? 'checked' : '' ?> >
                                            <label class="form-check-label" for="checkbox-<?= $shipping ?>"><?= strtoupper($shipping) ?></label>
                                        <?php else : ?>
                                            <input class="form-check-input" type="checkbox" id="checkbox-<?= $shipping ?>" value="<?= $shipping ?>" name="couriers[]" <?= in_array($shipping, $couriers) ? 'checked' : '' ?> >
                                            <label class="form-check-label" for="checkbox-<?= $shipping ?>"><?= strtoupper($shipping) ?></label>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <label><?= lang('bank_name') ?></label>
                            <input type="text" class="form-control <?= form_error('bank_name') != '' ? 'is-invalid' : '' ?>" name="bank_name" id="bank_name" value="<?= set_value('bank_name') != '' ? set_value('bank_name') : $seller->bank_name ?>">
                            <?= form_error('bank_name') ?>
                        </div>
                        <div class="col-sm-4">
                            <label><?= lang('account_number') ?></label>
                            <input type="text" class="form-control <?= form_error('account_number') != '' ? 'is-invalid' : '' ?>" name="account_number" id="account_number" value="<?= set_value('account_number') != '' ? set_value('account_number') : $seller->account_number ?>">
                            <?= form_error('account_number') ?>
                        </div>
                        <div class="col-sm-4">
                            <label><?= lang('account_holder') ?></label>
                            <input type="text" class="form-control <?= form_error('account_holder') != '' ? 'is-invalid' : '' ?>" name="account_holder" id="account_holder" value="<?= set_value('account_holder') != '' ? set_value('account_holder') : $seller->account_holder ?>">
                            <?= form_error('account_holder') ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <div>
                                <button class="btn btn-primary" type="submit" <?= $seller->status == 'non-active' ? 'disabled' : '' ?>><?= lang('save') ?></button>
                            </div>
                            <?php if ($seller->status == 'non-active') : ?>
                                <span class="text-danger">Harap aktivasi akun anda <a href="<?= base_url('profile/verification_account') ?>">disini!</a></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>

</div>