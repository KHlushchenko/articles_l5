<?php
namespace Vis\Articles\Filters;

use Illuminate\Support\Facades\Cache;

use Vis\Articles\Interfaces\FilterableArticleInterface;

final class FilterRelation extends AbstractFilter
{
    /**
     * Defines name of related filter relation
     * @var string
     */
    private $relationName;

    /**
     * Defines passed selected filter
     * @var string
     */
    private $relationSelected;

    /**
     * Defines if related entries should be loaded as options
     * @var bool
     */
    private $relationLoadAll;

    /**
     * FilterRelation constructor. Accepts model and additional params: relationName and relationSelected
     * @param FilterableArticleInterface $model
     * @param array ...$additionalParams
     */
    public function __construct(FilterableArticleInterface $model, ...$additionalParams)
    {
        parent::__construct($model);

        list($this->relationName, $this->relationSelected) = $additionalParams;

        $this->relationLoadAll = (bool)($additionalParams[2] ?? false);
    }

    /**
     * Gets all possible filters options
     */
    private function getAllOptions()
    {
        $relatedClass = $this->model->{$this->relationName}()->getRelated();

        $options = Cache::tags($relatedClass->getTable())->rememberForever($relatedClass->getTable() . "_active", function () use($relatedClass) {
            return $relatedClass->active()->get();
        });

        return $options;
    }

    /**
     * Gets only filter options that are related to article model
     */
    private function getRelatedOptions()
    {
        $options = collect();

        $articles = Cache::tags($this->model->getTable())->rememberForever($this->model->getTable() . "_active_articles_with_".$this->relationName, function () {
            $articles = $this->getModelArticles();
            $articles->load($this->relationName);
            return $articles;
        });

        foreach ($articles as $article) {
            $options->push($article->{$this->relationName});
        }

        return $options->unique();
    }

    /**
     * Handles list of options for filter
     * @return string
     */
    protected function handleOptions()
    {
        if($this->relationLoadAll){
            return $this->getAllOptions();
        }

        return $this->getRelatedOptions();
    }

    /**
     * Handles selected option for filter
     * @return string
     */
    protected function handleSelected()
    {
        if(!$this->relationSelected){
            return null;
        }

        return $this->getOptions()->first(function ($value, $key) {
            return $value->id === $this->relationSelected->id;
        });
    }

    /**
     * Returns noFilterUrl
     * @return mixed
     */
    public function getNoFilterUrl()
    {
        if ($this->getSelected()) {
            return str_replace("/" . $this->getSelected()->getSlug(), "", $this->getSelected()->getUrl());
        }

        return url()->current();
    }

}
