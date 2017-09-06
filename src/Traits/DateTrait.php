<?php
namespace Vis\Articles\Traits;

use \Carbon\Carbon;

trait DateTrait
{
    /** Object field that will be parsed by Carbon
     * @var
     */
    private $carbonField;

    /** Carbon parsed date
     * @var
     */
    private $carbonDate;

    /** Carbon parser
     * @param string $field
     * @return Carbon
     */
    public function parseCarbon(string $field = 'created_at'): Carbon
    {
        if ($this->carbonField != $field) {
            $this->carbonField = $field;
            $this->carbonDate = Carbon::parse($this->carbonField);
        }

        return $this->carbonDate;
    }

    /**
     * Return year from given date field name
     * @param string $field
     * @return string
     */
    public function getYear(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->format("Y");
    }

    /**
     * Return month from given date field name
     * @param string $field
     * @return string
     */
    public function getMonth(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->format("m");
    }

    /**
     * Return month name from given date field name
     * @param string $field
     * @return string
     */
    public function getNameMonth(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->formatLocalized('%B');
    }

    /**
     * Return month short name from given date field name
     * @param string $field
     * @return string
     */
    public function getShortNameMonth(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->formatLocalized('%b');
    }

    /**
     * Return day from given date field name
     * @param string $field
     * @return string
     */
    public function getDay(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->format("d");
    }

    /**
     * Return day from given date field name
     * @param string $field
     * @return string
     */
    public function getDayName(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->formatLocalized('%A');
    }

    /**
     * Return day from given date field name
     * @param string $field
     * @return string
     */
    public function getDayNameShort(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->formatLocalized('%a');
    }

    /**
     * Return hour from given date field name
     * @param string $field
     * @return string
     */
    public function getHour(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->format("h");
    }

    /**
     * Return minutes from given date field name
     * @param string $field
     * @return string
     */
    public function getMinute(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->format("i");
    }

    /**
     * Return second from given date field name
     * @param string $field
     * @return string
     */
    public function getSecond(string $field = 'created_at'): string
    {
        return $this->parseCarbon($this->$field)->format("s");
    }

    /**
     * Return date, month and year with separator from given date field name
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getDate(string $field = 'created_at', string $dateSeparator = "."): string
    {
        return $this->getDay($field) . $dateSeparator . $this->getMonth($field) . $dateSeparator . $this->getYear($field);
    }

    /**
     * Return date, named month and year with separator from given date field name
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getNamedDate(string $field = 'created_at', string $dateSeparator = " "): string
    {
        return $this->getDay($field) . $dateSeparator . $this->getNameMonth($field) . $dateSeparator . $this->getYear($field);
    }

    /**
     * Return hour and minutes with separator from given date field name
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTime(string $field = 'created_at', string $timeSeparator = ":"): string
    {
        return $this->getHour($field) . $timeSeparator . $this->getMinute($field);
    }

    /**
     * Return hour, minutes and seconds with separator from given date field name
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTimeFull(string $field = 'created_at', string $timeSeparator = ":"): string
    {
        return $this->getHour($field) . $timeSeparator . $this->getMinute($field) . $timeSeparator . $this->getSecond($field);
    }

    /**
     * Return full date (without seconds) from given date field name with date and time separators
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTime(string $field = 'created_at', string $dateSeparator = ".", $timeSeparator = ":"): string
    {
        return $this->getTime($field, $timeSeparator) . " " . $this->getDate($field, $dateSeparator);
    }

    /**
     * Return full date (with seconds) from given date field name with date and time separators
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTimeFull(string $field = 'created_at', string $dateSeparator = ".", $timeSeparator = ":"): string
    {
        return $this->getTimeFull($field, $timeSeparator) . " " . $this->getDate($field, $dateSeparator);
    }

}
