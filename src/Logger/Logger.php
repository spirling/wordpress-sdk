<?php

namespace Spirling\WordPressSDK\Logger;

use DateTimeImmutable;
use DateTimeZone;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class Logger extends AbstractLogger
{

    /**
     * @var array
     */
    protected $levelLabels;

    /**
     * @var LogHandlerInterface[]
     */
    protected $handlers = [];

    /**
     * @var DateTimeZone
     */
    protected $timezone;


    public function __construct( array $handlers = [])
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    public function addHandler(LogHandlerInterface $handler)
    {
        if (!in_array($handler, $this->handlers)) {
            $this->handlers[] = $handler;
        }
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        $record = null;
        foreach ($this->handlers as $handler) {
            if ($handler->isHandlingLevel($level)) {
                if (!isset($record)) {
                    $recordArr = [
                        'level' => (string) $level,
                        'message' => (string) $message,
                    ];
                    $recordArr['dateTime'] = array_key_exists('dateTime', $context) && ($context['dateTime'] instanceof DateTimeImmutable)
                        ? $context['dateTime']
                        : $this->getCurrentDateTime();
                    $recordArr['backtrace'] = array_key_exists('backtrace', $context)
                        ? $context['backtrace']
                        : $this->getBacktrace();
                    unset($context['dateTime']);
                    unset($context['backtrace']);
                    $record = LogRecord::fromArray($recordArr);
                }

                $handler->handle($record);
            }

        }
    }

    public function getLevelLabels()
    {
        if (!isset($this->levelLabels)) {
            $this->levelLabels = [
                LogLevel::ALERT => __('Alert')
            ];
        }
        return $this->levelLabels;
    }

    public function getLevelLabel($logLevel)
    {
        return $this->getLevelLabels()[$logLevel] ?? $logLevel;
    }

    protected function getCurrentDateTime()
    {
        return new DateTimeImmutable('now', $this->getCurrentTimezone());
    }

    protected function getCurrentTimezone()
    {
        if (!isset($this->timezone)) {
            $this->timezone = new DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }
        return $this->timezone;
    }

    protected function getBacktrace($backtrace = null)
    {
        if (is_null($backtrace)) {
            $backtrace = debug_backtrace();
        } elseif (empty($backtrace)) {
            return $backtrace;
        }
        $temp = array_shift($backtrace);
        if ($temp['object'] === $this) {
            return $this->getBacktrace($backtrace);
        } else {
            array_unshift($backtrace, $temp);
            return array_values($backtrace);
        }
    }

}
