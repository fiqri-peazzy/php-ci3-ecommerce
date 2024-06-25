<script src="<?= base_url() ?>assets/frontend/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/bootstrap/js/popper.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/select2/select2.min.js"></script>
<script>
$(".js-select2").each(function() {
    $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
    });
})
</script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/daterangepicker/moment.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/slick/slick.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/js/slick-custom.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/parallax100/parallax100.js"></script>
<script src="<?= base_url() ?>assets/backend/src/plugins/toastr/toastr.js"></script>

<script>
$('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<script>
$('.gallery-lb').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: 'mfp-fade'
    });
});
</script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/isotope/isotope.pkgd.min.js"></script>
<!--============================================================================================

===-->
<script src="<?= base_url() ?>assets/frontend/vendor/sweetalert/sweetalert.min.js"></script>
<script>
$('.js-addwish-b2').on('click', function(e) {
    e.preventDefault();
});

$('.js-addwish-b2').each(function() {
    var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
    $(this).on('click', function() {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-b2');
        $(this).off('click');
    });
});

$('.js-addwish-detail').each(function() {
    var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

    $(this).on('click', function() {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-detail');
        $(this).off('click');
    });
});

/*---------------------------------------------*/
</script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
$('.js-pscroll').each(function() {
    $(this).css('position', 'relative');
    $(this).css('overflow', 'hidden');
    var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
    });

    $(window).on('resize', function() {
        ps.update();
    })
});
</script>
<!--===============================================================================================-->
<script src="<?= base_url() ?>assets/frontend/js/main.js"></script>
<script src="<?= base_url() ?>assets/extra-assets/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script src="<?= base_url() ?>assets/extra-assets/map/leaflet.js"></script>
<script src="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    var selectedOptions = {};
    $('.option').on('click', function() {
        var group = $(this).closest('.v-group');
        var key = group.find('.v-key').text().trim();
        var value = $(this).text().trim();

        selectedOptions[key] = value;

        if (Object.keys(selectedOptions).length === $('.v-group').length) {
            var url = '<?= base_url('cart/getVariationPrice') ?>';
            var data = selectedOptions;

            $.get(url, {
                data: data
            }, function(response) {
                if (response.variations_price == null || response.variations_price == 0) {
                    toastr.error('Something Went Wrong');
                    $('.option').removeClass('selection');
                } else {
                    var cartForm = $('#add-to-cart')
                    var price = cartForm.find('span#product_price');
                    price.text(response.variations_price)
                }
            }, 'json')

        }

    });

    $("#add-to-cart-button").click(function(e) {
        e.preventDefault();
        var product_id = $("input[name='product_id']").val();
        var quantity = $("input[name='quantity']").val();
        var variations = {};
        var allSelected = true;
        $(".flex-w.flex-r-m.p-b-10").each(function() {
            var key = $(this).find(".size-203").text().trim();
            var selectedOption = $(this).find(".option.selection");
            if (selectedOption.length > 0) {
                variations[key] = selectedOption.attr("name");

            } else {
                allSelected = false;
                toastr.error("Silakan pilih variasi untuk " + key);
            }
        });

        if (allSelected) {
            $.ajax({
                url: "<?= base_url('cart/addtocart') ?>",
                method: "POST",
                data: {
                    product_id: product_id,
                    quantity: quantity,
                    variations: variations
                },
                dataType: 'json',
                beforeSend: function() {
                    toastr.remove();
                    // $('#cart-counter').attr('data-notify', '');


                },
                success: function(response) {
                    var nameProduct = $('.js-name-detail').html();
                    $('input#add-qty-cart').val(1);
                    $('#cart-counter').each(function() {
                        $(this).attr('data-notify', response.cart_count);
                    })
                    swal(nameProduct, "di Tambahkan ke Keranjang!", "success");
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        }
    });

    $('a.btn-num-product-down').on('click', function(e) {
        var cart_id = $(this).data('id');
        var url = $(this).data('url');
        console.log(cart_id + url)
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                cart_id: cart_id
            },
            dataType: 'json',

            success: function(response) {
                console.log(response);
                $('#cart-counter').each(function() {
                    $(this).attr('data-notify', response.cart_count);
                })
                if (response.qty < 1) {
                    // console.log('ahaii');
                    $('tr#cart_item_' + cart_id).remove();
                    if (response.cart_count == 0) {
                        $('#empty-cart').removeClass('d-none');
                        $('#wrapper').addClass('d-none')
                    } else {
                        $('#empty-cart').addClass('d-none');
                        $('#wrapper').removeClass('d-none')
                    }

                    $('#grand_total').html(formatRupiah(0))
                    toastr.success(response.msg);
                }

                $('#subtotal_' + cart_id).html(formatRupiah(response.subtotals[cart_id]))
                $('#grand_total').html(formatRupiah(response.grand_total))
            }

        })
    });

    $('a.btn-num-product-up').on('click', function(e) {
        var cart_id = $(this).data('id');
        var url = $(this).data('url');
        console.log(cart_id + url)
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                cart_id: cart_id
            },
            dataType: 'json',

            success: function(response) {
                // console.log(response);
                if ($.isEmptyObject(response.error)) {
                    $('#cart-counter').each(function() {
                        $(this).attr('data-notify', response.cart_count);
                    });
                    if (response.cart_count == 0) {
                        $('#empty-cart').removeClass('d-none');
                        $('#wrapper').addClass('d-none')
                    } else {
                        $('#empty-cart').addClass('d-none');
                        $('#wrapper').removeClass('d-none')
                    }

                    $('#subtotal_' + cart_id).html(formatRupiah(response.subtotals[
                        cart_id]))
                    $('#grand_total').html(formatRupiah(response.grand_total))
                } else {
                    toastr.error(response.error);
                }
            }
        })
    });

    $(document).on('click', '#remove-cart', function(e) {
        e.preventDefault();
        var cart_id = $(this).data('id');
        var url = '<?= base_url('cart/remove_cart') ?>';
        $.get(url, {
            cart_id: cart_id
        }, function(res) {
            if (res.status == 1) {
                $('#cart-counter').each(function() {
                    $(this).attr('data-notify', res.cart_count);
                });
                if (res.cart_count == 0) {
                    $('#empty-cart').removeClass('d-none');
                    $('#wrapper').addClass('d-none')
                } else {
                    $('#empty-cart').addClass('d-none');
                    $('#wrapper').removeClass('d-none')
                }
                $('tr#cart_item_' + cart_id).remove();
                toastr.success(res.msg);
                $('#grand_total').html(formatRupiah(res.grand_total))

            }
        }, 'json');
    })


    // User Profile
    $('#user_profile_form_u').on('submit', function(e) {
        e.preventDefault();
        // alert(123);
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            contentType: false,
            dataType: 'json',
            processData: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(res) {
                if ($.isEmptyObject(res.error)) {
                    if (res.status == 1) {
                        $.each(res.user, function(key, val) {
                            $(form).find('input[type=text][name="' + key + '"]')
                                .val(val);
                        })

                        $(form).find('textarea[name="alamat"]').html(res.user.alamat);
                        toastr.success(res.msg);
                    } else {
                        toastr.error(res.msg);
                    }

                } else {
                    $.each(res.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    })
                }
            }
        })
    });

    $('#user-profile-pict-file').on('change', function(e) {
        // alert()
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profile-picture').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
        var formData = new FormData($('#form_profile_pict')[0]);
        $.ajax({
            url: '<?= base_url('user/updateUserProfilePicture') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                toastr.remove();
            },
            success: function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                    $('#user_picture').attr('src', $('#profile-picture').attr('src'))

                } else {
                    toastr.error(response.error);
                }
            }
        });
    });


    $('#provinsi').on('change', function(e) {
        e.preventDefault()
        var id = $(this).val();
        $.ajax({
            url: '<?= base_url('cart/get_daerah') ?>',
            method: 'post',
            data: {
                id: id,
                data: 'kabupaten'
            },
            beforeSend: function() {
                $('#kota').html('<option value="" selected>--Pilih Kota</option>');
                $('#kecamatan').html(
                    '<option value="" selected>--Pilih Kecamatan</option>');
            },
            success: function(res) {
                $('#kota').html(res);

            }
        })

    });

    $('#kota').on('change', function(e) {
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            url: '<?= base_url('cart/get_daerah') ?>',
            method: 'post',
            data: {
                id: id,
                data: 'kecamatan'
            },

            success: function(res) {
                $('#kecamatan').html(res);
            }
        })
    });

    function getLocation() {
        var spinner = document.getElementById('spinner');

        if (navigator.geolocation) {
            var options = {
                enableHighAccuracy: true,
                timeout: 20000,
                maximumAge: 0,
            };

            spinner.classList.remove('d-none');

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    console.log(lat, lon);
                    $('#lat').val(lat);
                    $('#lon').val(lon);

                    sendCoordinates(lat, lon);

                },
                function(error) {
                    console.error('Error getting location:', error.message);
                    alert('Error getting your location. Please try again or enter the address manually.');
                    spinner.classList.add('d-none');
                },
                options
            );
        } else {
            alert('Geolocation is not supported by your browser. Please enter the address manually.');
        }
    }

    function sendCoordinates(lat, lon) {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('cart/reverse_geocode') ?>',
            data: {
                lat: lat,
                lon: lon
            },
            success: function(response) {
                $('#alamat').val(response);
                $('#spinner').addClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
                $('#spinner').addClass('d-none');
            }
        });
    }

    $(document).ready(function() {
        $('#get-location').on('click', getLocation);
    });


    function formatRupiah(amount) {
        if (amount === null || amount === undefined) {
            return 'Rp 0';
        }

        var number_string = amount.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp ' + rupiah;
    }



})
</script>

</body>

</html>