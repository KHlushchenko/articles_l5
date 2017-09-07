<?php
namespace Vis\Articles\Filters;

use Carbon\Carbon;

final class FilterDateRange extends AbstractFilter
{
    /** Gets valid Carbon object from any input value
     * @param string $field
     * @return Carbon
     */
    private function getValidDate(string $field = 'date-from'): Carbon
    {
        $input = $this->getFromInput($field);

        if ($input && $timeStamp = strtotime($input)) {
            $date = Carbon::createFromTimestamp($timeStamp);
            if ($date > $this->getOptions()['date-from'] && $date < $this->getOptions()['date-to']) {
                return $date;
            }
        }

        return $this->getOptions()[$field];
    }

    /**
     * Handles list of options for filter
     * @return array
     */
    protected function handleOptions(): array
    {
        $articles = $this->getModelArticles();

        return [
            'date-from' => $articles->min($this->model->getDateField()),
            'date-to'   => $articles->max($this->model->getDateField()),
        ];
    }

    /**
     * Handles selected option for filter
     * @return array
     */
    protected function handleSelected(): array
    {
        $dateFrom = $this->getValidDate('date-from');
        $dateTo   = $this->getValidDate('date-to');

        return [
            'date-from' => $dateFrom < $dateTo ? $dateFrom : $dateTo ,
            'date-to'   => $dateFrom < $dateTo ? $dateTo   : $dateFrom,
        ];
    }

}
