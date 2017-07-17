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

    //todo refactor handleArticles, showCatalog, showSubCatalog
    /** Gets articles and return view
     * @param $page
     * @param $noFilterUrl
     * @return mixed
     */
    private function handleArticles($page, $noFilterUrl)
    {
        $filters = ArticleFilterHandler::handleFilters($this->model);

        $sortOrder = $filters->getSortSelected();
        $perPage   = $filters->getCountSelected();
        $filter    = $page->getUrl() != $noFilterUrl ? $page : null;

        $articles = $this->model->active()->with('filterModel')->filterByModel($filter)->customOrder($sortOrder)->paginate($perPage);

        if ($articles->count()) {
            $articles->load($this->model->getRelationsInCatalog());
        }

        return view("pages." . $this->model->getViewFolder() . ".catalog", compact('page', 'articles', 'filters', 'noFilterUrl'));
    }

    /** Returns catalog of articles with filters
     * @return mixed
     */
    public function showCatalog()
    {
        $page = $this->node;
        $noFilterUrl = $page->getUrl();

        return $this->handleArticles($page, $noFilterUrl);
    }

    /** Returns catalog of articles with filters
     * @param catalog
     * @return mixed
     */
    public function showSubCatalog($catalog = null)
    {
        if (!$this->node) {
            $page = $this->model->filterModel()->where('slug', $catalog)->active()->first();
            if (!$page) {
                abort(404);
            }
            $noFilterUrl = str_replace("/" . $page->getSlug(), "", $page->getUrl());

        } else {
            $page = $this->node;
            $noFilterUrl = $page->parent->getUrl();
        }

        return $this->handleArticles($page, $noFilterUrl);
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

        if ($page->filterModel->getSlug() != $catalog) {
            return redirect($page->getUrl(), 302);
        }

        if ($page->getSlug() != $slug) {
            return redirect($page->getUrl(), 302);
        }

        $page->load($this->model->getRelationsInArticle());

        return view("pages." . $this->model->getViewFolder() . ".article", compact('page'));
    } // end showSingle

}
