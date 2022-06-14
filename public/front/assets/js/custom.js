$(document).on('click', ".add-to-cart", function () {
    const product = $(this).attr('data-product');
    const color = $(this).attr('data-color');
    const size = $(this).attr('data-size');
    const price = $(this).attr('data-price');
    const products_quantity = $(this).parents('.product-details-action-wrap').find(".quantity-selector").val();
    const box_product = $('#box_product').val();

    const formData = new FormData();
    formData.append('product', product);
    formData.append('color', color);
    formData.append('size', size);
    formData.append('price', price);
    formData.append('products_quantity', products_quantity);
    formData.append('box_product', box_product);

    $.ajax({
        url: '/addToCart',
        type: 'post',
        processData: false, // important
        contentType: false, // important
        data: formData,
        dataType: "JSON",
        success: function (response) {
            window.location.href = "/cart";
        }
    });
});

$('#savecommand').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    var datastring = $(this).serialize();
    //console.log(datastring);
    //return false;
    jQuery.ajax({
        url: '/storeApi',
        type: 'post',
        data: datastring,
        dataType: "html",
        success: function (response) {
            window.location.href = "/thank-you";
        }
    });

    return false;
});

$("button.shopify-payment-button__button").click(function () {
    var upsell = $('.product-single__quantity').attr("upsell");
    var quantity_p = $('input#products_quantity').val();
    $('#product_quantity').val(quantity_p);
    var price_p = $('span.current_p_price').text();
    if (upsell == "true" && quantity_p == 3) {
        $('.sub-total').text(price_p * 2);
        $('.totaal').text((price_p * 2) + 20);
        $('#total_price').val(price_p * 2);
        $('#upsell-product').val("3 Pour le Prix de 2");
    } else {
        $('.sub-total').text(price_p * quantity_p);
        $('.totaal').text((price_p * quantity_p) + 20);
        $('#upsell-product').val("");
    }
});


$('input[type=radio][name=casa_ola_bra_casa]').change(function () {

    if (this.value == 'casa') {
        $('.shipping-price').text('20');
        $('.sub-total').text();
        $total = parseInt($('.sub-total').text()) + 20;
        $('.totaal').text($total);
        $('.casa').val("casa");
    }
    else if (this.value == 'hors_casa') {
        $('.shipping-price').text('45');
        $('.sub-total').text();
        $total = parseInt($('.sub-total').text()) + 45;
        $('.totaal').text($total);
        $('.casa').val("Hors casa");
    }
});







$('input[type=radio][name=city]').change(function () {
    if (this.value == 'casa') {
        $('.shipping-price').text('20');
        $('.sub-total').text();
        $total = parseInt($('.sub-total').text()) + 20;
        $('.totaal').text($total);
        $('.casa').val("casa");
    }
    else if (this.value == 'hors_casa') {
        $('.shipping-price').text('45');
        $('.sub-total').text();
        $total = parseInt($('.sub-total').text()) + 45;
        $('.totaal').text($total);
        $('.casa').val("Hors casa");
    }
});

var price = parseFloat($('.current_p_price').text());
$('#box_product').change(function () {
    if ($(this).val() === 'Sans Boite') {
        $('.current_p_price').text(price);
    }
    if ($(this).val() === 'Avec Boite') {
        $('.current_p_price').text(price + 50);
    }
});

// const modal = document.querySelector(".modal");
// const modalButton = document.querySelector(".modalButton");
// const modalCloseButton = document.querySelector(".modalCloseButton");
// const backdrop = document.querySelector('.backdrop');

// const toggleModal = (id) => {
//     if (id) {
//         const modal = document.querySelector(id);
//     }
//     modal.classList.toggle("modalActive");
//     backdrop.classList.toggle('backdropActive');
// };

// modalCloseButton.onclick = () => toggleModal();
// backdrop.onclick = () => toggleModal();

