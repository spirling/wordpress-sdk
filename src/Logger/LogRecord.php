<?php


namespace Spirling\WordPressSDK\Logger;


use DateTimeImmutable;
use Psr\Log\LogLevel;

class LogRecord implements LogRecordInterface
{

    protected $level;

    protected $message;

    protected $dateTime;

    protected $context;

    protected $backtrace;

    public static function fromArray(array $recordArr): LogRecord
    {
        $level = array_key_exists('level', $recordArr) ? $recordArr['level'] : LogLevel::DEBUG;
        $message = array_key_exists('message', $recordArr) ? $recordArr['message'] : '';
        $context = array_key_exists('context', $recordArr) ? $recordArr['context'] : [];
        $dateTime = array_key_exists('dateTime', $recordArr) ? $recordArr['dateTime'] : new DateTimeImmutable();
        $backtrace = array_key_exists('backtrace', $recordArr) ? $recordArr['backtrace'] : [];
        return new self($level, $message, $dateTime, $context, $backtrace);
    }

    public function __construct(
        string $level,
        string $message,
        DateTimeImmutable $dateTime,
        array $context,
        array $backtrace
    )
    {
        $this->level = $level;
        $this->message = $message;
        $this->dateTime = $dateTime;
        $this->context = $context;
        $this->backtrace = $backtrace;
    }

    /**
     * @inheritDoc
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @inheritDoc
     */
    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * @inheritDoc
     */
    public function getBacktrace(): array
    {
        return $this->backtrace;
    }

    /**
     * @inheritDoc
     */
    public function withLevel(string $level): LogRecordInterface
    {
        if ($level === $this->level) {
            return $this;
        }
        $record = clone $this;
        $record->level = $level;
        return $record;
    }

    /**
     * @inheritDoc
     */
    public function withMessage(string $message): LogRecordInterface
    {
        if ($message === $this->message) {
            return $this;
        }
        $record = clone $this;
        $record->message = $message;
        return $record;
    }

    /**
     * @inheritDoc
     */
    public function withContext(array $context): LogRecordInterface
    {
        if ($context === $this->context) {
            return $this;
        }
        $record = clone $this;
        $record->context = $context;
        return $record;
    }

    /**
     * @inheritDoc
     */
    public function withoutContext(): LogRecordInterface
    {
        if (empty($this->context)) {
            return $this;
        }
        $record = clone $this;
        $record->context = [];
        return $record;
    }

    /**
     * @inheritDoc
     */
    public function withDateTime(DateTimeImmutable $dateTime): LogRecordInterface
    {
        if ($dateTime === $this->dateTime) {
            return $this;
        }
        $record = clone $this;
        $record->dateTime = $dateTime;
        return $record;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'level' => $this->level,
            'message' => $this->message,
            'dateTime' => $this->dateTime,
            'context' => $this->context,
            'backtrace' => $this->backtrace,
        ];
    }
}