<?php
function wp_starter_woo_email_styles($css)
{
  // Utilisation de variables CSS pour une meilleure maintenance
  $css .= "
      :root {
          --email-bg: #f7f7f7;
          --email-text: #333333;
          --email-primary: #2271b1;
          --email-secondary: #eeeeee;
      }
      
      .email-wrapper {
          background-color: var(--email-bg);
          padding: 20px;
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
      }
      
      .order-details {
          background: #ffffff;
          padding: 15px;
          border-radius: 4px;
          box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      }
      
      /* Optimisation pour mobile */
      @media only screen and (max-width: 480px) {
          .email-wrapper {
              padding: 10px;
          }
      }
  ";
  return $css;
}
add_filter('woocommerce_email_styles', 'wp_starter_woo_email_styles');
