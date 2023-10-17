/**
 * Javascript
 * 
 * @since 1.0.0
 */

;((w, $) => {
    'use strict';
  
    const ready = () => {
      filterProductByKeyword();
      filterPaginationProduct();
    }
  
    $(ready);
  
    var filterProductByKeyword = function() {
        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                callback.apply(context, args);
                }, ms || 0);
            };
        }

        // Search Header Ajax
        $('#searchProductName').keyup( delay(function() {
            if ( $(this).val().length == 0 ) {
                $('#keywordProduct').val('');
                ajaxFunction(keyword = '', 1);
                return;
            }
            var keyword = $(this).val();

            $('#keywordProduct').val(keyword);

            ajaxFunction(keyword, 1);
        }, 500 ) );
    }

    var filterPaginationProduct = function () {
        $(document).on('click', '.sah-paginations .page-numbers', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var page = gup('paged', href);

            var keyword = $('#keywordProduct').val();
            ajaxFunction(keyword, page);
        });
    }

    function ajaxFunction(keyword, page){
        $.ajax({
            url: SAH_PHP_DATA.ajax_url,
            type: 'post',
            dataType : "json",
            data: {
              'action': 'filter_Get_Product',
              's' : keyword,
              'paged' : page,
            },
            success: function(data) {
                $('.sah-product-listing__items').html(data.dataProduct);

                $('.sah-paginations').remove();
                $('.sah-product-listing').append(data.dataPagination);
                console.log(data.message);
            }
        });
    }

    function gup( name, url ) {
        if (!url) url = location.href;
        name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var regexS = "[\\?&]"+name+"=([^&#]*)";
        var regex = new RegExp( regexS );
        var results = regex.exec( url );
        return results == null ? 0 : results[1];
    }
  
  })(window, jQuery);  