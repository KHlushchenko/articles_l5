<?php
namespace Vis\Articles\Controllers;

use Vis\Builder\TreeController;
use Vis\Articles\Interfaces\ArticleInterface;

abstract class AbstractArticleController extends TreeController
{
    /**
     * Property that defines articles model
     * @var ArticleInterface
     */
    protected $model = "";

    /**
     * Initiates instance of model
     * AbstractArticleController constructor.
     */
    public function __construct()
    {
        $this->setModel(new $this->model);
    }

    /**
     * Sets instance of ArticleInterface as usable Model
     * @param ArticleInterface $model
     */
    private function setModel(ArticleInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Returns catalog of articles
     * @return mixed
     */
    public function showCatalog()
    {
        $page = $this->node;

        $sortOrder = $this->model->getSortOrder();
        $perPage   = $this->model->getPerPage();

        $articles = $this->model->active()->filterCustomOrder($sortOrder)->paginate($perPage);

        if ($articles->count()) {
            $articles->load($this->model->getRelationsInCatalog());
        }

        return view("pages.".$this->model->getViewFolder() .".catalog", compact('articles', 'page'));
    }

    /**
     * Returns single article
     * @param $slug string
     * @param $id int
     * @return mixed
     */
    public function showArticle($slug, $id)
    {
        $page = $this->model->where('id', $id)->active()->firstOrFail();
        
        if ($page->getSlug() != $slug) {
            return redirect($page->getUrl(), 302);
        }

        $page->load($this->model->getRelationsInArticle());

        return view("pages.".$this->model->getViewFolder().".article", compact('page'));
    }

}
