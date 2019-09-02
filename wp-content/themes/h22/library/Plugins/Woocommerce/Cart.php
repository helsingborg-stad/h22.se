<?php

namespace H22\Plugins\Woocommerce;

class Cart
{
    public function __construct()
    {
        add_filter('wp_nav_menu_primary_items', array($this, 'appendMarkupForCounter'), 10, 2);
        add_filter('woocommerce_add_to_cart_fragments', array($this, 'updateCartUsingAjax'));
    }

    public function updateCartUsingAjax($fragments)
    {
        if (!wp_doing_ajax()) {
            return $fragments;
        }
        $fragments['span.c-badge.c-badge--cart-count'] = self::getCartCounter();

        return $fragments;
    }

    public static function getCartCounter()
    {
        if (!function_exists('WC')) {
            return '';
        }

        $cartCount = WC()->cart->cart_contents_count;
        return '<span class="c-badge c-badge--cart-count">' . strval($cartCount) . '</span>';
    }

    public static function getCartUrl()
    {
        return apply_filters('woocommerce_get_cart_url', wc_get_page_permalink('cart'));
    }

    public function appendMarkupForCounter($items)
    {
        if (!function_exists('WC')) {
            return $items;
        }

        $cartUrl = preg_quote(self::getCartUrl(), '/');
        $re = '/(<a href="' . $cartUrl . '".*?>)(.*?)(<\/a>)/m';

        $str = $items;
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        if (count($matches) === 0) {
            return $items;
        }

        return preg_replace($re, '$1 <i class="fa fa-shopping-cart woocommerce" aria-hidden="true"></i>' . self::getCartCounter() . '$3', $str);
    }
}
