(function ($) {
  "use strict";

  const WPStarterWooCart = {
    init: function () {
      this.bindEvents();
      this.initMiniCart();
    },

    bindEvents: function () {
      $("body")
        .on("added_to_cart", this.updateCartButton)
        .on("added_to_cart removed_from_cart", this.updateCartFragments)
        .on("click", ".add_to_cart_button", this.handleAddToCart);

      $(".quantity").on("change", "input.qty", this.updateCartQuantity);
    },

    initMiniCart: function () {
      $(".cart-contents").hover(
        function () {
          $(".mini-cart-content").fadeIn();
        },
        function () {
          $(".mini-cart-content").fadeOut();
        }
      );
    },

    updateCartButton: function (event, fragments, cart_hash, button) {
      button.addClass("added").removeClass("loading");

      // Notification
      WPStarterWooCart.showNotification("Produit ajouté au panier");
    },

    updateCartFragments: function (event, fragments) {
      if (fragments) {
        $.each(fragments, function (key, value) {
          $(key).replaceWith(value);
        });
      }
    },

    handleAddToCart: function (e) {
      $(this).addClass("loading");
    },

    updateCartQuantity: function () {
      const $form = $("form.woocommerce-cart-form");
      const $button = $form.find('button[name="update_cart"]');

      $button.prop("disabled", false).trigger("click");
    },

    showNotification: function (message) {
      const $notification = $("<div/>", {
        class: "woo-notification",
        text: message,
      }).appendTo("body");

      setTimeout(() => {
        $notification.fadeOut(() => {
          $notification.remove();
        });
      }, 3000);
    },
  };

  $(document).ready(function () {
    WPStarterWooCart.init();
  });
})(jQuery);
