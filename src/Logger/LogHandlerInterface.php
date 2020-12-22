<?php

namespace Spirling\WordPressSDK\Logger;

interface LogHandlerInterface
{

    /**
     * Handle log record
     *
     * @param LogRecordInterface $record
     * @return bool
     */
    public function handle(LogRecordInterface $record): bool;

    /**
     * Check if current handler can handle specified log level
     *
     * @param string $level
     * @return bool
     */
    public function isHandlingLevel(string $level): bool;

}