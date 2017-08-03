<?php namespace Vis\Articles\Filters;

use Vis\Articles\Interfaces\FilterableArticleInterface;
use Illuminate\Support\Collection as Collection;

final class FilterComposite
{
    /**
     * Defines articles model that will be used
     * @var FilterableArticleInterface
     */
    private $model;

    /**
     * Defines collection of added filters
     * @var Collection
     */
    private $filters;

    /**
     * ArticleFilterComposite constructor. Defined as private to prevent initiating of object
     * @param FilterableArticleInterface $model
     */
    public function __construct(FilterableArticleInterface $model)
    {
        $this->model = $model;
        $this->filters = new Collection();
    }

    /**
     * Adds FilterSort to filters collection
     * @return FilterComposite
     */
    public function addSort(): FilterComposite
    {
        $this->filters->put('sort', new FilterSort($this->model));

        return $this;
    }

    /**
     * Adds FilterSort to filters collection
     * @return FilterComposite
     */
    public function addCount(): FilterComposite
    {
        $this->filters->put('count', new FilterCount($this->model));

        return $this;
    }

    /**
     * Adds FilterRelation to filters collection
     * @param $relationName
     * @param $relationSelected
     * @return FilterComposite
     */
    public function addRelation($relationName, $relationSelected): FilterComposite
    {
        $this->filters->put('relation-' . $relationName, new FilterRelation($this->model, $relationName, $relationSelected));

        return $this;
    }

    /**
     * Adds FilterDateMonth to filters collection
     * @return FilterComposite
     */
    public function addDateDay(): FilterComposite
    {
        $this->filters->put('dateDay', new FilterDateDay($this->model));

        return $this;
    }

    /**
     * Adds FilterDateMonth to filters collection
     * @return FilterComposite
     */
    public function addDateMonth(): FilterComposite
    {
        $this->filters->put('dateMonth', new FilterDateMonth($this->model));

        return $this;
    }

    /**
     * Adds FilterDateYear to filters collection
     * @return FilterComposite
     */
    public function addDateYear(): FilterComposite
    {
        $this->filters->put('dateYear', new FilterDateYear($this->model));

        return $this;
    }

    /**
     * Adds FilterDateStrict to filters collection
     * @return FilterComposite
     */
    public function addDateStrict(): FilterComposite
    {
        $this->filters->put('dateStrict', new FilterDateStrict($this->model));

        return $this;
    }

    /**
     * Adds FilterDateRange to filters collection
     * @return FilterComposite
     */
    public function addDateRange(): FilterComposite
    {
        $this->filters->put('dateRange', new FilterDateRange($this->model));

        return $this;
    }

    //fixme geters can throw exception if filter not set
    /**
     * Returns FilterSort from filters collection
     * @return FilterSort
     */
    public function getSort(): FilterSort
    {
        return $this->filters->get('sort');
    }

    /**
     * Returns FilterCount from filters collection
     * @return FilterCount
     */
    public function getCount(): FilterCount
    {
        return $this->filters->get('count');
    }

    /**
     * Returns FilterRelation by it's name from filters collection
     * @param string $relationName
     * @return FilterRelation
     */
    public function getRelation(string $relationName): FilterRelation
    {
        return $this->filters->get('relation-' . $relationName);
    }

    /**
     * Returns FilterDateDay from filters collection
     * @return FilterDateDay
     */
    public function getDateDay(): FilterDateDay
    {
        return $this->filters->get('dateDay');
    }

    /**
     * Returns FilterDateMonth from filters collection
     * @return FilterDateMonth
     */
    public function getDateMonth(): FilterDateMonth
    {
        return $this->filters->get('dateMonth');
    }

    /**
     * Returns FilterDateYear from filters collection
     * @return FilterDateYear
     */
    public function getDateYear(): FilterDateYear
    {
        return $this->filters->get('dateYear');
    }

    /**
     * Returns FilterDateStrict from filters collection
     * @return FilterDateStrict
     */
    public function getDateStrict(): FilterDateStrict
    {
        return $this->filters->get('dateStrict');
    }

    /**
     * Returns FilterDateRange from filters collection
     * @return FilterDateRange
     */
    public function getDateRange(): FilterDateRange
    {
        return $this->filters->get('dateRange');
    }

    /**
     * Handles all filters in filter collection
     */
    public function handle()
    {
        foreach ($this->filters as $filter) {
            $filter->handle();
        }
    }

}
