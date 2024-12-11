(function ($) {
  "use strict";

  const WPStarterWooCheckout = {
    init: function () {
      this.form = $("form.checkout");
      this.bindEvents();
      this.initializeFields();
    },

    bindEvents: function () {
      this.form.on("checkout_place_order", this.validateForm.bind(this));
      $("body").on("updated_checkout", this.refreshFields.bind(this));

      // Validation en temps réel
      this.form.on(
        "blur change",
        "input, select, textarea",
        this.validateField.bind(this)
      );
    },

    initializeFields: function () {
      // Initialisation des champs personnalisés
      this.initPhoneField();
      this.initPostcodeField();
    },

    initPhoneField: function () {
      const phoneInput = $("#billing_phone");
      if (phoneInput.length) {
        // Vous pouvez ajouter ici une bibliothèque de validation de téléphone
        phoneInput.on("input", this.validatePhone.bind(this));
      }
    },

    initPostcodeField: function () {
      const postcodeInput = $("#billing_postcode");
      if (postcodeInput.length) {
        postcodeInput.on("input", this.validatePostcode.bind(this));
      }
    },

    validateForm: function (e) {
      let isValid = true;
      const requiredFields = this.form.find(
        ".validate-required input, .validate-required select, .validate-required textarea"
      );

      requiredFields.each((i, field) => {
        if (!this.validateField({ target: field })) {
          isValid = false;
        }
      });

      if (!isValid) {
        e.preventDefault();
        this.showError("Veuillez remplir tous les champs obligatoires");
      }

      return isValid;
    },

    validateField: function (e) {
      const field = $(e.target);
      const wrapper = field.closest(".form-row");
      const value = field.val();
      let isValid = true;

      // Validation de base
      if (wrapper.hasClass("validate-required") && !value) {
        isValid = false;
      }

      // Validations spécifiques
      if (field.attr("type") === "email" && value) {
        isValid = this.validateEmail(value);
      }

      if (field.attr("id") === "billing_phone" && value) {
        isValid = this.validatePhone(value);
      }

      this.toggleError(wrapper, isValid);
      return isValid;
    },

    validateEmail: function (email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    },

    validatePhone: function (phone) {
      const re = /^[+]?[(]?[0-9]{3}[)]?[-\s.]?[0-9]{3}[-\s.]?[0-9]{4,6}$/;
      return re.test(phone);
    },

    validatePostcode: function (e) {
      const field = $(e.target);
      const wrapper = field.closest(".form-row");
      const value = field.val();

      // Adapter selon le pays
      const isValid = /^[0-9]{5}$/.test(value);
      this.toggleError(wrapper, isValid);
    },

    toggleError: function (wrapper, isValid) {
      if (!isValid) {
        wrapper.addClass("woocommerce-invalid");
        wrapper.removeClass("woocommerce-validated");
      } else {
        wrapper.removeClass("woocommerce-invalid");
        wrapper.addClass("woocommerce-validated");
      }
    },

    showError: function (message) {
      if (!$(".woocommerce-error").length) {
        this.form.prepend(
          `<ul class="woocommerce-error"><li>${message}</li></ul>`
        );
      }
    },

    refreshFields: function () {
      this.initializeFields();
    },
  };

  $(document).ready(function () {
    WPStarterWooCheckout.init();
  });
})(jQuery);
