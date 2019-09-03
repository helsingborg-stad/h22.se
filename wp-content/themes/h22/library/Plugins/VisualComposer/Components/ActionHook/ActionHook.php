<?php

namespace H22\Plugins\VisualComposer\Components\ActionHook;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\ActionHook\ActionHook')) :
    class ActionHook extends \WPBakeryShortCode
    {
        use BaseComponentController;

        public function __construct()
        {
            $settings = array(
                'name' => __('Action hook', 'h22'),
                'base' => 'vc_h22_action_hook',
                'icon' => 'vc_icon-vc-gitem-post-excerpt',
                'category' => __('Utility', 'js_composer'),
                'description' => __('Invokes all functions attached to action hook.', 'h22'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Action name', 'h22'),
                        'description' => __('This element invokes all functions attached to the action hook defined above. Native Wordpress actions (eg. the_content, init, wp_head etc) are disabled for safety reasons. Don\'t use this element unless you know what you are doing since it can probably break an enitre site.', 'h22'),
                        'param_name' => 'action_name',
                        'holder' => 'div',
                        'group' => __('General', 'h22'),
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Description', 'h22'),
                        'description' => __('Just a description of the action hook for administrative purpose. This will not effect the output.', 'h22'),
                        'param_name' => 'action_description',
                        'group' => __('General', 'h22'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Enable output in Page Builder Templates', 'h22'),
                        'description' => __('Action Hook Elements are disabled in Page Builder templates by default.', 'h22'),
                        'param_name' => 'enable_template_output',
                        'group' => __('General', 'h22'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Extra class name', 'js_composer'),
                        'param_name' => 'el_class',
                        'value' => '',
                        'description' => __(
                            'Style particular content element differently - add a class name and refer to it in custom CSS.',
                            'js_composer'
                        ),
                        'group' => __('Settings', 'h22'),
                    ),
                ),
                'html_template' => dirname(__FILE__) . '/ActionHook.php',
                'class' => 'vc-h22-action-hook'
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }
        public function prepareData($data)
        {
            $disabledActions = array(
                'muplugins_loaded',
                'registered_taxonomy',
                'registered_post_type',
                'plugins_loaded',
                'sanitize_comment_cookies',
                'load_textdomain',
                'after_setup_theme',
                'init',
                'wp_loaded',
                'parse_request',
                'send_headers',
                'parse_query',
                'pre_get_posts',
                'posts_selection',
                'wp',
                'template_redirect',
                'get_header',
                'wp_enqueue_scripts',
                'wp_head',
                'wp_print_styles',
                'wp_print_scripts',
                'the_post',
                'dynamic_sidebar',
                'wp_meta',
                'get_footer',
                'wp_footer',
                'wp_print_footer_scripts',
                'wp_before_admin_bar_render',
                'wp_after_admin_bar_render',
                'shutdown'
            );

            if (!empty($data['action_name']) && in_array($data['action_name'], $disabledActions)) {
                $data['action_name'] = false;
            }

            if (get_post_type() === 'pb-template') {
                $data['disableOutput'] = isset($data['enable_template_output']) && $data['enable_template_output'] === 'true' ? false : true;
            }

            return $data;
        }
    }
endif;
