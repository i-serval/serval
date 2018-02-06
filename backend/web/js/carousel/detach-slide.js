$(function () {

    $('.slides-list-detach-link').click(function(event){

        event.preventDefault();

        var carousel_id = $("#slides-list").attr('data-carousel-id');
        var table_row = $(this).closest('tr');
        var carousel_item_id = table_row.attr('data-id');

        $.ajax({

            url: '/carousel/detach-carousel-item',
            method: 'POST',
            data: {'carousel_id':carousel_id, 'carousel_item_id':carousel_item_id},

            success: function(response) {

                table_row.remove();

            }

        });

    });

});
