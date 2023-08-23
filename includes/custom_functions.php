<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// HTML minifier
function scb_html_minifier($html) {
    $search = array(
        '/[^\S ]+\</s', // Remove whitespaces before tags
        '/\>[^\S ]+/s', // Remove whitespaces after tags
        '/(\s)+/s',     // Remove multiple whitespace sequences
    );
    $replace = array('<', '>', '\\1');
    return preg_replace($search, $replace, $html);
}