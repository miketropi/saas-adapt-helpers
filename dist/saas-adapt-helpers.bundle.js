/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/main.js":
/*!*********************!*\
  !*** ./src/main.js ***!
  \*********************/
/***/ (() => {

/**
 * Javascript
 * 
 * @since 1.0.0
 */

;
(function (w, $) {
  'use strict';

  var ready = function ready() {
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
  };
  $(ready);
  var filterProductByKeyword = function filterProductByKeyword() {
    function delay(callback, ms) {
      var timer = 0;
      return function () {
        var context = this,
          args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          callback.apply(context, args);
        }, ms || 0);
      };
    }

    // Search Header Ajax
    $('#searchProductName').keyup(delay(function () {
      var sortByValue = $('#sortByProductSAH').val();
      var valueTerms = $('#filterByTermsSAH').val();
      if ($(this).val().length == 0) {
        $('#keywordProduct').val('');
        ajaxFunction('', 1, sortByValue, valueTerms);
        return;
      }
      var keyword = $(this).val();
      $('#keywordProduct').val(keyword);
      ajaxFunction(keyword, 1, sortByValue, valueTerms);
    }, 1000));
  };
  var filterPaginationProduct = function filterPaginationProduct() {
    $(document).on('click', '.sah-paginations .page-numbers', function (e) {
      e.preventDefault();
      var href = $(this).attr('href');
      var page = gup('paged', href);
      var keyword = $('#keywordProduct').val();
      var sortByValue = $('#sortByProductSAH').val();
      var valueTerms = $('#filterByTermsSAH').val();
      ajaxFunction(keyword, page, sortByValue, valueTerms);
    });
  };
  var filterProductBySortBy = function filterProductBySortBy() {
    $('.sah-product-listing__sortby select[name="filterSortBy"]').on('change', function () {
      var sortByValue = $(this).val();
      var keyword = $('#keywordProduct').val();
      var valueTerms = $('#filterByTermsSAH').val();
      $('#sortByProductSAH').val(sortByValue);
      ajaxFunction(keyword, 1, sortByValue, valueTerms);
    });
  };
  var filterProductByTerms = function filterProductByTerms() {
    var keyword = $('#keywordProduct').val();
    var sortByValue = $('#sortByProductSAH').val();
    $('.sah_checkbox_term').on('change', function () {
      $('#SAH_filter_selected').html("");
      $(".sah_checkbox_term").each(function () {
        if ($(this).is(":checked")) {
          $('#SAH_filter_selected').append('<div class="item-selected" data-slug="' + $(this).val() + '">' + $(this).data('label') + '<span class="close-btn"></span></div>');
        }
      });
      if ($('#SAH_filter_selected .item-selected').length > 0) {
        $('#SAH_filter_selected').prepend($('<div class="clear-all">Clear All</div>'));
      }
      $('#SAH_filter_selected .item-selected .close-btn').click(function (e) {
        e.preventDefault();
        $('input[name="' + $(this).parent().data('slug') + '"]').trigger('click');
      });
      $('#SAH_filter_selected .clear-all').click(function (e) {
        e.preventDefault();
        $('.sah_checkbox_term:checked').trigger('click');
        $('#keywordProduct').val('');
        $('#sortByProductSAH').val('');
        $('#filterByTermsSAH').val('');
        $('#searchProductName').val('');
      });
      var selectedCheckboxes = $('.sah_checkbox_term:checked');
      var taxonomyFilters = {};
      selectedCheckboxes.each(function () {
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
      $('#filterByTermsSAH').val(filterDataTax);
      ajaxFunction(keyword, 1, sortByValue, filterDataTax);
    });
  };
  function ajaxFunction(keyword, page, sort_by, filterDataTax) {
    $.ajax({
      url: SAH_PHP_DATA.ajax_url,
      type: 'post',
      dataType: "json",
      data: {
        'action': 'filter_Get_Product',
        's': keyword,
        'paged': page,
        'sort_by': sort_by,
        'filter': filterDataTax
      },
      beforeSend: function beforeSend() {
        $('.sah-product-item').addClass('skeleton');
      },
      success: function success(data) {
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
  function gup(name, url) {
    if (!url) url = location.href;
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(url);
    return results == null ? 0 : results[1];
  }
  var toggleSidebar = function toggleSidebar() {
    $('#filterProduct').click(function (e) {
      e.preventDefault();
      $('.sah-product-listing-page__sidebar').addClass('active-mb');
    });
    $('.sah-product-listing-page__sidebar .close-btn').click(function (e) {
      e.preventDefault();
      $('.sah-product-listing-page__sidebar').removeClass('active-mb');
    });
    $(document).mouseup(function (e) {
      var sidebar = $('.sah-product-listing-page__sidebar');
      // if the target of the click isn't the container nor a descendant of the container
      if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0) {
        $('.sah-product-listing-page__sidebar').removeClass('active-mb');
      }
    });
  };
})(window, jQuery);

/***/ }),

/***/ "./src/scss/main.scss":
/*!****************************!*\
  !*** ./src/scss/main.scss ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/saas-adapt-helpers.bundle": 0,
/******/ 			"css/saas-adapt-helpers.bundle": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunksaas_adapt_helpers"] = self["webpackChunksaas_adapt_helpers"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/saas-adapt-helpers.bundle"], () => (__webpack_require__("./src/main.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/saas-adapt-helpers.bundle"], () => (__webpack_require__("./src/scss/main.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;