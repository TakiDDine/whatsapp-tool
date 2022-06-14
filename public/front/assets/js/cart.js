$('.cart-active').on('click', function (e) {
    e.preventDefault();

    $.ajax({
        url: "/ajax/cart",
        success: function (response) {
            console.log(response)
            $('#result').html(response)
        }
    })

})