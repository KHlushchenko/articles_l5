<?php namespace Vis\Articles\Filters;

final class FilterDateYear extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return mixed
     */
    //fixme refactor this?
    protected function handleOptions(): array
    {
        $years = [];

        //fixme optimize this, add caching
        $articles = $this->model->active()->get();

        $yearsAll = $articles->pluck($this->model->getDateField());

        foreach ($yearsAll as $year) {
            $value = $year->format('Y');
            $years[$value] = ['name' => $value, 'description' => $value, 'value' => $value];
        }

        return array_values($years);
    }

    /**
     * Handles selected option for filter
     * @return int
     */
    protected function handleSelected(): int
    {
        return (int)$this->getFromArray('year', $this->getOptions());
    }

}
