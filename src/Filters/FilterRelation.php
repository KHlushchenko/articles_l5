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
     * FilterRelation constructor. Accepts model and additional params: relationName and relationSelected
     * @param FilterableArticleInterface $model
     * @param array ...$additionalParams
     */
    public function __construct(FilterableArticleInterface $model, ...$additionalParams)
    {
        parent::__construct($model);

        list($this->relationName, $this->relationSelected) = $additionalParams;
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

    /**
     * Handles list of options for filter
     * @return string
     */
    protected function handleOptions()
    {
        $collection = collect();

        $articles = Cache::tags($this->model->getTable())->rememberForever($this->model->getTable() . "_active_articles_with_".$this->relationName, function () {
            $articles = $this->getModelArticles();
            $articles->load($this->relationName);
            return $articles;
        });

        foreach ($articles as $article) {
            $collection->push($article->{$this->relationName});
        }

        return $collection->unique();
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

}
