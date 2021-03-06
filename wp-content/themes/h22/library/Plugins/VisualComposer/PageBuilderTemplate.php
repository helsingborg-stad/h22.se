<?php

namespace H22\Plugins\VisualComposer;

use \H22\Helper\ACF;

class PageBuilderTemplate
{
    public static $postTypeSlug = 'pb-template';
    public $archiveLayoutPieces = false;
    public function __construct()
    {
        add_filter('the_content', array($this, 'replacePostContentWithTemplateContent'), 10);
        add_filter('the_content', array($this, 'replaceAcfPlaceholders'), 20);
        add_action('views/templates/archive/before-archive', array($this, 'outputArchiveLayoutPiece'), 0, 1000);
        add_action('views/templates/archive/after-archive', array($this, 'outputArchiveLayoutPiece'), 0, 1000);
        add_filter('register_post_type_args', array($this, 'enablePreview'), 2, 2);
        add_filter('vc_is_valid_post_type_be', array($this, 'enableVcEditor'), 10);
        add_filter('vc_role_access_with_backend_editor_get_state', array($this, 'setBackendEditorAsDefault'), 20, 2);
        add_filter('vc_get_all_templates', array($this, 'customizeTemplatesTab'), 10, 1);
        add_filter('vc_load_default_templates', array($this, 'addSiteTemplates'), 10, 1);
        add_action('Municipio/Admin/Options/Archives/fieldArgs', array($this, 'addAcfOptionsForArchiveTemplates'), 10, 4);
        add_action('admin_init', array($this, 'addAcfFieldsForPosttypeTemplates'));

        $this->registerPostType();
    }

    public function replaceAcfPlaceholders($content)
    {
        if (get_post_type() === self::$postTypeSlug
        || !is_singular(get_post_type())
        || get_post_meta(get_queried_object_id(), '_wpb_vc_js_status', true) === 'true'
        || !in_the_loop()
        || !is_main_query()) {
            return $content;
        }

        preg_match_all('/{{acf:(.*?)}}/m', $content, $matches, PREG_SET_ORDER, 0);

        if (!empty($matches)) {
            foreach ($matches as $match) {
                $field = get_field($match[1], get_queried_object_id());
                $content = str_replace($match[0], !empty($field) && is_string($field) ? $field : '', $content);
            }
        }

        return $content;
    }

    public function replacePostContentWithTemplateContent($content)
    {
        if (get_post_type() === self::$postTypeSlug
        || !is_singular(get_post_type())
        || get_post_meta(get_queried_object_id(), '_wpb_vc_js_status', true) === 'true'
        || !in_the_loop()
        || !is_main_query()) {
            return $content;
        }

        $singleTemplateFields = array(
            [
                'key' => 'page_builder_template',
                'id' =>  get_queried_object_id()
            ],
            [
                'key' => 'page_builder_template_single_' . get_post_type(),
                'id' =>  'options'
            ],
            [
                'key' => 'page_builder_template_single',
                'id' =>  'options'
            ],
        );

        $templateId = ACF::getFieldsMulti($singleTemplateFields);

        $templateId = is_object($templateId) ? $templateId->ID : $templateId;


        if (!$templateId || !get_post_meta($templateId, '_wpb_vc_js_status', true)) {
            return $content;
        }

        return apply_filters('PageBuilderTemplate/replacePostContentWithTemplateContent/template', get_post_field('post_content', $templateId), get_queried_object_id());
    }

    public function addAcfFieldsForPosttypeTemplates()
    {
        $pageParam = isset($_GET['page']) ? $_GET['page'] : null;

        if (!function_exists('acf_add_local_field_group') || $pageParam  !== 'acf-options-post-types') {
            return;
        }

        $postTypesToIgnore = array('pb-template', 'attachment');
        $postTypesToIgnore = apply_filters('H22/Plugins/VisualComposer/PageBuilderTemplate/PostTypeTemplates/postTypesToIgnore', $postTypesToIgnore);
        $postTypes = array_filter(get_post_types(['public' => true]), function ($postType) use ($postTypesToIgnore) {
            return !in_array($postType, $postTypesToIgnore);
        });

        foreach ($postTypes as $postType) {
            acf_add_local_field_group(array(
                'key' => 'group_' . md5($postType),
                'title' => __(ucfirst($postType) . ' template', 'h22'),
                'fields' => array(array(
                        'key' => 'field_' . md5($postType),
                        'label' => 'Template',
                        'name' => 'page_builder_template_single_' . sanitize_title($postType),
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => self::getTemplatesByTemplateType('single'),
                        'default_value' => array(),
                        'allow_null' => 1,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                )),
                'location' => array(
                    0 => array(
                        0 => array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'acf-options-post-types',
                        ),
                    ),
                ),
                'menu_order' => 100,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        }
    }

    public function addAcfOptionsForArchiveTemplates($fieldArgs, $postType, $args, $taxonomies)
    {
        if (empty($args->public) || !$args->has_archive) {
            return $fieldArgs;
        }

        $fieldArgs['fields'][] = array(
                    'key' => 'field_5d10c0e60933c_' . md5($postType),
                    'label' => 'Page Builder Template',
                    'name' => 'page_builder_template_archive_' . sanitize_title($postType),
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => self::getTemplatesByTemplateType('archive'),
                    'default_value' => array(),
                    'allow_null' => 1,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
            );

        return $fieldArgs;
    }


    public static function getTemplatesByTemplateType($templateType)
    {
        $choices = array();
        $posts = get_posts(array('post_type' => self::$postTypeSlug, 'tax_query' => array(array(
            'taxonomy' => self::$postTypeSlug . '-type',
            'field' => 'slug',
            'terms' => $templateType,
        ))));

        if (is_array($posts) && !empty($posts)) {
            foreach ($posts as $post) {
                $choices[$post->ID] = $post->post_title . ' (Template ID: ' . $post->ID . ')';
            }
        }
        return $choices;
    }

    public function addSiteTemplates($templates)
    {
        $savedTemplates = array_map(function ($template) {
            return array(
                    'name' => $template->post_title . ' (ID: ' . $template->ID . ')',
                    'content' => $template->post_content
                );
        }, get_posts(
            [
                'post_type' => self::$postTypeSlug,
                'posts_per_page' => -1,
                'meta_key' => 'save_as_site_template',
                'meta_value' => '1',
                'meta_compare' => '='
            ]
        ));
            
        if (empty($savedTemplates)) {
            return $templates;
        }
            
        return array_merge($savedTemplates, $templates);
    }

    public function customizeTemplatesTab($templateTabs)
    {
        $templateTabs = array_map(function ($tab) {
            if ($tab['category'] !== 'default_templates') {
                return $tab;
            }

            $tab['category_name'] = __('Site Templates', 'h22');
            $tab['category_description'] = __('Append site template to the current layout. Add/Edit/Remove Site Templates through the "Page Builder Templates" tab in admin menu.', 'h22');

            return $tab;
        }, $templateTabs);

        return $templateTabs;
    }

    /**
     *
     */
    public function outputArchiveLayoutPiece()
    {
        if (is_array($this->archiveLayoutPieces)
            && empty($this->archiveLayoutPieces)
            || $this->archiveLayoutPieces === null) {
            return;
        }

        if (!is_array($this->archiveLayoutPieces)) {
            $template = Acf::getFieldsMulti(array(
                array(
                    'key' => 'page_builder_template_archive_' . get_post_type(),
                    'id' => 'options'
                ),
                array(
                    'key' => 'page_builder_template_archive',
                    'id' => 'options'
                ),
            ));
            $archiveShortcode = '[vc_h22_archive_index]';

            // Make sure template is WP_Post instance
            if (!empty($template) && !is_object($template)) {
                $template = get_post($template);
            }

            if (!$template
            || empty($template->post_content)
            || get_post_meta($template->ID, '_wpb_vc_js_status', true) !== 'true'
            || !is_numeric(strpos($template->post_content, $archiveShortcode))) {
                $this->archiveLayoutPieces = null;
                return;
            }
            
            // Remove duplicate shortcodes & fix broken markup
            $re = '/\[vc_h22_archive_index.*?]/';
            $templateContent = str_replace($archiveShortcode, '', preg_replace($re, '!!ArchiveGoesHere!!', $template->post_content));
            $tidy = new \tidy();
            $templateContent = do_shortcode($tidy->repairString(wpb_js_remove_wpautop($templateContent), array('show-body-only' => true)));
            $templatePieces = array_filter(explode('!!ArchiveGoesHere!!', $templateContent), 'strlen');

            // Make sure we have start and end pieces
            if (empty($templatePieces) || count($templatePieces) !== 2) {
                $this->archiveLayoutPieces = null;
                return;
            }
             
            $this->archiveLayoutPieces = array_reverse($templatePieces);
        }

        echo array_pop($this->archiveLayoutPieces);
    }

    public function enableVcEditor($type)
    {
        if (is_admin() && get_post_type() === self::$postTypeSlug) {
            return true;
        }

        return $type;
    }

    public function setBackendEditorAsDefault($state, $role)
    {
        if (is_admin() && get_post_type() === self::$postTypeSlug) {
            return 'default';
        }

        return $state;
    }

    /**
     *
     */
    public function enablePreview($args, $postType)
    {
        if ($postType !== self::$postTypeSlug) {
            return $args;
        }

        if (is_user_logged_in() && isset($_GET['preview']) && $_GET['preview'] === 'true' || is_admin() && !isset($_GET['post_type'])) {
            $args['public'] = true;
        }

        return $args;
    }

    public function setDefaultTerms($slug, $postTypes, $args)
    {
        $taxonomySlug = self::$postTypeSlug . '-type';
        if ($slug !== $taxonomySlug) {
            return;
        }

        $defaultTerms = array('Archive', 'Single', 'Header', 'Footer');
        $existingTerms = get_terms(array(
            'taxonomy' => $taxonomySlug,
            'hide_empty' => false,
            'fields' => 'names'
        ));

        foreach ($defaultTerms as $termName) {
            if (empty($existingTerms) || !in_array($termName, $existingTerms)) {
                wp_insert_term(
                    $termName,
                    $taxonomySlug,
                    array(
                        'slug' => sanitize_title($termName),
                    )
                );
            }
        }
    }


    public function registerTaxonomy()
    {
        new \H22\Entity\Taxonomy(
            __('Template Types', 'h22'),
            __('Template Type', 'h22'),
            self::$postTypeSlug . '-type',
            array(self::$postTypeSlug),
            array(
                'hierarchical' => true,
                'publicly_queryable' => false,
                'show_in_menu' => false,
                'meta_box_cb' => false,
                'show_admin_column' => true,
                'show_in_quick_edit' => false
            )
        );
    }

    public function registerPostType()
    {
        new \H22\Entity\PostType(
            _x('Page Builder Templates', 'Post type plural', 'h22'),
            _x('Page Builder Template', 'Post type singular', 'h22'),
            self::$postTypeSlug,
            array(
                'description' => __('H22 News', 'h22'),
                'menu_icon' => 'dashicons-layout',
                'public' => false,
                'publicly_queriable' => false,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'has_archive' => false,
                // 'rewrite'              =>   array(
                //     'slug'       =>   __('news', 'h22'),
                //     'with_front' =>   false
                // ),
                'hierarchical' => false,
                'exclude_from_search' => false,
                'taxonomies' => array(),
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                    'revisions'
                ),
                'show_in_rest' => true,
                'menu_position' => 30,
            )
        );
    }
}
