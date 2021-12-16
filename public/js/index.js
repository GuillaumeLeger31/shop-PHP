(function($){
    $('.addPanier').click(function(event){
        event.preventDefault()
        $.get($(this).attr('href'),{}, function(data){
            if (data.panier[data.id] < 1) {
                window.location.reload(); // changer pour function.location.reload() //
            }
            console.log('prix' + data.total);
            console.log(data.panier[data.id]);
            $('#panier').empty().append(data.sum);
            $('#panier2').empty().append(data.sum);
            $('.qty' + data.id).empty().append(data.panier[data.id]);
            $('#total').empty().append(data.total);
            $('.paypal_total').empty().append(data.total);
        },'json');
    });
})(jQuery);