<!-- add category modal -->
<div class="modal fade" id="add-category-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: none; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url('admin/addcategory') ?>" method="post" id="add_category_form">


            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah Kategori
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="" class="form-label">Nama Kategori</label>
                    <input type="text" name="name" id="" class="form-control">
                    <span class="error-text text-danger name_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">
                    Tambah
                </button>
            </div>

        </form>

    </div>
</div>