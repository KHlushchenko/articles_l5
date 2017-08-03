<?php namespace Vis\Articles\Filters;

final class FilterCount extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return array
     */
    protected function handleOptions(): array
    {
        return $this->model->getCountOptions();
    }

    /**
     * Handles selected option for filter
     * @return string
     */
    protected function handleSelected(): string
    {
        return $this->getFromArray('count', $this->getOptions()) ?: $this->model->getPerPage();
    }

}
