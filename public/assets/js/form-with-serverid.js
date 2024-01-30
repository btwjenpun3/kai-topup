var selectedPrice = null;
var selectedItemName = null;
var selectedItemId = null;
var getPaymentMethodValue = null;
var paymentTypeValue = null;

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

        if (userIdInputValue.trim() === '' || serverIdInputValue.trim() === '') {
            showError('Harap isi semua Data kamu!');
            return;
        }

        if (userPhoneInputValue.trim() === '') {
            showError('Harap isi nomor telepon kamu!');
            return;
        }

        if (!paymentTypeValue || paymentTypeValue.trim() === '') {
            showError('Pilih metode pembayaran terlebih dahulu.');
            return;
        }

        if (selectedPrice !== null) {
            $('#userPhoneNumber').text(userPhoneInputValue);
            $('#itemName').text(selectedItemName);
            $('#itemPrice').text('Rp. ' + formatRupiah(selectedPrice));
            $('#itemId').val(selectedItemId);
            $('#userId').text(userIdInputValue);
            $('#serverId').text(serverIdInputValue);
            $('#paymentType').text(paymentTypeValue);
            $('#paymentMethod').text(getPaymentMethodValue);

            $('#checkoutModal').modal('show');
        } else {
            showError('Silakan pilih harga terlebih dahulu.');
        }
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
