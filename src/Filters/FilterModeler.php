<?php namespace Vis\Articles\Filters;

use Vis\Articles\Models\AbstractArticle;

//fixme find a better name
final class FilterModeler extends AbstractFilter
{
    /** Defines a collection of related filter models
     * @var Illuminate\Support\Collection
     */
    private $modelOptions;

    /** Defines selected model filter
     * @var object
     */
    private $modelSelected;

    /** Defines name of related filter model
     * @var string
     */
    private $modelName;

    /** Defines name of related filter model
     * @var string
     */
    private $modelPage;

    public function __construct(AbstractArticle $model, ...$additionalParams)
    {
        parent::__construct($model, $additionalParams);

        //fixme this array access?
        $this->modelName = $additionalParams[0];
        $this->modelPage = $additionalParams[1];
    }

    /** Returns filterOptions from model class
     * @return mixed
     */
    public function getModelOptions()
    {
        return $this->modelOptions;
    }

    /** Returns modelSelected property
     * @return mixed
     */
    public function getModelSelected()
    {
        return $this->modelSelected;
    }

    /** Returns noFilterUrl
     * @return mixed
     */
    public function getNoFilterUrl()
    {
        if($this->getModelSelected()){
            return str_replace("/" . $this->getModelSelected()->getSlug(), "", $this->getModelSelected()->getUrl());
        }

        return url()->current();
    }

    /** Handles modelOptions filter
     * @return mixed
     */
    private function handleModelOptions()
    {
        //fixme optimzie this, add caching
        $collection = collect();
        $articles = $this->model::has($this->modelName)->with($this->modelName)->get();

        foreach ($articles as $article) {
            $collection->push($article->filterModel);
        }

        //fixme should be uniqueStrict for Laravel 5.4+
        $modelOptions = $collection->unique();

        return $modelOptions;
    }

    /** Handles modelSelected filter
     * @return mixed
     */
    private function handleModelSelected()
    {
        $modelSelected = $this->getModelOptions()->first(function ($key, $value) {
            return $value->id === $this->modelPage->id;
        });

        return $modelSelected;
    }

    /** Handles filters
     */
    public function handle()
    {
        $this->modelOptions  = $this->handleModelOptions();
        $this->modelSelected = $this->handleModelSelected();
    }

}
