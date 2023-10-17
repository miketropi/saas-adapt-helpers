/**
 * Javascript
 * 
 * @since 1.0.0
 */

;((w, $) => {
    'use strict';
  
    const ready = () => {
      //Keywords
      filterProductByKeyword();

      //Pagination
      filterPaginationProduct();

      //Sort By
      filterProductBySortBy();
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

            var sortByValue = $('#sortByProductSAH').val();

            if ( $(this).val().length == 0 ) {
                $('#keywordProduct').val('');
                ajaxFunction('', 1, sortByValue);
                return;
            }
            var keyword = $(this).val();

            $('#keywordProduct').val(keyword);
            
            ajaxFunction(keyword, 1, sortByValue);
        }, 1000 ) );
    }

    var filterPaginationProduct = function () {
        $(document).on('click', '.sah-paginations .page-numbers', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var page = gup('paged', href);

            var keyword     = $('#keywordProduct').val();
            var sortByValue = $('#sortByProductSAH').val();
            ajaxFunction(keyword, page, sortByValue);
        });
    }

    var filterProductBySortBy = function() {
        $('.sah-product-listing__sortby select[name="filterSortBy"]').on('change', function() {
            
            var sortByValue = $(this).val();
            var keyword     = $('#keywordProduct').val();
            $('#sortByProductSAH').val(sortByValue);
        
            ajaxFunction(keyword, 1, sortByValue);
        });
    }

    function ajaxFunction(keyword, page, sort_by){
        $.ajax({
            url: SAH_PHP_DATA.ajax_url,
            type: 'post',
            dataType : "json",
            data: {
              'action': 'filter_Get_Product',
              's' : keyword,
              'paged' : page,
              'sort_by' : sort_by,
            },
            beforeSend: function() {
                $('.sah-product-item').addClass('skeleton');
            },
            success: function(data) {
                $('.sah-product-item').removeClass('skeleton');

                $('html, body').animate({
                    scrollTop: $(".sah-product-listing-page__inner").offset().top - 80
                }, 300);

                $('.sah-product-listing__items').html(data.dataProduct);

                $('.sah-paginations').remove();
                $('.sah-product-listing').append(data.dataPagination);
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