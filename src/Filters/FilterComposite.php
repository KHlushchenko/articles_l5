<?php namespace Vis\Articles\Filters;

use Vis\Articles\Models\AbstractArticle;
use Illuminate\Support\Collection as Collection;

final class FilterComposite
{
    /** Defines articles model that will be used
     * @var AbstractArticle
     */
    private $model;

    /** Defines sorter filter object
     * @var FilterSorter
     */
    private $sorter;

    /** Defines counter filter object
     * @var FilterCounter
     */
    private $counter;

    /** Defines model filter object
     * @var Collection
     */
    private $modeler;

    /** Defines dateRanger filter object
     * @var FilterDateRanger
     */
    private $dateRanger;

    /** Defines dateRanger filter object
     * @var FilterDateStricter
     */
    private $dateStricter;

    /**
     * ArticleFilterComposite constructor. Defined as private to prevent initiating of object
     * @param AbstractArticle $model
     */
    public function __construct(AbstractArticle $model)
    {
        $this->model = $model;
        $this->modeler = new Collection();
    }

    public function addSorter()
    {
        $this->sorter = new FilterSorter($this->model);

        return $this;
    }

    public function addCounter()
    {
        $this->counter = new FilterCounter($this->model);

        return $this;
    }

    public function addModeler($filterName, $page)
    {
        $this->modeler->push(new FilterModeler($this->model, $filterName, $page));

        return $this;
    }

    public function addDateRanger()
    {
        $this->dateRanger = new FilterDateRanger($this->model);

        return $this;
    }

    public function addDateStricter()
    {
        $this->dateStricter = new FilterDateStricter($this->model);

        return $this;
    }

    /**
     * @return FilterSorter
     */
    public function getSorter(): FilterSorter
    {
        return $this->sorter;
    }

    /**
     * @return FilterCounter
     */
    public function getCounter(): FilterCounter
    {
        return $this->counter;
    }

    /**
     * @return FilterDateRanger
     */
    public function getDateRanger(): FilterDateRanger
    {
        return $this->dateRanger;
    }

    /**
     * @return FilterDateStricter
     */
    public function getDateStricter(): FilterDateStricter
    {
        return $this->dateStricter;
    }

    /**
     * @return Collection
     */
    public function getModeler(): Collection
    {
        return $this->modeler;
    }

    //fixme make this single foreach?
    public function handle()
    {
        if ($this->sorter) {
            $this->sorter->handle();
        }
        if ($this->counter) {
            $this->counter->handle();
        }

        if ($this->dateRanger) {
            $this->dateRanger->handle();
        }

        if ($this->dateStricter) {
            $this->dateStricter->handle();
        }

        foreach ($this->modeler as $modeler) {
            $modeler->handle();
        }
    }

}
