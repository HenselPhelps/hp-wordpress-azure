<?php


if (!function_exists("one_page_express_log2")) {
    function one_page_express_log2($msg) {
        $time = date(DATE_RFC2822);
        //file_put_contents(ABSPATH."/log-mods.txt", $time . "::". $msg  . "\r\n", FILE_APPEND);
    }   
}

if (function_exists('pll_current_language') || class_exists('SitePress')) {
    one_page_express_pro_require("/inc/multilanguage/multilanguage-mods.php");
    one_page_express_pro_require("/inc/multilanguage/multilanguage-options.php");
}

// load support for polylang
if (function_exists('pll_current_language')) {
	one_page_express_pro_require("/inc/multilanguage/polylang-options.php");
}

// load support for WPML
if (class_exists('SitePress')) {
    one_page_express_pro_require("/inc/multilanguage/wpml-options.php");
}
