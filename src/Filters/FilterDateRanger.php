<?php namespace Vis\Articles\Filters;

use Carbon\Carbon;

final class FilterDateRanger extends AbstractFilter
{
    /** Defines selected dateFrom filter
     * @var Carbon
     */
    private $dateFromSelected;

    /** Defines selected dateTo filter
     * @var Carbon
     */
    private $dateToSelected;

    /** Defines  minimal possible select date for model
     * @var Carbon
     */
    private $dateFromOption;

    /** Returns dateFrom property
     * @return Carbon
     */
    public function getDateFromSelected(): Carbon
    {
        return $this->dateFrom;
    }

    /** Returns dateTo property
     * @return Carbon
     */
    public function getDateToSelected(): Carbon
    {
        return $this->dateTo;
    }

    /** Handles dateFrom property
     * @return string
     */
    private function handleDateFromSelected()
    {
        if ($dateFrom = $this->getFromInput('date-from')) {
            return Carbon::parse($dateFrom);
        }

        return Carbon::minValue();
    }

    /** Handles dateTo property
     * @return string
     */
    private function handleDateToSelected()
    {
        if ($dateTo = $this->getFromInput('date-to')) {
            return Carbon::parse($dateTo);
        }

        return Carbon::maxValue();
    }

    /** Swaps dates if dateFrom is bigger than dateTo
     */
    private function checkDatesOrder()
    {
        if ($this->getDateFromSelected() > $this->getDateToSelected()) {
            $tmp = $this->dateFrom;
            $this->dateFromSelected = $this->dateTo;
            $this->dateToSelected = $tmp;
        }
    }

    /** Handles filters
     */
    public function handle()
    {
        $this->dateFromSelected = $this->handleDateFromSelected();
        $this->dateToSelected = $this->handleDateToSelected();

        $this->checkDatesOrder();
    }
}
