<?php
namespace agumil\SatuSehatSDK\Helper;

use agumil\SatuSehatSDK\Exception\SSDataTypeException;

class ValidatorHelper
{
    public static function validDateTime($var, bool $is_return = true)
    {
        $epoch = strtotime($var);
        if ($is_return) {
            return $epoch !== false;
        }

        if ($epoch === false) {
            throw new SSDataTypeException('Data type dateTime is unparseable by strtotime. Please provide a valid date, dateTime, or time.');
        }
    }

    public static function in($needle, array $haystack, bool $is_return = false)
    {
        if ($is_return) {
            return in_array($needle, $haystack);
        }

        if (!in_array($needle, $haystack)) {
            $stack_str = implode(',', $haystack);
            throw new SSDataTypeException("Provided value must be one of {$stack_str}");
        }
    }
}
