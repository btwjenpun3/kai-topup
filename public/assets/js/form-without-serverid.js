
$(document).ready(function() {
    function showError(message) {
        $('#errorMessage').text(message);
        $('#stickyAlert').fadeIn('slow');
        setTimeout(function() {
            $('#stickyAlert').fadeOut('slow');
        }, 7000);
    }

    function hideError() {
        $('#stickyAlert').fadeOut('slow');
    }

    function handleItemClick(item) {
        $('.clickable-item').removeClass('clicked');
        $(item).addClass('clicked');
        selectedPrice = $(item).find('[id^="getItemPrice-"]').val();
        selectedItemId = $(item).find('[id^="getItemId-"]').val();
        selectedItemName = $(item).find('[id^="getItemName-"]').val();
    }

    $('.clickable-item').click(function() {
        handleItemClick(this);
    });

    function handlePaymentClick(item) {
        $('.clickable-payment').removeClass('clicked');
        $(item).addClass('clicked');
        getPaymentMethodValue = $(item).find('input[type="hidden"]').val();
        paymentTypeValue = $(item).find('.getPaymentType').val();
    }

    $('.clickable-payment').click(function() {
        handlePaymentClick(this);
    });

    $('#checkout').click(function() {
        var userIdInputValue = $('#userIdInput').val();
        var serverIdInputValue = $('#serverIdInput').val();
        var userPhoneInputValue = $('#userPhoneInput').val();
    
        if (userIdInputValue.trim() === '') {
            showError('Harap isi semua Data kamu!');
            return;
        }
    
        if (userPhoneInputValue.trim() === '') {
            showError('Harap isi nomor telepon kamu!');
            return;
        }
        if (selectedPrice !== null) {
            $('#userPhoneNumber').text(userPhoneInputValue);
            $('#itemName').text(selectedItemName);
            $('#itemPrice').text('Rp. ' + formatRupiah(selectedPrice));
            $('#itemId').val(selectedItemId);
            $('#userId').text($('#userIdInput').val());
            $('#serverId').text($('#serverIdInput').val());
            $('#paymentType').text(paymentTypeValue);
            $('#paymentMethod').text(getPaymentMethodValue);
    
            $('#checkoutModal').modal('show');
        } else {
            showError('Silakan pilih harga terlebih dahulu.');
        }
    });

    $('#confirmCheckout').click(function() {
        $('#loadingOverlay').show();
        $.ajax({
            url: '/topup/{{ $game->slug }}/process',
            type: 'POST',
            data: {
                price: selectedPrice,
                itemName: selectedItemName,
                userId: $('#userId').text(),
                serverId: $('#serverId').text(),
                userPhone: $('#userPhoneInput').val(),
                itemId: selectedItemId,
                paymentType: paymentTypeValue,
                paymentMethod: getPaymentMethodValue,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    $('#loadingOverlay').hide();
                    showError(response.unaccepted);
                }
            },
            error: function(xhr, status, error) {
                $('#loadingOverlay').hide();
                showError(error.unaccepted);
            }
        });

        // Tutup modal setelah mengklik "OK"
        $('#checkoutModal').modal('hide');
    });
});

function formatRupiah(angka) {
    var number_string = angka.toString();
    var split = number_string.split(',');
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}
