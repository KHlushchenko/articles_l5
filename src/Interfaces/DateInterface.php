<?php namespace Vis\Articles\Interfaces;

interface DateInterface
{
    /**
     * Return year from given date field name
     * @param string $field
     * @return string
     */
    public function getYear(string $field = 'created_at'): string;

    /**
     * Return month from given date field name
     * @param string $field
     * @return string
     */
    public function getMonth(string $field = 'created_at'): string;

    /**
     * Return month name from given date field name
     * @param string $field
     * @return string
     */
    public function getNameMonth(string $field = 'created_at'): string;

    /**
     * Return month short name from given date field name
     * @param string $field
     * @return string
     */
    public function getShortNameMonth(string $field = 'created_at'): string;

    /**
     * Return day from given date field name
     * @param string $field
     * @return string
     */
    public function getDay(string $field = 'created_at'): string;

    /**
     * Return hour from given date field name
     * @param string $field
     * @return string
     */
    public function getHour(string $field = 'created_at'): string;

    /**
     * Return minutes from given date field name
     * @param string $field
     * @return string
     */
    public function getMinute(string $field = 'created_at'): string;

    /**
     * Return second from given date field name
     * @param string $field
     * @return string
     */
    public function getSecond(string $field = 'created_at'): string;

    /**
     * Return date, month and year with separator from given date field name
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getDate(string $field = 'created_at', string $dateSeparator = "."): string;

    /**
     * Return date, named month and year with separator from given date field name
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getNamedDate(string $field = 'created_at', string $dateSeparator = " "): string;

    /**
     * Return hour and minutes with separator from given date field name
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTime(string $field = 'created_at', string $timeSeparator = ":"): string;

    /**
     * Return hour, minutes and seconds with separator from given date field name
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTimeFull(string $field = 'created_at', string $timeSeparator = ":"): string;

    /**
     * Return full date (without seconds) from given date field name with date and time separators
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTime(string $field = 'created_at', string $dateSeparator = ".", $timeSeparator = ":"): string;

    /**
     * Return full date (with seconds) from given date field name with date and time separators
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTimeFull(string $field = 'created_at', string $dateSeparator = ".", $timeSeparator = ":"): string;
}

