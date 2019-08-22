<?php

/*
Plugin Name: Woocommerce Mods
Description: Woocommerce modifications
Version:     1.0
Author:      Nikolas Ramstedt
*/

namespace WooCommerceMods;

class WooCommerceMods
{
    public function __construct()
    {
        add_action('woocommerce_thankyou', array($this, 'autoCompleteOrders'));
    }

    public function autoCompleteOrders($orderId)
    {
        if (!$orderId) {
            return;
        }

        $order = wc_get_order($orderId);
        $order->update_status('completed');
    }
}

new \WooCommerceMods\WooCommerceMods();
