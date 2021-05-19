<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= lang('product_page') ?></h1>
  </div>

  <div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="<?= base_url('product/add') ?>" class="btn btn-primary btn-sm">Tambah Produk</a>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="table" data-url="<?= base_url('product/get_list') ?>">
                    <thead>
                        <tr>
                            <th class="no-sort"><?= lang('thumbnail') ?></th>
                            <th class="default-sort" data-sort="asc"><?= lang('name') ?></th>
                            <th><?= lang('category') ?></th>
                            <th><?= lang('price') ?></th>
                            <th><?= lang('stock') ?></th>
                            <th><?= lang('status') ?></th>
                            <th><?= lang('option') ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
<!-- <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script> -->