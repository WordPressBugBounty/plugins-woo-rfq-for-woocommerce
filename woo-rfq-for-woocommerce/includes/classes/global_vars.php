<?php


if(!function_exists('gpls_rfq_setup_globals')){
  function gpls_rfq_setup_globals()
  {


      //   $GLOBALS["gpls_woo_rfq_checkout_option"] = get_option('settings_gpls_woo_rfq_checkout_option','normal_checkout');
      $gpls_woo_rfq_checkout_option = get_option('settings_gpls_woo_rfq_checkout_option', 'normal_checkout');


      if (($gpls_woo_rfq_checkout_option) == '') {
          /// $GLOBALS["gpls_woo_rfq_checkout_option"] = 'normal_checkout';
          $gpls_woo_rfq_checkout_option = "normal_checkout";
          update_option('settings_gpls_woo_rfq_checkout_option', 'normal_checkout', true);
      }


      if (get_option('settings_gpls_woo_rfq_checkout_option', 'normal_checkout') == "rfq") {
          if (get_option('settings_gpls_woo_rfq_show_prices', 'no') == 'no') {

              //    $GLOBALS["gpls_woo_rfq_checkout_option"] = "rfq";
              $gpls_woo_rfq_checkout_option = "rfq";
          }
      }


      // $GLOBALS["gpls_woo_rfq_show_prices"] = "no";
      $gpls_woo_rfq_show_prices = "no";

      if ($gpls_woo_rfq_checkout_option == "rfq"
          && get_option('settings_gpls_woo_rfq_show_prices', 'no') === 'yes'
      ) {
          // $GLOBALS["gpls_woo_rfq_show_prices"] = "yes";
          $gpls_woo_rfq_show_prices = "yes";

      }

      if (get_option('settings_gpls_woo_rfq_checkout_option', 'normal_checkout') == "normal_checkout"
          && get_option('settings_gpls_woo_rfq_normal_checkout_show_prices', 'no') == 'yes'

      ) {
          //$GLOBALS["gpls_woo_rfq_show_prices"] = "yes";
          $gpls_woo_rfq_show_prices = "yes";
      }

      if (get_option('settings_gpls_woo_rfq_checkout_option', 'normal_checkout') == "rfq"
          && get_option('settings_gpls_woo_rfq_show_prices', 'no') === 'no'
      ) {

          //  $GLOBALS["gpls_woo_rfq_show_prices"] = "no";
          $gpls_woo_rfq_show_prices = "no";
      }


      if (function_exists('is_user_logged_in')) {

          if (get_option('settings_gpls_woo_rfq_hide_visitor_prices', 'no') == 'yes' && !is_user_logged_in()) {

              //  $GLOBALS["gpls_woo_rfq_show_prices"] = "no";
              $gpls_woo_rfq_show_prices = "no";
              //  $GLOBALS["gpls_woo_rfq_checkout_option"] = "rfq";
              $gpls_woo_rfq_checkout_option = "rfq";
              // $GLOBALS["hide_for_visitor"] = "yes";
              $hide_for_visitor = "yes";

          } else {
              //  $GLOBALS["hide_for_visitor"] = "no";
              $hide_for_visitor = "no";
          }
      } else {
          //  $GLOBALS["hide_for_visitor"] = "no";
          $hide_for_visitor = "no";
      }

      $GLOBALS["gpls_woo_rfq_checkout_option"] = $gpls_woo_rfq_checkout_option;
      $GLOBALS["gpls_woo_rfq_show_prices"] = $gpls_woo_rfq_show_prices;
      $GLOBALS["hide_for_visitor"] = $hide_for_visitor;


  }


}