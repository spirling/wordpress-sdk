<?php


namespace Spirling\WordPressSDK\Logger;


use DateTimeImmutable;

interface LogRecordInterface
{

    /**
     * Returns log level of the record
     *
     * @return string
     */
    public function getLevel(): string;

    /**
     * Returns record's message
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Returns record's context
     *
     * @return array
     */
    public function getContext(): array;

    /**
     * Returns DateTime of the record
     *
     * @return DateTimeImmutable
     */
    public function getDateTime(): DateTimeImmutable;

    /**
     * Returns debug backtrace
     *
     * @return array
     */
    public function getBacktrace(): array;

    /**
     * Returns instance with the specified level
     *
     * @param string $level
     * @return LogRecordInterface
     */
    public function withLevel(string $level): LogRecordInterface;

    /**
     * Returns instance with the specified message
     *
     * @param string $message
     * @return LogRecordInterface
     */
    public function withMessage(string $message): LogRecordInterface;

    /**
     * Returns instance with the specified context
     *
     * @param array $context
     * @return LogRecordInterface
     */
    public function withContext(array $context): LogRecordInterface;

    /**
     * Returns instance with empty context
     *
     * @return LogRecordInterface
     */
    public function withoutContext(): LogRecordInterface;

    /**
     * Returns instance with specified DateTime
     *
     * @param DateTimeImmutable $dateTime
     * @return LogRecordInterface
     */
    public function withDateTime(DateTimeImmutable $dateTime): LogRecordInterface;



    /**
     * Converts record into array with next shape
     * [
     *    'level' => string,
     *    'message' => string,
     *    'dateTime' => DateTimeImmutable,
     *    'context' => array,
     *    'backtrace' => array,
     * ]
     *
     * @return array
     */
    public function toArray(): array;

}
