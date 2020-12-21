<?php


namespace Spirling\WordPressSDK\Logger;


class FileLogger extends \Psr\Log\AbstractLogger
{

    protected $directory;

    public function __construct($directory = null)
    {
        if (is_null($directory)) {
            $directory = wp_get_upload_dir()['path'] . DIRECTORY_SEPARATOR . 'log';
        }
        $this->directory = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}