<?php

namespace H22\Admin\Municipio;

class DisableACFFields
{
    public function __construct()
    {
        add_action('init', array($this, 'disableFields'), 99); // Should be acf/init but in Municipio the import happens at init
    }

    public function disableFields()
    {
        acf_remove_local_field('field_5a9945a41d637'); // custom_color_scheme
        acf_remove_local_field('field_56a0a7e36365b'); // color_scheme
        acf_remove_local_field('field_5a9946401d638'); // color_scheme

        acf_remove_local_field('field_58737dd1dc762'); // header_sticky
        acf_remove_local_field('field_58737dd1dc763'); // header_transparent
        acf_remove_local_field('field_58737dd1dc76345'); // header_centered

        acf_remove_local_field('field_56f25bd99dc5a'); // header_tagline_enable
        acf_remove_local_field('field_56f25bf79dc5b'); // header_tagline_type
        acf_remove_local_field('field_56f25c3c9dc5c'); // header_tagline_text

        acf_remove_local_field('field_56cacece474bf'); // no name
        acf_remove_local_field('field_56cacd3332c2a'); // show_date_published
        acf_remove_local_field('field_56cacde7afe46'); // show_date_updated

        acf_remove_local_field('field_56a227e7a7b31'); // use_google_search
        acf_remove_local_field('field_569fa7fffa53e'); // google_search_api_key
        acf_remove_local_field('field_569fa827fa53f'); // google_search_api_secret

        acf_remove_local_field('field_5a61b85c6e7b8'); // use_algolia_search
        acf_remove_local_field('field_5b3c6dc1c3210'); // algolia_display_post_types
        acf_remove_local_field('field_5c111b35a3803'); // search_didnt_match_query_message

        acf_remove_local_field('field_56a72f9b645b7'); // search_display
        acf_remove_local_field('field_56d3fa48a53d6'); // search_label_text
        acf_remove_local_field('field_56d3fa67a53d7'); // search_placeholder_text
        acf_remove_local_field('field_56d3fa82a53d8'); // search_button_text
        acf_remove_local_field('field_5c0fb3bb76405'); // empty_search_result_message

        acf_remove_local_field('field_586df85ba787d'); // search_result_display_options
        acf_remove_local_field('field_5885fd51fe1e4'); // search_result_layout
        acf_remove_local_field('field_5885fd76fe1e5'); // search_result_grid_columns

        acf_remove_local_field('field_56b347f3ffb6c'); // avabile_dynamic_post_types
        acf_remove_local_field('field_56c5e243a1c79'); // avabile_dynamic_taxonomies
    }
}
