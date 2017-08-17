<?php namespace Vis\Articles\Filters;

use Vis\Articles\Interfaces\FilterableArticleInterface;

final class FilterDateStrict extends AbstractFilter
{
    /**
     * Defines year filter
     * @var FilterDateYear
     */
    private $yearFilter;

    /**
     * Defines month filter
     * @var FilterDateMonth
     */
    private $monthFilter;

    /**
     * Defines day filter
     * @var FilterDateDay
     */
    private $dayFilter;

    //fixme refactor this?
    /**
     * FilterDateStrict constructor. Sets year, month and day filters
     * @param FilterableArticleInterface $model
     * @param array ...$additionalParams
     */
    public function __construct(FilterableArticleInterface $model, ...$additionalParams)
    {
        parent::__construct($model, ...$additionalParams);

        $this->yearFilter  = new FilterDateYear($this->model);
        $this->monthFilter = new FilterDateMonth($this->model);
        $this->dayFilter   = new FilterDateDay($this->model);
    }

    /**
     * Handles list of options for filter
     * @return array
     */
    protected function handleOptions(): array
    {
        $this->yearFilter->handle();
        $this->monthFilter->handle();
        $this->dayFilter->handle();

        return [
            'year'  => $this->yearFilter->getOptions(),
            'month' => $this->monthFilter->getOptions(),
            'day'   => $this->dayFilter->getOptions()
        ];
    }

    /**
     * Handles selected option for filter
     * @return array
     */
    protected function handleSelected(): array
    {
        return [
            'year'  => $this->yearFilter->getSelected(),
            'month' => $this->monthFilter->getSelected(),
            'day'   => $this->dayFilter->getSelected()
        ];
    }

}
