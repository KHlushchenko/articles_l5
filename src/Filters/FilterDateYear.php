<?php namespace Vis\Articles\Filters;

final class FilterDateYear extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return mixed
     */
    protected function handleOptions(): array
    {
        $years = [];

        $articles = $this->getModelArticles();

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
