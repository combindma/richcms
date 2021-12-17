<?php

if (!function_exists('remove_key')) {
    function remove_key($url, $key)
    {
        return preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
    }
}

if (!function_exists('remove_keys')) {
    function remove_keys($url, $keys = array())
    {
        foreach ($keys as $key){
            $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
        }
        return $url;
    }
}

if (!function_exists('update_key')) {
    function update_key($url, $key, $value) {

        $url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
        $url = substr($url, 0, -1);

        if (!str_contains($url, '?')) {
            return ($url .'?'. $key .'='. $value);
        }

        return ($url .'&'. $key .'='. $value);
    }
}
