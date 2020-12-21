<?php

namespace Spirling\WordPressSDK\Plugin;

interface PluginInterface
{

    /**
     * Run plugin
     */
    public function init();

    /**
     * Calls on plugin activation hook
     */
    public function activate();

    /**
     * Calls on plugin deactivation hook
     */
    public function deactivate();

    /**
     * Calls when plugin is uninstalling
     */
    public static function uninstall();

}
