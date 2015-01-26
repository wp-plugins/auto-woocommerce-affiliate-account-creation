<?php

/*
  Plugin Name: Auto WooCommerce Affiliate Account Creation
  Plugin URI: https://wpaffiliatemanager.com
  Description: Automatically creates affiliate account for your WooCommerce users.
  Version: 1.1
  Author: wp.insider, affmngr
  Author URI: https://wpaffiliatemanager.com
 */

add_action('woocommerce_created_customer', 'wpam_wc_handle_customer_creation', 10, 3);
//add_action('user_register', 'wpam_wc_handle_customer_creation');

function wpam_wc_handle_customer_creation($user_id, $new_customer_data, $password_generated) {
    
    WPAM_Logger::log_debug("Auto WooCommerce Affiliate Creation - creating affiliate record");
    
    if(empty($user_id)){
        WPAM_Logger::log_debug("Auto WooCommerce Affiliate Creation - Error, email address is missing. Cannot create affiliate record!", 4);
        return;
    }
    
    $user_info = get_userdata($user_id); //get_user_by('user_login', $username);
    $fields = array();
    $fields['userId'] = $user_id;
    $fields['firstName'] = $user_info->first_name;
    $fields['lastName'] = $user_info->last_name;    
    $fields['email'] = $user_info->user_email;

    $userhandler = new WPAM_Util_UserHandler();
    $userhandler->create_wpam_affiliate_record($fields);
    WPAM_Logger::log_debug("Auto WooCommerce Affiliate Creation - affiliate record creation complete.");
}

