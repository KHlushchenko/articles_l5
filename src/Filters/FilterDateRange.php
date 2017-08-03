<?php namespace Vis\Articles\Filters;

use Carbon\Carbon;

final class FilterDateRange extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return array
     */
    protected function handleOptions(): array
    {
        //fixme optimize this, add caching
        $articles = $this->model->active()->get();

        return [
            'date-from' => $articles->min($this->model->getDateField()),
            'date-to'   => $articles->max($this->model->getDateField()),
        ];
    }

    /**
     * Handles selected option for filter
     * @return array
     */
    protected function handleSelected():array
    {
        $dateFrom = $this->getFromInput('date-from');
        $dateTo   = $this->getFromInput('date-to');

        $selected = [
            'date-from' => $dateFrom ? Carbon::parse($dateFrom) : $this->getOptions()['date-from'],
            'date-to'   => $dateTo   ? Carbon::parse($dateTo)   : $this->getOptions()['date-to']
        ];

        if ($selected['date-from'] > $selected['date-to']) {
            array_reverse($selected);
        }

        return $selected;
    }

}
