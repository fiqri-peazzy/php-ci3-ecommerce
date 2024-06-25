<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
            PeazzyStore
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Keranjang Belanja
        </span>
    </div>
</div>
<form class="bg0 p-t-75 p-b-85">
    <div class="container">
        <?php if ($this->session->flashdata('fail')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $this->session->flashdata('fail') ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-10 col-xl-8 m-lr-auto m-b-50">
                <div class="d-flex text-center align-items-center justify-content-center d-none" id="empty-cart">
                    <div>
                        <div class="empty-cart"></div>
                        <div class="mb-4">
                            Keranjang belanja Anda kosong
                        </div>
                        <a href="<?= base_url() ?>" class="btn btn-primary">
                            belanja sekarang
                        </a>
                    </div>
                </div>
                <?php if (!empty($cart_item)) : ?>
                <div class="m-l-25 m-r--38 m-lr-0-xl" id="wrapper">


                    <div class="wrap-table-shopping-cart" id="wraptable">

                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Produk</th>
                                <th class="column-2 text-center"></th>
                                <th class="column-3 text-center">Harga Satuan</th>
                                <th class="column-4 text-center">kuantitas</th>
                                <th class="column-5 text-center p-0">Total</th>
                                <th class="column-6 text-center">Aksi</th>
                            </tr>
                            <?php foreach ($cart_item as $item) : ?>
                            <tr class="table_row" id="cart_item_<?= $item->cart_id ?>">

                                <td class="column-1">
                                    <div class="how-itemcart1">
                                        <img src="<?= base_url() ?>uploads/produk/<?= $item->image ?>" alt="IMG">
                                    </div>
                                </td>
                                <td class="column-2">
                                    <div class="d-flex flex-col flex-t">
                                        <div class="product-name flex-col-l flex-col-t">
                                            <?= substr($item->name, 0, 40) ?>
                                        </div>
                                        <?php if ($item->variations != null) : ?>
                                        <div class="product-varitions flex-col-l flex-col-b">
                                            <button type="button" class="d-flex flex-t flex-col">
                                                <div class="variations flex-row flex-col-l flex-col-t">
                                                    <small class="text-muted flex-m flex-t">
                                                        Variasi
                                                        <i
                                                            class="fa fa-pencil fs-8 m-l-7 flex-w flex-c text-center"></i>
                                                    </small>
                                                </div>
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

                                <td class="column-3" style="font-size: 12px !important;">
                                    <?= isset($item->variations_price) && $item->variations_price != 0 ? formatRupiah($item->variations_price) : formatRupiah($item->price) ?>
                                </td>
                                <td class="column-4">
                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                        <a role="button" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                            data-id="<?= $item->cart_id ?>"
                                            data-url="<?= base_url('cart/decrease_qty') ?>">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </a>

                                        <input id="qty-cart-item" class="mtext-104 cl3 txt-center num-product"
                                            type="number" readonly name="num-product1" value="<?= $item->quantity ?>">

                                        <a role="button" data-id="<?= $item->cart_id ?>"
                                            data-url="<?= base_url('cart/increase_qty') ?>"
                                            class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center p-r-0 p-b-20" id="subtotal_<?= $item->cart_id ?>">
                                    <?= formatRupiah($subtotal[$item->cart_id]) ?>
                                </td>
                                <td class="column-6">
                                    <div class="flex-w flex-c-m p-l-20 p-r-20">
                                        <button type="button" id="remove-cart" data-id="<?= $item->cart_id ?>"
                                            class="d-flex flex-row flex-m"><i
                                                class="fa fa-trash fs-16 text-danger m-r-7 flex-w flex-m"></i>
                                            Hapus</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                </div>
                <?php else : ?>
                <div class="d-flex text-center align-items-center justify-content-center">
                    <div>
                        <div class="empty-cart"></div>
                        <div class="mb-4">
                            Keranjang belanja Anda kosong
                        </div>
                        <a href="<?= base_url() ?>" class="btn btn-primary">
                            belanja sekarang
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-10 col-lg-7 col-xl-4 m-lr-auto m-b-50">
                <div class="bor10 p-lr-20 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Cart Totals
                    </h4>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2" style="font-size: 14px !important;">
                                Total:
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2" id="grand_total" style="font-size: 14px !important;">
                                <?= formatRupiah($grand_total) ?>
                            </span>
                        </div>
                    </div>
                    <a class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                        href="<?= base_url('cart/checkout') ?>" style="text-decoration: none !important;color:white;">
                        checkout
                    </a>
                </div>
            </div>

        </div>

    </div>
</form>