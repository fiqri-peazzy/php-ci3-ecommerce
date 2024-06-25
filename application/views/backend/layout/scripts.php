<!-- js -->
<script src="<?= base_url() ?>assets/backend/vendors/scripts/core.js"></script>
<script src="<?= base_url() ?>assets/backend/vendors/scripts/script.min.js"></script>
<script src="<?= base_url() ?>assets/backend/vendors/scripts/process.js"></script>
<script src="<?= base_url() ?>assets/backend/vendors/scripts/layout-settings.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/backend/vendors/scripts/dashboard3.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/toastr/toastr.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/ijabo/ijaboCropTool.min.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/sweetalert2/sweetalert2.all.js"></script>
<script src="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>

<script>
// Personal Details sctipys
$('#update_personal_details').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    $('.user-name').each(function() {
                        $(this).html(response.user_info.username);
                    });
                    $('.user-email').html(response.user_info.email);
                    $('.user-phone').html(response.user_info.phone);
                    toastr.success(response.msg)
                } else {
                    toastr.error(response.msg)
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }
        }
    })

})

// $('#user_profile_file').ijaboCropTool({
//     preview: '.ci-avatar-photo',
//     setRatio: 1,
//     allowedExtensions: ['jpg', 'jpeg', 'png'],
//     processUrl: '',
//     onSuccess: function(message, element, status) {
//         if (status == 1) {
//             toastr.success(message);
//         } else {
//             toastr.error(message);
//         }
//     },
//     onError: function(message, element, status) {
//         alert(message);
//     }
// })
$(document).ready(function(e) {
    $('#user_profile_file').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.ci-avatar-photo').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
        var formData = new FormData($('#form_user_profile_file')[0]);
        $.ajax({
            url: $('#form_user_profile_file').attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
                toastr.remove();
            },
            success: function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg);

                } else {
                    toastr.error(response.msg);
                }
            }
        });
    });
});

$(document).on('click', '#delete_user', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= base_url('admin/deleteUser') ?>';
    var $row = $(this).closest('tr')
    if (id == 1) {
        toastr.error('This User is super admin');
    } else {
        swal({
            title: 'Are you Sure ?',
            html: 'You Want to delete this User',
            type: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            width: 400,
            allowOutsideClick: false,
        }).then(function(result) {
            if (result.value) {
                $.get(url, {
                    user_id: id
                }, function(response) {
                    if (response.status == 1) {
                        $row.remove();
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg)
                    }
                }, 'json');
            }
        })
    }

})

// Personal Details End

// Category Starts

$(document).on('click', '#add_category_btn', function(e) {
    e.preventDefault();
    var modal = $('body').find('div#add-category-modal');
    modal.modal('show');
})

$('#add_category_form').on('submit', function(e) {
    e.preventDefault();
    var modal = $('body').find('div#add-category-modal');

    var form = this;
    var formData = new FormData(form);
    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function() {
            toastr.remove()
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    modal.find('input[type="text"]').val('');
                    modal.modal('hide');
                    categories_DT.ajax.reload(null, false);
                    toastr.success(response.msg)
                } else {
                    toastr.error(response.msg)
                }
            } else {
                $(form).find('span.error-text').text(response.error)
            }
        }

    })
});

var categories_DT = $('#categories-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= base_url('admin/getcategories') ?>",
    dom: "Brtip",
    info: true,
    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);
        // console.log(data);
        $('td', row).parent().attr('data-index', data[0]).attr('data-ordering', data[4]);
    },
    columnDefs: [{
            orderable: false,
            targets: [0, 1, 2, 3]
        },
        {
            visible: false,
            targets: 4
        }
    ],
    order: [
        [4,
            'asc'
        ]
    ]
});

$(document).on('click', '.editCategoryBtn', function(e) {
    e.preventDefault();
    var category_id = $(this).data('id');
    var url = '<?= base_url('admin/getcategory') ?>';
    $.get(url, {
        category_id: category_id
    }, function(response) {
        var modal = $('body').find('div#edit-category-modal');
        modal.find('form').find('input[type="hidden"][name="category_id"]').val(category_id);
        modal.find('form').find('input[type="text"][name="name"]').val(response.data.name);
        modal.modal('show');
    }, 'json');
});

$('#edit_category_form').on('submit', function(e) {
    e.preventDefault();

    var form = this;
    var formData = new FormData(form);
    var modal = $('body').find('div#edit-category-modal');
    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').val('')
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    modal.modal('hide')
                    toastr.success(response.msg);
                    categories_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $(form).find('span.error-text').val(response.error);
            }
        }
    })
});

$(document).on('click', '.deleteCategoryBtn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= base_url('admin/deletecategory') ?>';
    swal({
        title: 'Are you Sure ?',
        html: 'You Want to delete this Category',
        type: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        width: 400,
        allowOutsideClick: false,
    }).then(function(result) {
        if (result.value) {
            $.get(url, {
                category_id: id
            }, function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg)
                    categories_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg);
                }
            }, 'json')
        }
    })
});

$('table#categories-table').find('tbody').sortable({
    update: function(e, ui) {
        $(this).children().each(function(index) {
            if ($(this).attr('data-ordering') != (index + 1)) {
                $(this).attr('data-ordering', (index + 1)).addClass('updated');
            }
        });

        var position = [];

        $('.updated').each(function() {
            position.push([$(this).attr('data-index'), $(this).attr('data-ordering')]);
            $(this).removeClass('updated');
        });
        // console.log(position);
        var url = '<?= base_url('admin/reordercategory') ?>';
        $.get(url, {
            position: position
        }, function(response) {
            if (response.status == 1) {
                toastr.success(response.msg);

                categories_DT.ajax.reload(null, false);
            }
        }, 'json')
    }
});

// Product

$(document).ready(function() {
    $('#stok').TouchSpin({
        min: 0,
        max: 1000,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 10,
        postfix: ''
    });

    function checkStok() {
        var stok = parseInt($('#stok').val());
        if (stok != 0) {
            $('#is_available').prop('checked', true);
        } else {
            $('#is_available').prop('checked', false);
        }
    }
    checkStok();
    $('#stok').on('change', function() {
        checkStok();
    });
});

$(document).ready(function() {
    $('input[type="file"][name="image"]').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
$('#add-product-form').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');

        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    $(form)[0].reset();
                    $('#imagePreview').attr('src', '');
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg)
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val)
                })
            }
        }
    })
});

var product_DT = $('#product-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= base_url('admin/getProducts') ?>",
    dom: "Brtip",
    info: true,
    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);

    },
    columnDefs: [{
            orderable: false,
            targets: [0, 1, 2, 3]
        }

    ],
    order: [
        [4,
            'asc'
        ]
    ]

});

var productVariations_DT = $('#product_variations_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= base_url('admin/getProductVariations') ?>",
    dom: "Brtip",
    info: true,
    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },
    responsive: true,
    ordering: false,

});

function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

$('#edit-product-form').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');

        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    location.href = response.url
                    toastr.success(response.msg);

                } else {
                    toastr.error(response.msg)
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }
        }
    })
});

<?php if (!empty($this->session->flashData('updateproduct'))) : ?>
toastr.success('Nice Berhasi Update Data')
<?php endif ?>


$(document).on('click', '.deleteProductBtn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= base_url('admin/deleteproduct') ?>';
    swal({
        title: 'Are you Sure ?',
        html: 'You Want to delete this Product',
        type: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        width: 400,
        allowOutsideClick: false,
    }).then(function(result) {
        if (result.value) {
            $.get(url, {
                product_id: id
            }, function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg)
                    product_DT.ajax.reload(null, false);
                    productVariations_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg);
                }
            }, 'json')
        }
    })
});

$(document).on('click', '#add_variation_btn', function(e) {
    e.preventDefault();
    $('body').find('div#add-variations-modal').modal('show');
})
// Product Variations
$('#add-variations').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('')
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    $(form)[0].reset();
                    toastr.success(response.msg);
                    productVariations_DT.ajax.reload(null, false)
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }
        }
    })

});

$


$(document).on('click', '.editVariationsBtn', function(e) {
    e.preventDefault();
    var v_id = $(this).data('id');
    var url = '<?= base_url('admin/getVariation') ?>';
    $.get(url, {
        v_id: v_id
    }, function(response) {
        var modal = $('body').find('div#edit-variations-modal');
        modal.find('input[name="v_id"]').val(response.variation.id);
        modal.find('select[name="product"]').val(response.variation.product_id);
        modal.find('select[name="variation_key"]').val(response.variation.variations_key);
        modal.find('input[name="variation_value"]').val(response.variation.variations_value);
        modal.find('input[name="variation_price"]').val(response.variation.variations_price);
        modal.find('input[name="is_active"]').prop('checked', response.variation.is_active);
        modal.modal('show');
    }, 'json');

});

$('#edit_variations_form').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    var modal = $('body').find('div#edit-variations-modal')
    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    modal.modal('hide')
                    toastr.success(response.msg);
                    productVariations_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }
        }
    })
})


$(document).on('click', '.deleteVariationsBtn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= base_url('admin/deleteProductVariations') ?>';
    swal({
        title: 'Are you Sure ?',
        html: 'You Want to delete this Variations',
        type: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        width: 400,
        allowOutsideClick: false,
    }).then(function(result) {
        if (result.value) {
            $.get(url, {
                v_id: id
            }, function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg)
                    // product_DT.ajax.reload(null, false);
                    productVariations_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg);
                }
            }, 'json')
        }
    })

});
</script>

</body>

</html>