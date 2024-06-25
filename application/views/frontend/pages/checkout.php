<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
            PeazzyStore
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
        <a href="<?= base_url('cart') ?>" class="stext-109 cl8 hov-cl1 trans-04">
            cart
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            checkout
        </span>
    </div>
</div>

<div class="bg0 p-t-75 p-b-85">

    <div class="container">
        <form class="row" action="<?= base_url('order/place_order') ?>" method="post">
            <div class="col-md-6 col-lg-6">
                <div class="card card-box">
                    <div class="card-header">
                        <h6>Informasi Penagihan</h6>
                    </div>
                    <div class="card-body">

                        <div class="form-row mb-2">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" autocomplete="off" name="name" class="form-control"
                                    value="<?= get_user()->name ?>">
                                <span class="error-text text-danger name error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Nomor telepon</label>
                                <input type="text" name="phone" autocomplete="off" class="form-control"
                                    value="<?= get_user()->phone ?>">
                                <span class="error-text text-danger name error"></span>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-4 form-group">
                                <label class="form-label">Provinsi</label>
                                <select style="font-size: 12px;" name="provinsi" id="provinsi" class="form-select">
                                    <option value="" selected>--Pilih Provinsi</option>
                                    <?php foreach ($w_provinsi as $row) : ?>
                                    <option value="<?= $row->kode ?>"><?= $row->nama ?>
                                    </option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label">Kota</label>
                                <select style="font-size: 12px;" name="kota" id="kota" class="form-control">
                                    <option value="" selected>--Pilih Kota</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label">Kecamatan</label>
                                <select style="font-size: 12px;" name="kecamatan" id="kecamatan" class="form-control">
                                    <option value="" selected>--Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <label for="" class="form-label">Nama Jalan, Gedung, No Rumah</label>
                            <input class="form-control" type="text" value="" name="alamat" id="alamat" placeholder="">
                            <div class="mt-4 text-muted">
                                gunakan lokasi anda sekarang
                                <button type="button" class="btn btn-sm btn-outline-primary btn-default ml-2"
                                    id="get-location"><i class="fa fa-map-pin"></i></button>
                                <div class="spinner d-none" id="spinner" style="margin-left: 20px;"><i
                                        class="fa fa-spinner fa-spin"></i>
                                    Loading...
                                </div>
                            </div>

                            <input type="hidden" name="lat" id="lat" value="">
                            <input type="hidden" name="lon" id="lon" value="">
                        </div>
                        <div class="form-row mb-2">
                            <label for="" class="form-label">Detail lainnya(Blok, Unit no, Patokan)</label>
                            <input class="form-control" type="text" name="alamat" id="alamat" placeholder="">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="card card-body">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="small text-uppercase">
                                <th scope="col">Produk</th>
                                <th scope="col"></th>
                                <th scope="col">Kuantitas</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_item as $item) : ?>
                            <tr>
                                <td>
                                    <div class="how-itemcart1">
                                        <img src="<?= base_url() ?>uploads/produk/<?= $item->image ?>" alt="IMG">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-col flex-t">
                                        <div class="product-name flex-col-l flex-col-t">
                                            <?= substr($item->name, 0, 40) ?>
                                        </div>
                                        <?php if ($item->variations != null) : ?>
                                        <div class="product-varitions flex-col-l flex-col-b">
                                            <button type="button" class="d-flex flex-t flex-col">
                                                <!-- <div class="variations flex-row flex-col-l flex-col-t">
                                                    <small class="text-muted flex-m flex-t">
                                                        Variasi
                                                        <i
                                                            class="fa fa-pencil fs-8 m-l-7 flex-w flex-c text-center"></i>
                                                    </small>
                                                </div> -->
                                                <div class="variations-selected">
                                                    <?php foreach (json_decode($item->variations) as $key => $value) : ?>
                                                    <small class="text-muted"><?= $value ?></small>
                                                    <?php endforeach; ?>
                                                </div>
                                            </button>
                                        </div>
                                        <?php endif; ?>

                                    </div>
                                </td>
                                <td>
                                    <label for="" class="text-center"><?= $item->quantity ?></label>
                                </td>
                                <td>
                                    <div class="price-wrap">
                                        <small class="text-muted">Harga Produk</small><br>

                                        <var class="price">
                                            <?= isset($item->variations_price) && $item->variations_price != 0 ? formatRupiah($item->variations_price) : formatRupiah($item->price) ?>
                                        </var>
                                        <small class="text-muted">Subtotal</small><br>
                                        <var class="price">
                                            <?= formatRupiah($subtotal[$item->cart_id]) ?>
                                        </var>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-block btn-primary">Buat Pesanan</button>
                    <button type="submit" class="btn btn-block btn-outline-secondary">Lanjut Belanja</button>

                </div>
            </div>
        </form>
    </div>
</div>