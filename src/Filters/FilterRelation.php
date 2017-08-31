<?php namespace Vis\Articles\Filters;

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
        parent::__construct($model, $additionalParams);

        //fixme this array access?
        $this->relationName = $additionalParams[0];
        $this->relationSelected = $additionalParams[1];
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

        $articles = $this->getModelArticles();
        $articles->load($this->relationName);

        foreach ($articles as $article) {
            $collection->push($article->{$this->relationName});
        }

        return $collection->uniqueStrict();
    }

    /**
     * Handles selected option for filter
     * @return string
     */
    protected function handleSelected()
    {
        //fixme think about passing null ?
        return $this->getOptions()->first(function ($value, $key) {
            return $value->id === $this->relationSelected->id;
        });
    }

}
