<?php

if (!function_exists('include_safe')) {
    /**
     * Function for safety including files in clear context
     *
     * @param string $__file path to file for include
     * @param array $__context array of variables which should be provided for included file
     *
     * @return mixed
     */
    function include_safe($__file, $__context = []) {
        extract($__context);
        return include $__file;
    }
}

if (!function_exists('include_once_safe')) {
    /**
     * Function for safety including once files in clear context
     *
     * @param string $__file path to file for include_once
     * @param array $__context array of variables which should be provided for included file
     *
     * @return mixed
     */
    function include_once_safe($__file, $__context = []) {
        extract($__context);
        return include_once $__file;
    }
}

if (!function_exists('require_safe')) {
    /**
     * Function for safety requiring files in clear context
     *
     * @param string $__file path to file for require
     * @param array $__context array of variables which should be provided for required file
     *
     * @return mixed
     */
    function require_safe($__file, $__context = []) {
        extract($__context);
        return require $__file;
    }
}

if (!function_exists('include_once_safe')) {
    /**
     * Function for safety requiring once files in clear context
     *
     * @param string $__file path to file for require_once
     * @param array $__context array of variables which should be provided for required file
     *
     * @return mixed
     */
    function include_once_safe($__file, $__context = []) {
        extract($__context);
        return require_once $__file;
    }
}
