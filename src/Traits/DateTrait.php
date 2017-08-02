<?php namespace Vis\Articles\Traits;

//fixme update to FilterDates level
trait DateTrait
{
    /** Return year from given date field name
     * @param string $field
     * @return string
     */
    public function getYear(string $field = 'created_at'): string
    {
        return date("Y", strtotime($this->$field));
    }

    /** Return month from given date field name
     * @param string $field
     * @return string
     */
    public function getMonth(string $field = 'created_at'): string
    {
        return date("m", strtotime($this->$field));
    }

    /** Return month name from given date field name
     * @param string $field
     * @return string
     */
    public function getNameMonth(string $field = 'created_at'): string
    {
        return date("F", strtotime($this->$field));
    }

    /** Return month short name from given date field name
     * @param string $field
     * @return string
     */
    public function getShortNameMonth(string $field = 'created_at'): string
    {
        return date("m", strtotime($this->$field));
    }

    /** Return day from given date field name
     * @param string $field
     * @return string
     */
    public function getDay(string $field = 'created_at'): string
    {
        return date("d", strtotime($this->$field));
    }

    /** Return hour from given date field name
     * @param string $field
     * @return string
     */
    public function getHour(string $field = 'created_at'): string
    {
        return date("H", strtotime($this->$field));
    }

    /** Return minutes from given date field name
     * @param string $field
     * @return string
     */
    public function getMinute(string $field = 'created_at'): string
    {
        return date("i", strtotime($this->$field));
    }

    /** Return second from given date field name
     * @param string $field
     * @return string
     */
    public function getSecond(string $field = 'created_at'): string
    {
        return date("s", strtotime($this->$field));
    }

    /** Return date, month and year with separator from given date field name
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getDate(string $field = 'created_at', string $dateSeparator = "."): string
    {
        return $this->getDay($field) . $dateSeparator . $this->getMonth($field) . $dateSeparator . $this->getYear($field);
    }

    /** Return date, named month and year with separator from given date field name
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getNamedDate(string $field = 'created_at', string $dateSeparator = " "): string
    {
        return $this->getDay($field) . $dateSeparator . $this->getNameMonth($field) . $dateSeparator . $this->getYear($field);
    }

    /** Return hour and minutes with separator from given date field name
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTime(string $field = 'created_at', string $timeSeparator = ":"): string
    {
        return $this->getHour($field) . $timeSeparator . $this->getMinute($field);
    }

    /** Return hour, minutes and seconds with separator from given date field name
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTimeFull(string $field = 'created_at', string $timeSeparator = ":"): string
    {
        return $this->getHour($field) . $timeSeparator . $this->getMinute($field) . $timeSeparator . $this->getSecond($field);
    }

    /** Return full date (without seconds) from given date field name with date and time separators
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTime(string $field = 'created_at', string $dateSeparator = ".", $timeSeparator = ":"): string
    {
        return $this->getTime($field, $dateSeparator) . " " . $this->getDate($field, $timeSeparator);
    }

    /** Return full date (with seconds) from given date field name with date and time separators
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTimeFull(string $field = 'created_at', string $dateSeparator = ".", $timeSeparator = ":"): string
    {
        return $this->getTimeFull($field, $dateSeparator) . " " . $this->getDate($field, $timeSeparator);
    }
}
