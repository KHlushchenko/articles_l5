<?php namespace Vis\Articles\Controllers;

use Vis\Articles\Models\AbstractFilterableArticle;
use Vis\Articles\Handlers\ArticleFilterHandler;
use Vis\Builder\TreeController;

abstract class AbstractFilterableArticleController extends TreeController
{
    /** Property that defines articles model
     * @var
     */
    protected $model = "";

    /** Initiates instance of model
     * AbstractArticleController constructor.
     */
    public function __construct()
    {
        $this->setModel(new $this->model);
    }

    /** Sets instance of AbstractFilterableArticle as usable Model
     * @param AbstractFilterableArticle $model
     */
    private function setModel(AbstractFilterableArticle $model)
    {
        $this->model = $model;
    }

    //todo merge showCatalog and showSubCatalog methods
    /** Returns catalog of articles with filters
     * @return mixed
     */
    public function showCatalog()
    {
        $page = $this->node;

        $filters = ArticleFilterHandler::handleFilters($this->model);

        $noFilterUrl = $page->getUrl();

        $articles = $this->model->active()->with('filterModel')->customOrder($filters->getSortSelected())->paginate($filters->getCountSelected());

        if ($articles->count()) {
            $articles->load($this->model->getRelationsInCatalog());
        }

        return view("pages." . $this->model->getViewFolder() . ".catalog", compact('page', 'articles', 'filters', 'noFilterUrl'));
    }

    /** Returns catalog of articles with filters
     * @return mixed
     */
    public function showSubCatalog()
    {
        $page = $this->node;

        $filters = ArticleFilterHandler::handleFilters($this->model);

        $noFilterUrl = $page->parent->getUrl();

        $articles = $this->model->active()->with('filterModel')->filterByModel($page)->customOrder($filters->getSortSelected())->paginate($filters->getCountSelected());

        if ($articles->count()) {
            $articles->load($this->model->getRelationsInCatalog());
        }
        return view("pages." . $this->model->getViewFolder() . ".catalog", compact('page', 'articles', 'filters', 'noFilterUrl'));
    }

    /** Returns single article
     * @param $catalog string
     * @param $slug string
     * @param $id int
     * @return mixed
     */
    public function showArticle($catalog, $slug, $id)
    {
        $page = $this->model->where('id', $id)->active()->with('filterModel')->first();

        if (!$page) {
            abort(404);
        }

        if ($page->filterModel->getSlug() != $catalog || $page->getSlug() != $slug) {
            return redirect($page->getUrl(), 302);
        }

        $page->load($this->model->getRelationsInArticle());

        return view("pages." . $this->model->getViewFolder() . ".article", compact('page'));
    } // end showSingle

}
