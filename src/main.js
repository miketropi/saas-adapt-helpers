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

      // Checkbox Terms
      filterProductByTerms();

      //Toggle Sidebar
      toggleSidebar();
      showLessTermsSidebar();
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
            var valueTerms = $('#filterByTermsSAH').val();

            if ( $(this).val().length == 0 ) {
                $('#keywordProduct').val('');
                ajaxFunction('', 1, sortByValue, valueTerms);
                return;
            }
            var keyword = $(this).val();

            $('#keywordProduct').val(keyword);
            
            ajaxFunction(keyword, 1, sortByValue, valueTerms);
        }, 1000 ) );
    }

    var filterPaginationProduct = function () {
        $(document).on('click', '.sah-paginations .page-numbers', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var page = gup('paged', href);

            var keyword     = $('#keywordProduct').val();
            var sortByValue = $('#sortByProductSAH').val();
            var valueTerms  = $('#filterByTermsSAH').val();
            ajaxFunction(keyword, page, sortByValue, valueTerms);
        });
    }

    var filterProductBySortBy = function() {
        $('.sah-product-listing__sortby select[name="filterSortBy"]').on('change', function() {
            
            var sortByValue = $(this).val();
            var keyword     = $('#keywordProduct').val();
            var valueTerms = $('#filterByTermsSAH').val();
            $('#sortByProductSAH').val(sortByValue);
        
            ajaxFunction(keyword, 1, sortByValue, valueTerms);
        });
    }

    var filterProductByTerms = function() {
        var keyword = $('#keywordProduct').val();
        var sortByValue = $('#sortByProductSAH').val();

        $('.sah_checkbox_term').on('change', function() {

            $('#SAH_filter_selected').html("");
            
            $(".sah_checkbox_term").each(function(){
                if($(this).is(":checked")){
                    $('#SAH_filter_selected').append('<div class="item-selected" data-slug="'+ $(this).val() +'">'+$(this).data('label')+'<span class="close-btn"></span></div>')
                }
            });

            if ( $('#SAH_filter_selected .item-selected').length > 0 ) {
                $('#SAH_filter_selected').prepend($('<div class="clear-all">Clear All</div>'));
            }

            $('#SAH_filter_selected .item-selected .close-btn').click( function(e) {
                e.preventDefault();
                $('input[name="'+ $(this).parent().data('slug') +'"]').trigger('click');
            });
            $('#SAH_filter_selected .clear-all').click( function(e) {
                e.preventDefault();
                $('.sah_checkbox_term:checked').trigger('click');
                $('#keywordProduct').val('');
                $('#sortByProductSAH').val('');
                $('#filterByTermsSAH').val('');
                $('#searchProductName').val('');
            });

            var selectedCheckboxes = $('.sah_checkbox_term:checked');
            var taxonomyFilters = {};

            selectedCheckboxes.each( function() {
                var taxonomy = $(this).data('tax');
                var label = $(this).data('label');
                var term = $(this).val();

                if (!taxonomyFilters[taxonomy]) {
                    taxonomyFilters[taxonomy] = [];
                }
                if (taxonomyFilters[taxonomy].indexOf(term) === -1) {
                    taxonomyFilters[taxonomy].push(term);
                }

            });
            
            var filterDataTax = JSON.stringify(taxonomyFilters);
            
            $('#filterByTermsSAH').val( filterDataTax );
            
            ajaxFunction(keyword, 1, sortByValue, filterDataTax);

        });

    }

    function ajaxFunction(keyword, page, sort_by, filterDataTax){
        $.ajax({
            url: SAH_PHP_DATA.ajax_url,
            type: 'post',
            dataType : "json",
            data: {
              'action': 'filter_Get_Product',
              's' : keyword,
              'paged' : page,
              'sort_by' : sort_by,
              'filter' : filterDataTax
            },
            beforeSend: function() {
                $('.sah-product-item').addClass('skeleton');
            },
            success: function(data) {
                $('.sah-product-item').removeClass('skeleton');

                $('html, body').animate({
                    scrollTop: $(".sah-product-listing-page__inner").offset().top - 120
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

    var toggleSidebar = function (){
        $('#filterProduct').click( function (e) {
            e.preventDefault();
            $('.sah-product-listing-page__sidebar').addClass('active-mb');
        })

        $('.sah-product-listing-page__sidebar .close-btn').click( function(e) {
            e.preventDefault();
            $('.sah-product-listing-page__sidebar').removeClass('active-mb');
        })

        $(document).mouseup(function(e) {
            var sidebar = $('.sah-product-listing-page__sidebar');
            // if the target of the click isn't the container nor a descendant of the container
            if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0){
                $('.sah-product-listing-page__sidebar').removeClass('active-mb');
            }
        });
    }

    var showLessTermsSidebar = function (){
        $('.sah-product-listing-page__sidebar .product-options').each( function() {
            var productOpts = $(this);
            var boxOptions = productOpts.find('.box');
            var shown =  7;

            productOpts.find('.box:lt('+ shown +')').show();

            if ( boxOptions.length > shown ) {
                productOpts.find('.btn-show-more').show();
            }

            productOpts.find('.btn-show-more').click( function() {

                shown = productOpts.find('.box:visible').length + 7;

                if ( shown < boxOptions.length ) {
                    productOpts.find('.box:lt('+ shown +')').slideDown();
                }else{
                    productOpts.find('.box:lt('+ boxOptions.length +')').slideDown();

                    productOpts.find('.btn-show-more').hide();
                    productOpts.find('.btn-show-less').show();
                }

            });

            productOpts.find('.btn-show-less').click( function() {
                productOpts.find('.box').not(':lt(7)').slideUp();

                productOpts.find('.btn-show-more').show();
                productOpts.find('.btn-show-less').hide();
            });
            
        })
    }
  
  })(window, jQuery);  