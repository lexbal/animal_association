$(function() {
    $('body').on("click", '#add-to-cart', function(e) {
        e.preventDefault();

        let _this     = $(this);
        let _formData = new FormData();

        _formData.append('id', _this.attr('data-id'));

        $.ajax({
            type: 'POST',
            url: _this.attr('data-href'),
            data: _formData,
            contentType : false,
            processData : false,
        }).then(function(response) {
            if (response.success) {
                $(".left-nav .cart").empty().append(response.cart);

                if (response.quantity) {
                    $(".card-body .quantity").empty().append(response.quantity);

                    _this.attr("disabled", true);
                } else {
                    _this.hide()
                }
            }
        });
    });
});