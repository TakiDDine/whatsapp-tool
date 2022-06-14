$('.preview-product').on('click', function (e) {
    e.preventDefault();

    const productId = $(this).attr('data-to-preview')

    $.ajax({
        url: "/preview",
        data: {
            product_id: productId
        },
        success: function (response) {
            $('body').append(response)
            $(`#productModal${productId}`).modal('show')
        }
    })

})