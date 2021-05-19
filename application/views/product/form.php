<style>
    .images-child {
        height: 180px;
        position: relative;
    }
    .button-delete-images {
        position: absolute;
        right: 10px;
        top: 10px;
        color: white;
        background: #d9534f;
        padding: 0px 6px;
        font-size: 12px;
    }
    .button-delete-images:hover {
        color: white;
    }
    .image-cover-fit {
        width: 180px;height:180px;object-fit:cover;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <?= $deskripsi ?>
    </h1>
  </div>
  
  <div class="row">
      <div class="col-sm-12">
        <div class="card">
            <form action="<?= $action == 'add' ? base_url('product/do_add') : base_url('product/do_edit/' . $data->id) ?>" method="post" onsubmit="save_product(event, this)">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="font-weight-bold">1. <?= lang('base_information') ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <label><?= lang('name') ?></label>
                            <input type="text" class="form-control" name="name" placeholder="<?= lang('name_placeholder') ?>" value="<?= $action == 'edit' ? $data->name : '' ?>">
                        </div>
                        <div class="col-sm-6">
                            <label><?= lang('price') ?></label>
                            <input type="text" class="form-control price-format" name="price" placeholder="<?= lang('price_placeholder') ?>" value="<?= $action == 'edit' ? rupiah_input($data->price) : '' ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label><?= lang('category') ?></label>
                            <select name="category" id="category" class="form-control">
                                <option value=""><?= lang('category_placeholder') ?></option>
                                <?php if ($categories) : ?>
                                    <?php foreach ($categories->result() as $category) : ?>
                                        <option value="<?= $category->id ?>" <?= $action == 'edit' ? $data->category_id == $category->id ? 'selected' : '' : '' ?>><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label><?= lang('stock') ?></label>
                            <input type="text" class="form-control input-number" name="stock" placeholder="<?= lang('stock_placeholder') ?>" value="<?= $action == 'edit' ? $data->stock : '' ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label><?= lang('status') ?></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?= $action == 'edit' ? $data->status == 1 ? 'selected' : '' : '' ?>>Aktif</option>
                                <option value="0" <?= $action == 'edit' ? $data->status == 0 ? 'selected' : '' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label><?= lang('weight') ?></label>
                            <input type="text" class="form-control input-number" name="weight" placeholder="<?= lang('weight_placeholder') ?>" value="<?= $action == 'edit' ? $data->weight : "" ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <label><?= lang('description') ?></label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="<?= lang('description_placeholder') ?>"><?= $action == 'edit' ? $data->description : '' ?></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <span class="font-weight-bold">2. <?= lang('image_information') ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label><?= lang('thumbnail') ?> (180x180) (Max: 2MB)</label>
                            <div id="image_cover">
                                <?php if ($action == 'add') : ?>
                                    <input type="file" id="thumbnail" accept="image/*" onchange="changeThumbnail(event)">
                                <?php else : ?>
                                    <div class="d-inline-block">
                                        <img src="<?= $data->thumbnail ?>" class="img-thumbnail image-cover-fit" />
                                    </div>
                                    <div class="d-inline-block ml-3">
                                        <button class="btn btn-danger btn-sm mt-3" type="button" onclick="deleteThumbnail()">
                                            <?= lang('delete') ?>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="thumbnail">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <label><?= lang('image') ?> (180x180) (Max: 2MB)</label>
                            <div class="row images-cover">
                                <?php if ($action == 'add') : ?>
                                    <div class="col-sm-2 mb-3">
                                        <div style="height: 180px;">
                                            <button class="btn btn-block btn-outline-dark btn-add-images" style="height:100%;" type="button" onclick="openModalImage(event)">+</button>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if (count($product_images) > 0) : ?>
                                        <?php $i = 1; ?>
                                        <?php foreach($product_images as $image) : ?>
                                            <div class="col-sm-2 mb-3">
                                                <div class="images-child" id="image-child-<?= $i ?>" data-base64="<?= $image['base64'] ?>" data-reader="<?= $image['image'] ?>">
                                                    <img src="<?= $image['image'] ?>" class="img-thumbnail image-cover-fit" />
                                                    <a href="javascript:void(0)" class="button-delete-images" onclick="deleteImages('image-child-<?= $i ?>')"><i class="fas fa-times"></i></a>
                                                    <input type="hidden" name="images[]" class="product-images" value="<?= $image['base64'] ?>" />
                                                </div>
                                            </div>
                                        <?php $i++ ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div class="col-sm-2 mb-3">
                                        <div style="height: 180px;">
                                            <button class="btn btn-block btn-outline-dark btn-add-images" style="height:100%;" type="button" onclick="openModalImage(event)">+</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" id="submit" type="submit"><?= lang('save') ?></button>
                    <a class="btn btn-secondary" href="<?= base_url('product') ?>"><?= lang('back') ?></a>
                </div>
            </form>
        </div>
      </div>
  </div>

</div>
<input type="file" id="attach_images" accept="image/*" onchange="changeImages(event)" style="display:none;">