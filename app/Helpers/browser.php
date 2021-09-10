<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 11/7/18
 * Time: 2:03 PM
 */
if (!function_exists('access_google_bot')) {
    function access_google_bot()
    {
        $userAgent = @$_SERVER['HTTP_USER_AGENT'];
        $codeGG    = ['googlebot', 'indeed', 'jobstreet', 'coccoc', 'bingbot'];
        return (str_contains(strtolower($userAgent), $codeGG)) ? true : false;
    }
}

if (!function_exists('ip_user_client')) {
    function ip_user_client()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}

if (!function_exists('render_ga')) {
    function render_ga()
    {
        return \App\HelperClass\RenderGoogleAnalyst::instance()->renderGA();
    }
}

if (!function_exists('render_tagmanager')) {
    function render_tagmanager($position)
    {
        return \App\HelperClass\RenderGoogleAnalyst::instance()->renderTagManager($position);
    }
}

if (!function_exists('remove_http'))
{
    function remove_http($url = "")
    {
        $url = trim($url, '/');
        // If scheme not included, prepend it
        if (!preg_match('#^http(s)?://#', $url)) $url = 'http://' . $url;

        $urlParts = parse_url($url);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);
        return $domain . $urlParts['path'];
    }
}

if (!function_exists('detectDevice2'))
{
    function detectDevice2()
    {
        $instance = new Jenssegers\Agent\Agent();

        return $instance;
    }
}

if (!function_exists('get_agent'))
{
    function get_agent()
    {
       return [
           'device'       => detectDevice2()->device(),
           'platform'     => $platform = detectDevice2()->platform(),
           'platform_ver' => detectDevice2()->version($platform),
           'browser'      => $browser = detectDevice2()->browser(),
           'browser_ver'  => detectDevice2()->version($browser)
       ];
    }
}