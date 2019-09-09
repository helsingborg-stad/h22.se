<?php

namespace H22\Plugins\Woocommerce;

class Email
{
    public function __construct()
    {

        add_filter('theme/h22/woocommerce/email/customer-complete-order/firstName', array($this, 'replaceFirstNameForAttendees'), 10, 3);
        add_filter('theme/h22/woocommerce/email/customer-complete-order/additionalContent', array($this, 'replaceEmailContentForAttendees'), 10, 3);
        add_action('woocommerce_order_status_completed', array($this, 'sendCustomAttendeeMails'), 10, 1);
    }

    public function sendCustomAttendeeMails($orderId)
    {
        $attendees = array_filter(FooEvents::getAttendees($orderId), function ($attendee) {
            return isset($attendee['WooCommerceEventsPurchaserEmail'])
                && isset($attendee['WooCommerceEventsAttendeeEmail'])
                && $attendee['WooCommerceEventsPurchaserEmail'] !== $attendee['WooCommerceEventsAttendeeEmail'];
        });

        if (empty($attendees) || !is_a($order = wc_get_order($orderId), 'WC_Order')) {
            return;
        }

        foreach ($attendees as $attendee) {
            $orderCompleteMail = \WC_Emails::instance()->emails['WC_Email_Customer_Completed_Order'];

            $orderCompleteMail->setup_locale();
            $orderCompleteMail->object = $order;
            $orderCompleteMail->recipient = $attendee['WooCommerceEventsAttendeeEmail'];
            // $orderCompleteMail->placeholders['{order_date}'] = wc_format_datetime($orderCompleteMail->object->get_date_created());
            // $orderCompleteMail->placeholders['{order_number}'] = $orderCompleteMail->object->get_order_number();

            wp_mail($attendee['WooCommerceEventsAttendeeEmail'], $orderCompleteMail->get_subject(), self::withHtmlWrapper($orderCompleteMail->get_content(), $orderCompleteMail->get_subject()), $orderCompleteMail->get_headers(), $orderCompleteMail->get_attachments());

            $orderCompleteMail->restore_locale();
        }
    }

    public static function withHtmlWrapper($content, $title)
    {
        $email = preg_replace('/<\/head>/m', '<style>' . wc_get_template_html('emails/email-styles.php') . '</style></head>', $content);
        $email = str_replace('{site_title}', 'H22', $email);
        return $email;
    }

    public function replaceFirstNameForAttendees($firstName, $order, $email)
    {
        $orderId = $order->get_data()['id'];
        $recipient = $email->recipient;

        if ($attendee = FooEvents::getAttendeeByMail($orderId, $recipient)) {
            $firstName = $attendee['WooCommerceEventsAttendeeName'];
        }

        return $firstName;
    }

    public function replaceEmailContentForAttendees($content, $order, $email)
    {
        $orderId = $order->get_data()['id'];
        $recipient = $email->recipient;
        $content = !empty(self::getAttendeeEmailContent($orderId, $recipient)) ? self::getAttendeeEmailContent($orderId, $recipient) : $content;

        return $content;
    }

    public static function getAttendeeEmailContent($orderId, $attendeeMail)
    {
        if (!$attendee = FooEvents::getAttendeeByMail($orderId, $attendeeMail)) {
            return '';
        }

        $customAttendeeFields = $attendee['WooCommerceEventsCustomAttendeeFields'];

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

        return implode('<br>', $content);
    }
}
