<?php namespace Vis\Articles\Filters;

final class FilterCount extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return array
     */
    protected function handleOptions()
    {
        return $this->model->getCountOptions();
    }

    /**
     * Handles selected option for filter
     * @return string
     */
    protected function handleSelected()
    {
        return $this->getFromArray('count', $this->getOptions()) ?: $this->model->getPerPage();
    }

}
