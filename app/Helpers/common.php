<?php

if (!function_exists('get_type_auth')) {
    function get_type_auth()
    {
        return get_data_user('users') ? 'user' : 'guest';
    }
}
if (!function_exists('get_full_data_user')) {
    function get_full_data_user($type)
    {
        return Auth::guard($type)->user() ? Auth::guard($type)->user() : null;
    }
}
if (!function_exists('get_data_user')) {
    function get_data_user($type, $field = 'id')
    {
        return Auth::guard($type)->user() ? Auth::guard($type)->user()->$field : 0;
    }
}

if (!function_exists('get_id_by_user')) {
    function get_id_by_user($type)
    {
        return Auth::guard($type)->user() ? Auth::guard($type)->user()->id : '';
    }
}

if (!function_exists('get_name_by_user')) {
    function get_name_by_user($type, $default = '')
    {
        return Auth::guard($type)->user() ? Auth::guard($type)->user()->name : $default;
    }
}

if (!function_exists('get_avatar_by_user')) {
    function get_avatar_by_user($type, $default = '/images/logo/company_default.png')
    {
        return Auth::guard($type)->user()->avatar ?? ($type == 'users' ? Auth::guard($type)->user()->avatar_facebook : $default);
    }
}

if (!function_exists('mb_ucwords')) {
    function mb_ucwords($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    }
}

if (!function_exists('js_json')) {
    function js_json($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}

if (!function_exists('convert_country')) {
    function convert_country($vi)
    {
        return $vi == 'vi' ? 'Tiếng Việt' : 'Tiếng Anh';
    }
}

if (!function_exists('render_title_cv_template')) {
    function render_title_cv_template($title, $vi, $company)
    {
        return 'Mẫu CV ' . $title . ' bằng ' . convert_country($vi) . ' - ' . $company;
    }
}

if (!function_exists('convert_breadcrumb')) {
    function convert_breadcrumb($string)
    {
        $breadcrumb = rtrim($string, ']');
        $breadcrumb = ltrim($breadcrumb, '[');
        $breadcrumb = explode('][', $breadcrumb);

        return $breadcrumb;
    }
}

if (!function_exists('random_cv')) {
    function random_cv()
    {
        $string = 1;
        $string .= date('d');
        $string .= date('H');

        return number_format(intval($string), 0, '', '.');
    }
}

if (!function_exists('get_hash_slug')) {
    function get_hash_slug($link)
    {
        $slugs = explode('-', $link);

        return array_pop($slugs);
    }
}

if (!function_exists('showBlogCategory')) {
    function showBlogCategory($categories, $parent_id = 0)
    {
        $cate_child = [];
        foreach ($categories as $key => $item) {
            if ($item['cat_parent_id'] == $parent_id) {
                $cate_child[] = $item;
                unset($categories[$key]);
            }
        }

        if ($cate_child) {
            if ($parent_id > 0) echo '<ul class="list-child">';
            else echo "<ul>";
            foreach ($cate_child as $key => $item) {
                echo '<li><a href="' . create_url_seo_dynamic($item['cat_slug'], $item['id'], 'c') . '" 
                            title = "' . $item['cat_name'] . '">' . ucfirst($item['cat_name']) . '</a>';
                showBlogCategory($categories, $item['id']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }
}

if (!function_exists('change_table')) {
    function change_table($table, $set = 'utf8mb4', $collate = 'utf8mb4_unicode_ci')
    {
        DB::statement('ALTER TABLE ' . $table . ' CHARACTER SET ' . $set . ' COLLATE ' . $collate);
    }
}

if (!function_exists('change_column')) {
    function change_column($table, $fields = [], $set = 'utf8mb4', $collate = 'utf8mb4_unicode_ci')
    {
        foreach ($fields as $field) {
            $statement = 'ALTER TABLE ' . $table . ' CHANGE `' . $field . '` `'
                . $field . '` TEXT CHARACTER SET '
                . $set . ' COLLATE ' . $collate . ' NULL DEFAULT NULL';
            DB::statement($statement);
        }
    }
}

if (!function_exists('url_main')) {
    function url_main($link = '', $type = '')
    {
        switch ($type) {
            case 'api':
                $prefix = config('url.api');
                break;
            case 'employer':
                $prefix = config('url.employer');
                break;
            case 'company':
                $prefix = config('url.company');
                break;
            case 'main':
                $prefix = config('url.main');
                break;
            case 'wiki':
                $prefix = config('url.wiki');
                break;
            default:
                $prefix = config('url.123job');
        }

        return rtrim($prefix, '/') . '/' . ltrim($link, '/');
    }
}

if (!function_exists('host'))
{
    function host($type = '')
    {
        switch ($type)
        {
            case 'api':
            case 'employer':
            case 'company':
            case 'main':
            case 'wiki':
            case 'mailer':
            case 'analyst':
                $domain = config('url.'.$type);
                break;

            default:
                $domain = config('url.main');
        }
        return $domain;
    }
}

if (!function_exists('get_data_json')) {
    function get_data_json($file, $path = 'public')
    {
        if ($path == 'public') {
            $data = file_get_contents(public_path($file));
        }
        else if ($path == 'database') {
            $data = file_get_contents(database_path($file));
        }
        else if ($path == 'absolute') {
            $data = file_get_contents($file);
        }
        if (!$data) return [];

        return json_decode($data, true);
    }
}

if (!function_exists('get_data_php'))
{
    function get_data_php($path, $key = '')
    {
        $path = str_replace('.', '/', $path);
        $path .= '.php';
        $data = require database_path($path);
        if ($key)
        {
            return $data[$key] ?? null;
        }

        return $data;
    }
}

if (!function_exists('get_link_avatar')) {
    function get_link_avatar($avatar)
    {
        if (!$avatar) return '';
        $configCdn = static_url();

        if (strpos($avatar, 'https://123job.vn') === false
            && strpos($avatar, 'static_url_http()') === false) {
            $avatar = $configCdn . $avatar;
        }
        else if (strpos($avatar, 'https://123job.vn') !== false) {
            $avatar = str_replace('https://123job.vn', $configCdn, $avatar);
        }

        return $avatar;
    }
}

if (!function_exists('get_link')) {
    function get_link($route = '', $link = '', $link_type = '')
    {
        if ($route) {
            return route($route);
        }
        if ($link_type) {
            return url_main($link, $link_type);
        }
        else {
            if ($link) {
                return url_main($link);
            }

            return '';
        }
    }
}

if (!function_exists('convert_link_cdn')) {
    function convert_link_cdn($link)
    {
        if (!$link || !is_string($link)) return $link;

        $linkCdn = static_url();

        return preg_replace('/.+(?=\/uploads)/i', $linkCdn, $link);
    }
}

if (!function_exists('check_load_namespace')) {
    function check_load_namespace(array $namespace)
    {
        //Tính từ 0
        $segments = app('request')->segments();
        if ($segments && count($segments) > 1
            && $segments[1]
            && in_array($segments[1], $namespace) || app()->runningInConsole()) {
            return true;
        }

        return false;
    }
}

if (!function_exists('check_load_api')) {
    function check_load_api(array $namespace)
    {
        $segments = app('request')->segments();

        if ($segments && $segments[0] && in_array($segments[0], $namespace) || app()->runningInConsole()) {
            return true;
        }

        return false;
    }
}

if (!function_exists('get_server_random'))
{
    function get_server_random($server = '')
    {
        $servers = ['server2', 'server3'];
        if ($server) return $server;
        $randIndex = array_rand($servers);

        return $servers[$randIndex];
    }
}

if (!function_exists('param_get'))
{
    function param_get(array $params, string $key, $default = null)
    {
        return $params[$key] ?? $default;
    }
}

if (!function_exists('make_queue_name'))
{
    function make_queue_name(string $name): string
    {
        $env = app()->environment();
        if (!in_array($env, ['production', 'prod']))
        {
            $name = $env . '-' . $name;
        }
        return $name;
    }
}