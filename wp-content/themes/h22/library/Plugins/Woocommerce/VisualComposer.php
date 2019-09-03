<?php

namespace H22\Plugins\Woocommerce;

class VisualComposer
{
    public function __construct()
    {
        add_filter('H22/Plugins/VisualComposer/RemoveElements/allowedComponents', array($this, 'enableWooCommerceComponents'));

        add_action('template_redirect', function () {
            remove_filter('the_content', 'WC_Template_Loader::unsupported_theme_shop_content_filter', 10);
            remove_filter('the_content', 'WC_Template_Loader::unsupported_theme_product_content_filter', 10);
        }, 12);

        add_filter('woocommerce_loop_add_to_cart_link', function ($button, $product, $args) {
            $args['class'] = 'btn btn--fill u-display-inline-block u-mt-2';
            return sprintf(
                '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                esc_url($product->add_to_cart_url()),
                esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                esc_html($product->add_to_cart_text())
            );
        }, 10, 3);
    }

    public function enableWooCommerceComponents($allowedComponents)
    {
        return array_merge($allowedComponents, array(
            'woocommerce_cart',
            'woocommerce_checkout',
            'woocommerce_order_tracking',
            'woocommerce_my_account',
            'product',
            'products',
            'product_page',
            'product_category',
            'add_to_cart'
        ));
    }
}
