<?php namespace Vis\Articles\Filters;

final class FilterSorter extends AbstractFilter
{
    /** Handles list of options for filter
     * @return array
     */
    protected function handleOptions()
    {
        return $this->model->getSortOptions();
    }

    /** Handles selected option for filter
     * @return string
     */
    protected function handleSelected()
    {
        return $this->getFromArray('sort', $this->getOptions()) ?: $this->model->getSortOrder();
    }

}
