<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$domain = $_SERVER['HTTP_HOST'];
if ($domain == "www.hbdq8899.com" || $domain == "hbdq8899.com" || strpos($domain,'hbdq8899') != FALSE){
    header("Location: http://www.tianyiit.cn/app/index.php?i=6&c=entry&m=ewei_shopv2&do=mobile");exit;
}
// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
