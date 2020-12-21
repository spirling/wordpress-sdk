<?php


namespace Spirling\WordPressSDK\Plugin\Controller;


abstract class RestControllerAbstract
{

    use ControllerTrait;

    const NAMESPACE = 'rest-api-base';

    public function __construct()
    {
        if (did_action('rest_api_init') || doing_action('rest_api_init')) {
            $this->registerEndpoints();
        } else {
            add_action('rest_api_init', [$this, 'registerEndpoints']);
        }
        $this->addActions();
        $this->addFilters();
    }

    abstract protected function registerEndpoints();

    /**
     * @todo Override this method to return your API namespace
     *
     * @return string
     */
    protected function getNamespace()
    {
        /**
         * @override
         */
        return self::NAMESPACE;
    }

    protected function registerRoute($path, $callback, $methods = ['GET'], $override = false, $permissionCallback = '__return_true', $args = [])
    {
        $args = array_merge($args, [
            'methods' => $methods,
            'callback' => $callback,
            'permission_callback' => $permissionCallback,
        ]);
        return register_rest_route($this->getNamespace(), $path, $args, $override);
    }


}