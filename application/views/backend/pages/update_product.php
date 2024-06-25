<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Edit Produk</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Produk
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">

            <div class="card-body pd-20">
                <form action="<?= base_url('admin/updateProductHandler') ?>" id="edit-product-form"
                    enctype="multipart/form-data" method="post">


                    <input type="hidden" name="id" value="<?= $data->id ?>">
                    <div class="row mb-5 align-items-center p-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Nama Produk</label>
                                <input type="text" name="name" id="" value="<?= $data->name ?>" class="form-control">
                                <span class="error-text text-danger name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" class="form-label">Harga</label>
                                <input class="form-control" value="<?= $data->price ?>" name="price">
                                <span class="error-text text-danger price_error"></span>
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="form-group">
                                <label for="" class="form-label">Stok</label>
                                <input id="stok" type="text" value="<?= $data->stock ?>" class="form-control"
                                    name="stok">
                                <span class="error-text text-danger stok_error"></span>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_available">
                                    <label class="custom-control-label" for="customCheck1">Tersedia</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-sm-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Kategori</label>
                                <select class="custom-select col-12" name="category">

                                    <?php foreach ($categories as $category) : ?>

                                    <option value="<?php echo $category->id ?>"
                                        <?= $category->id == $data->id ? 'selected' : '' ?>><?= $category->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error-text text-danger category_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gambar produk</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" />
                                    <label class="custom-file-label">pilih file</label>
                                    <span class="error-text text-danger image_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="description" id="" cols="30"
                                    rows="10"><?= $data->description ?></textarea>
                                <span class="error-text text-danger description_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Preview Gambar Produk</label>
                                <br>
                                <img src="<?= base_url() ?>uploads/produk/<?= $data->image ?>" alt="" id="imagePreview"
                                    class="img-thumbnail" style="max-width: 200px; max-height:200px">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6>Produk Variasi </h6>

                                </div>
                                <div class="card-body">

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan </button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>