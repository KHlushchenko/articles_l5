<?php namespace Vis\Articles\Filters;

use Vis\Articles\Models\AbstractArticle;

final class FilterModeler extends AbstractFilter
{
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

    /** Returns noFilterUrl
     * @return mixed
     */
    public function getNoFilterUrl()
    {
        if ($this->getSelected()) {
            return str_replace("/" . $this->getSelected()->getSlug(), "", $this->getSelected()->getUrl());
        }

        return url()->current();
    }

    /** Handles modelOptions property
     * @return mixed
     */
    protected function handleOptions()
    {
        //fixme optimize this, add caching
        $collection = collect();
        $articles = $this->model->active()->has($this->modelName)->with($this->modelName)->get();

        foreach ($articles as $article) {
            $collection->push($article->filterModel);
        }

        //fixme should be uniqueStrict for Laravel 5.4+
        $modelOptions = $collection->unique();

        return $modelOptions;
    }

    /** Handles modelSelected property
     * @return mixed
     */
    protected function handleSelected()
    {
        $modelSelected = $this->getOptions()->first(function ($key, $value) {
            return $value->id === $this->modelPage->id;
        });

        return $modelSelected;
    }

}
