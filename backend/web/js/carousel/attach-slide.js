$(function () {

    var carousel_id = $('#attach-detach-items').attr('data-carousel-id');

    $( '#attach-detach-items').click(function(event){

      var checkbox =  $(event.target);

      if( checkbox.hasClass('attach-detach-carousel-item')  ) { // only for input

          var row = $(event.target).closest('tr');

          var carousel_item_id = row.attr('data-carousel-item-id');

          if( carousel_item_id !== undefined ){

              var counter = $(row).find('.use-count-value').find('span');

              var data = {'carousel_id':carousel_id, 'carousel_item_id':carousel_item_id}

              $("body").css("cursor", "progress");
              $(checkbox).css("cursor", "progress");

              if( !checkbox.is(':checked') ){

                  $.ajax({

                      url: '/carousel/detach-carousel-item',
                      method: 'POST',
                      data: data,

                      success: function(response) {

                          counter.html(parseInt(counter.html())-1);

                          $("body").css("cursor", "default");
                          $(checkbox).css("cursor", "default");

                      }

                  });

              } else{

                  $.ajax({

                      url: '/carousel/attach-carousel-item',
                      method: 'POST',
                      data: data,

                      success: function(response) {

                          counter.html(parseInt(counter.html())+1);

                          $("body").css("cursor", "default");
                          $(checkbox).css("cursor", "default");

                      }

                  });

              }

          }

      }

    });

});
