<?php

namespace H22\Plugins\Woocommerce;

class FooEvents
{
    public function __construct()
    {
        add_filter('wp_mail', array($this, 'addCustomFilterForAttendeeMails'), 20, 1);
        add_filter('H22/Plugins/Woocommerce/FooEvents/attendeeTicketMail', array($this, 'customizeAttendeeMails'), 10, 3);
        add_action('init', array($this, 'registerOptionsPage'));
        add_filter('acf/load_field/key=field_5d6eb5a2a3d77', array($this, 'populateSelectWithAtendeeFields'));
        // add_action('wp', function () {
        //     if (is_admin()) {
        //         return;
        //     }
        //     echo '<pre>';
        //     var_dump(self::findAllCustomAttendeeFields());
        //     echo '</pre>';
        //     die;
        // });
    }

    public static function withHtmlWrapper($content, $title)
    {
        $email = wc_get_template_html('emails/email-header.php', array('email_heading' => $title));
        $email .= '<style>' . wc_get_template_html('emails/email-styles.php') . '</style>';
        $email .= $content;
        $email .= wc_get_template_html('emails/email-footer.php');
        $email = str_replace('{site_title}', 'H22', $email);
        return $email;
    }

    /**
     * Appends a custom filter hook to simplify customization of attendee ticket mail.
     *
     * @param array $args A compacted array of wp_mail() arguments, including the "to" email, subject, message, headers, and attachments values.
     * @return array
     */
    public function addCustomFilterForAttendeeMails($args)
    {
        if (!isset($args['subject'])) {
            return $args;
        }

        // Get order id from mail subject field
        preg_match_all('/\[#(\d*?)\] Ticket/m', $args['subject'], $matches, PREG_SET_ORDER, 0);
        $orderId = isset($matches[0]) && isset($matches[0][1]) ? $matches[0][1] : false;

        if ($orderId && get_post_type($orderId) === 'shop_order') {
            $order = wc_get_order($orderId);
            $eventMeta = $order->get_meta('WooCommerceEventsOrderTickets');

            // Make sure event meta exists
            if (!empty($eventMeta)) {
                // Get correct attendee meta based on email found in "to".
                $attendeeMeta = array_values(array_values(array_filter(
                    $eventMeta,
                    function ($metaItem) use ($args) {
                        return isset($metaItem[1])
                            && isset($metaItem[1]['WooCommerceEventsAttendeeEmail'])
                            && $metaItem[1]['WooCommerceEventsAttendeeEmail'] === $args['to'];
                    }
                ))[0])[0];

                $customAttendeeFields = $attendeeMeta['WooCommerceEventsCustomAttendeeFields'];

                // Manipulate mail here through filter
                $args = apply_filters('H22/Plugins/Woocommerce/FooEvents/attendeeTicketMail', $args, $customAttendeeFields, $attendeeMeta);
            }
        }

        return $args;
    }

    public function customizeAttendeeMails($args, $customAttendeeFields, $attendeeMeta)
    {
        $content = array();
        $contentBlocks = get_field('attendee_mail_content_blocks', 'options');

        if (is_array($contentBlocks) && !empty($contentBlocks)) {
            foreach ($contentBlocks as $block) {
                if (empty($block['content'])) {
                    continue;
                }

                if (!empty($block['rules']) && is_array($block['rules'])) {
                    $bail = false;
                    foreach ($block['rules'] as $rule) {
                        if (
                            !$bail && $rule['condition'] === 'is-equal' && isset($customAttendeeFields[$rule['custom_attendee_field']]) && $customAttendeeFields[$rule['custom_attendee_field']] == $rule['value']
                            || !$bail && $rule['condition'] === 'is-not-equal' && !isset($customAttendeeFields[$rule['custom_attendee_field']])
                            || !$bail && $rule['condition'] === 'is-not-equal' && $customAttendeeFields[$rule['custom_attendee_field']] != $rule['value']
                        ) {
                            // Condition pass
                            continue;
                        }

                        // Condition fail
                        $bail = true;
                    }
                }

                // Skip
                if (isset($bail) && $bail) {
                    continue;
                }

                $content[] = $block['content'];
            }
        }

        // Replace subject
        if (!empty(get_field('attendee_mail_custom_subject', 'options'))) {
            $args['subject'] = get_field('attendee_mail_custom_subject', 'options');
        }

        // Remove attachments
        if (get_field('attendee_mail_remove_attachments', 'options')) {
            $args['attachments'] = array();
        }

        // Replace message
        if (!empty($content)) {
            $args['message'] = self::withHtmlWrapper(implode('<br>', $content), $args['subject']);
        }

        return $args;
    }

    public static function findAllCustomAttendeeFields()
    {
        $checkBoxFields = array();

        $products = get_posts(array('numberposts' => -1, 'post_type' => 'product'));
        if (!is_array($products) || empty($products)) {
            return $checkBoxFields;
        }

        foreach ($products as $product) {
            $i = 1;
            if (!$postMeta = get_post_meta($product->ID, 'fooevents_custom_attendee_fields_options_serialized', true)) {
                continue;
            }

            $options = json_decode($postMeta, true);

            foreach ($options as $option) {
                if (
                    isset($option[$i . '_type'])
                    && isset($option[$i . '_label'])
                ) {
                    $fieldKey = str_replace(' ', '_', $option[$i . '_label']);
                    $fieldKey = strtolower($fieldKey);
                    $fieldKey = 'fooevents_custom_' . $fieldKey;


                    if (!in_array($fieldKey, $checkBoxFields)) {
                        $checkBoxFields[] = $fieldKey;
                    }
                }

                $i++;
            }
        }

        return $checkBoxFields;
    }

    public function populateSelectWithAtendeeFields($field)
    {
        $attendeeFields = self::findAllCustomAttendeeFields();
        $field['choices'] = array_combine($attendeeFields, $attendeeFields);
        return $field;
    }

    public function registerOptionsPage()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title'     => 'Attendee Email',
                'menu_title'    => 'Attendee Email',
                'parent_slug'    => 'woocommerce',
            ));
        }
    }
}
