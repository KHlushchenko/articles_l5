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
     * @var array
     */
    private $modeler;

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

        foreach ($this->modeler as $modeler) {
            $modeler->handle();
        }
    }

}
