<div class="modal fade" id="edit-variations-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url('admin/updateProductVariations') ?>" method="post"
            id="edit_variations_form">
            <input type="hidden" name="v_id">


            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Update Variations
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select name="product" id="product_name_select" class="form-control">
                                <option value selected>Pilih Produk</option>
                                <?php foreach ($product as $p) : ?>
                                <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="error-text text-danger product_error"></span>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Variation Key</label>
                            <select name="variation_key" id="variation-key-select" class="form-control">
                                <option value="" selected>Pilih..</option>
                                <option value="Ukuran">Ukuran</option>
                                <option value="Warna">Warna</option>
                                <option value="Storage">Storage</option>
                                <option value="Model">Model</option>
                                <option value="Tipe">Tipe</option>
                                <option value="Packing">Packing</option>

                            </select>
                            <span class="error-text text-danger variation_key_error"></span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Variation Value</label>
                            <input type="text" name="variation_value" id="" class="form-control">
                            <span class="error-text text-danger variation_value_error"></span>

                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Harga Variasi</label>
                            <input type="text" name="variation_price" placeholder="Masukan Harga Variasi Yang Berbeda"
                                class="form-control">
                            <span class="error-text text-danger variation_price_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <input type="checkbox" name="is_active" id="">
                            <label for="">Aktif</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="preview-data-variations">

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>