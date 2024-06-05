<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('clean_special_characters')) {
    function clean_special_characters($input)
    {
        // Convert to UTF-8 encoding
        $cleaned_input = mb_convert_encoding($input, 'UTF-8', mb_detect_encoding($input, 'UTF-8, ISO-8859-1', true));

        // Remove non-printable characters
        $cleaned_input = preg_replace('/[[:^print:]]/', '', $cleaned_input);

        return $cleaned_input;
    }
}
