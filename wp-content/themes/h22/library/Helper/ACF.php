<?php

namespace H22\Helper;

class ACF
{
    public static function getFieldsMulti($fields)
    {
        if (is_array($fields) && !empty($fields)) {
            foreach ($fields as $field) {
                if (!is_array($field) || !isset($field['key']) || !isset($field['id'])) {
                    continue;
                }

                $fieldData = get_field($field['key'], $field['id']);

                if (!empty($fieldData)) {
                    return $fieldData;
                }
            }
        }
        return null;
    }
}
