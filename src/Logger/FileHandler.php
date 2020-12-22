<?php

namespace Spirling\WordPressSDK\Logger;

use InvalidArgumentException;

class FileHandler implements LogHandlerInterface
{

    const DATE_TIME_FORMAT = '[Y/m/d h:i:s.u]';

    protected $levels;

    protected $path;

    protected $day;

    public function __construct(array $levels, $path)
    {
        if (is_dir($path)) {
            $this->levels = $levels;
            $this->path = trim($path, '/\\') . DIRECTORY_SEPARATOR;
            $this->day = date('Ymd');
        } else {
            throw new InvalidArgumentException(sprintf('Unresolved directory path "%s"', $path));
        }
    }

    /**
     * @inheritDoc
     */
    public function handle(LogRecordInterface $record): bool
    {
        $context = $record->getContext();
        if (array_key_exists('handle', $context)) {
            $handle = strtolower($context['handle']);
        } else {
            $handle = 'main';
        }
        $file = $this->path . $handle . '-' . $this->day . '.log';
        $row = $this->buildRow($record);
        return (bool) file_put_contents($file, $row, FILE_APPEND | LOCK_EX);
    }

    /**
     * @inheritDoc
     */
    public function isHandlingLevel(string $level): bool
    {
        return in_array($level, $this->levels);
    }

    protected function buildRow(LogRecordInterface $record): string
    {
        $row = $record->getDateTime()->format(self::DATE_TIME_FORMAT) . ' ';
        $row .= strtoupper($record->getLevel()) . ' ';
        $row .= $record->getMessage() . ' ';
        $backtrace = $record->getBacktrace();
        if (!empty($backtrace)) {
            $lastTrace = array_shift($backtrace);
            if (array_key_exists('line', $lastTrace) && array_key_exists('file', $lastTrace)) {
                $row .= $lastTrace['line'] . ':' . $lastTrace['file'] . ' ';
            }
        }
        return $row;
    }

}
