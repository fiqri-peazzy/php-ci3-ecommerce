<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Manage Produk Variasi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Produk Variasi
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-box pd-20">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">
                        Variasi Produk
                    </div>
                    <div class="pull-right">
                        <a href="#" role="button" id="add_variation_btn" class="btn btn-default btn-sm p-0"><i
                                class="fa fa-plus-circle"></i> Tambah Variasi Product</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless table-hover table-strip" id="product_variations_table">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">#</th>
                            <th>Product</th>
                            <th>Key Variasi</th>
                            <th>Variasi</th>
                            <th>Harga Variasi</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>