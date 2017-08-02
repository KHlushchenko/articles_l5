<?php namespace Vis\Articles\Filters;

use Carbon\Carbon;

final class FilterDateStricter extends AbstractFilter
{
    /** Handles list of options for filter
     * @return mixed
     */
    //fixme refactor this?
    protected function handleOptions()
    {
        $years = [];
        $month = [];

        //fixme optimize this, add caching
        $articles = $this->model->active()->get();

        $yearsAll = $articles->pluck($this->model->getDateField());

        foreach ($yearsAll as $year) {
            $value = $year->format('Y');
            $years[$value] = ['name' => $value, 'description' => $value, 'value' => $value];
        }

        for ($i = 1; $i <= 12; $i++) {
            $month[] = ['name' => $i, 'description' => Carbon::createFromFormat('!m', $i)->formatLocalized('%B'), 'value' => $i];
        }

        return [
            'year'  => array_values($years),
            'month' => $month
        ];
    }

    /** Handles selected option for filter
     * @return string
     */
    protected function handleSelected()
    {
        return [
            'year'  => $this->getFromArray('year', $this->getOptions()['year']) ?: null,
            'month' => $this->getFromArray('month', $this->getOptions()['month']) ?: null,
        ];
    }

}