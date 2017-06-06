<?php namespace Vis\Articles\Traits;

trait DateTrait
{
    /**
     * @param string $field
     * @return string
     */
    public function getYear($field = 'created_at')
    {
        return date("Y", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getMonth($field = 'created_at')
    {
        return date("m", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getNameMonth($field = 'created_at')
    {
        return date("F", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getShortNameMonth($field = 'created_at')
    {
        return date("m", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getDay($field = 'created_at')
    {
        return date("d", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getHour($field = 'created_at')
    {
        return date("H", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getMinute($field = 'created_at')
    {
        return date("i", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @return string
     */
    public function getSecond($field = 'created_at')
    {
        return date("s", strtotime($this->$field));
    }

    /**
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getDate($field = 'created_at', $dateSeparator = ".")
    {
        return $this->getDay() . $dateSeparator . $this->getMonth() . $dateSeparator . $this->getYear($field);
    }

    /**
     * @param string $field
     * @param string $dateSeparator
     * @return string
     */
    public function getNamedDate($field = 'created_at', $dateSeparator = " ")
    {
        return $this->getDay() . $dateSeparator . $this->getNameMonth() . $dateSeparator . $this->getYear($field);
    }

    /**
     * @param string $field
     * @param string $timeSeparator
     * @return string
     */
    public function getTime($field = 'created_at', $timeSeparator = ":")
    {
        return $this->getHour() . $timeSeparator . $this->getMinute() . $timeSeparator . $this->getSecond($field);
    }

    /**
     * @param string $field
     * @param string $dateSeparator
     * @param string $timeSeparator
     * @return string
     */
    public function getDateTime($field = 'created_at', $dateSeparator = ".", $timeSeparator = ":")
    {
        return $this->getTime($field, $dateSeparator) . " " . $this->getDate($field, $timeSeparator);
    }
}
