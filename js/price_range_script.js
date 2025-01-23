$(document).ready(function(){

    $('#price-range-submit').hide();

    $("#min_price,#max_price").on('change', function () {

        $('#price-range-submit').show();

        var min_price_range = parseInt($("#min_price").val());

        var max_price_range = parseInt($("#max_price").val());

        if (parseInt(min_price_range) > parseInt(max_price_range)) {
            $('#max_price').val(parseInt(min_price_range));
        }

        $("#slider-range").slider({
            values: [parseInt(min_price_range), parseInt(max_price_range)]
        });

    });


    $("#min_price,#max_price").on("paste keyup", function () {

        $('#price-range-submit').show();

        var min_price_range = parseInt($("#min_price").val());

        var max_price_range = parseInt($("#max_price").val());

        if(parseInt(min_price_range) == parseInt(max_price_range)){

            max_price_range = parseInt(min_price_range) + 100;

            $("#min_price").val(parseInt(min_price_range));
            $("#max_price").val(parseInt(max_price_range));
        }

        $("#slider-range").slider({
            values: [parseInt(min_price_range), parseInt(max_price_range)]
        });

    });


    $(function () {
        $("#slider-range").slider({
            range: true,
            orientation: "horizontal",

            slide: function (event, ui) {
                if (parseInt(ui.values[0]) == parseInt(ui.values[1])) {
                    return false;
                }

                $("#min_price").val(parseInt(ui.values[0]));
                $("#max_price").val(parseInt(ui.values[1]));
            }
        });

        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val($("#slider-range").slider("values", 1));

    });

    $("#slider-range,#price-range-submit").click(function () {

        var min_price = parseInt($('#min_price').val());
        var max_price = parseInt($('#max_price').val());

        $("#searchResults").text("Here List of products will be shown which are cost between " + min_price  +" "+ "and" + " "+ max_price + ".");
    });

});
