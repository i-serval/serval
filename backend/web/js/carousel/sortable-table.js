$(function () {

    function fixWidthHelper(e, ui) {

        ui.children().each(function () {

            $(this).width($(this).width());
        });

        return ui;
    }

    var carousel_id = $('#slides-list').data('carousel-id');

    $('#slides-list tbody').sortable({

        placeholder: "ui-state-highlight",
        helper: fixWidthHelper,
        forcePlaceholderSize: true,
        forceHelperSize: true,
        cursor: "move",
//        axis: 'y',

        update: function (event, ui) {

            $('#slides-list tbody').sortable('disable');

            $(this).children().each(function (index) {

                var order_td = $(this).find('td.slides-list-order')

                order_td.find('span').html(index + 1);
                order_td.attr('data-order', index + 1);

                console.log( index );

            });

            var data = [];

            $(this).find('tr').each(function () {

               data.push({'id': $(this).attr('data-id'), 'order': $(this).find('td.slides-list-order').attr('data-order')});

            });

            $.ajax({
                url: '/carousel-item/update-order?carousel_id=' + carousel_id,
                method: 'POST',
                data: {'update_data': JSON.stringify(data)},
                success: function(response) {
                    $('#slides-list tbody').sortable('enable');
                }

            });

        }

    });

});
