(function ($) {
  "use strict";

  const WPStarterWooFilters = {
    init: function () {
      this.filterForm = $(".woo-filter-form");
      this.productsContainer = $(".products");
      this.bindEvents();
    },

    bindEvents: function () {
      this.filterForm.on(
        "change",
        "input, select",
        this.handleFilterChange.bind(this)
      );
      this.filterForm.on(
        "click",
        ".reset-filters",
        this.resetFilters.bind(this)
      );
      $(document).on(
        "click",
        ".woo-pagination a",
        this.handlePagination.bind(this)
      );
    },

    handleFilterChange: function (e) {
      e.preventDefault();
      this.updateProducts();
    },

    resetFilters: function (e) {
      e.preventDefault();
      this.filterForm[0].reset();
      this.updateProducts();
    },

    handlePagination: function (e) {
      e.preventDefault();
      const page = $(e.currentTarget).data("page");
      this.updateProducts(page);
    },

    updateProducts: function (page = 1) {
      const formData = new FormData(this.filterForm[0]);
      formData.append("action", "filter_products");
      formData.append("nonce", wpStarterWoo.nonce);
      formData.append("page", page);

      $.ajax({
        url: wpStarterWoo.ajaxUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          this.productsContainer.addClass("loading");
        },
        success: (response) => {
          if (response.success) {
            this.productsContainer.html(response.data.html);
            this.updateProductCount(response.data.count);
            this.updateUrl(formData);
          }
        },
        complete: () => {
          this.productsContainer.removeClass("loading");
        },
      });
    },

    updateProductCount: function (count) {
      $(".woo-product-count").text(count);
    },

    updateUrl: function (formData) {
      const params = new URLSearchParams(formData);
      const newUrl = `${window.location.pathname}?${params.toString()}`;
      window.history.pushState({}, "", newUrl);
    },
  };

  $(document).ready(function () {
    WPStarterWooFilters.init();
  });
})(jQuery);
