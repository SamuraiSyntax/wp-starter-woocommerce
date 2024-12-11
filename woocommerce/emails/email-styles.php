<?php
/**
 * Email Styles
 */

if (!defined('ABSPATH')) {
    exit;
}

$bg        = '#f7f7f7';
$body      = '#ffffff';
$base      = '#2271b1';
$base_text = '#ffffff';
$text      = '#3c434a';

?>

#wrapper {
background-color: <?php echo esc_attr($bg); ?>;
padding: 70px 0;
width: 100%;
-webkit-text-size-adjust: none !important;
}

#template_container {
background-color: <?php echo esc_attr($body); ?>;
border-radius: 8px !important;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
margin-bottom: 30px;
}

#template_header {
background-color: <?php echo esc_attr($base); ?>;
border-radius: 8px 8px 0 0 !important;
color: <?php echo esc_attr($base_text); ?>;
padding: 30px;
text-align: center;
}

#template_header h1 {
color: <?php echo esc_attr($base_text); ?>;
font-family: Arial, sans-serif;
font-size: 28px;
font-weight: bold;
margin: 0;
text-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
}

#template_body {
padding: 40px;
}

.email-intro {
margin-bottom: 30px;
}

.order-details {
background: #fafafa;
border-radius: 4px;
padding: 20px;
margin-bottom: 30px;
}

.order-details h2 {
color: <?php echo esc_attr($text); ?>;
font-size: 20px;
margin: 0 0 20px;
}

.order-date {
color: #666;
font-size: 14px;
font-weight: normal;
}

.order-items {
width: 100%;
border-collapse: collapse;
margin-bottom: 20px;
}

.order-items th {
background: <?php echo esc_attr($base); ?>;
color: <?php echo esc_attr($base_text); ?>;
padding: 12px;
text-align: left;
}

.order-items td {
padding: 12px;
border-bottom: 1px solid #eee;
}

.shipping-info {
background: #f4f4f4;
border-radius: 4px;
padding: 20px;
margin-bottom: 30px;
}

.customer-actions {
text-align: center;
margin: 30px 0;
}

.social-links {
text-align: center;
margin-top: 30px;
padding-top: 20px;
border-top: 1px solid #eee;
}

.social-link {
display: inline-block;
margin: 0 10px;
color: <?php echo esc_attr($base); ?>;
text-decoration: none;
}

<?php