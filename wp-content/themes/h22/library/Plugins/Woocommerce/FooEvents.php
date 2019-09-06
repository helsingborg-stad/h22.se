<?php

namespace H22\Plugins\Woocommerce;

class FooEvents
{
    public function __construct()
    {
        add_action('init', array($this, 'registerOptionsPage'));
        add_filter('acf/load_field/key=field_5d6eb5a2a3d77', array($this, 'populateSelectWithAtendeeFields'));
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

    public static function getAttendees($orderId)
    {
        $attendees = array();

        if (!empty(get_post_meta($orderId, 'WooCommerceEventsOrderTickets', false))) {
            $attendees = array_values(array_values(array_values(get_post_meta($orderId, 'WooCommerceEventsOrderTickets', false))[0])[0]);
        }

        return $attendees;
    }

    public static function getAttendeeByMail($orderId, $email)
    {
        $attendee = array_filter(self::getAttendees($orderId), function ($attendee) use ($email) {
            return isset($attendee['WooCommerceEventsAttendeeEmail']) && $attendee['WooCommerceEventsAttendeeEmail'] === $email;
        });

        return is_array($attendee) && !empty($attendee) ? array_values($attendee)[0] : false;
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
}
