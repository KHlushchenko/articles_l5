<?php namespace Vis\Articles\Controllers;

abstract class AbstractSimpleArticleController extends AbstractArticleController
{
    /** Returns catalog of articles
     * @return mixed
     */
    public function showCatalog()
    {
        $page = $this->node;

        $sortOrder = $this->model->getSortOrder();
        $perPage   = $this->model->getPerPage();

        $articles = $this->model->active()->customOrder($sortOrder)->paginate($perPage);

        if ($articles->count()) {
            $articles->load($this->model->getRelationsInCatalog());
        }

        return view("pages.".$this->model->getViewFolder() .".catalog", compact('articles', 'page'));
    }

    /** Returns single article
     * @param $slug string
     * @param $id int
     * @return mixed
     */
    public function showArticle($slug, $id)
    {
        $page = $this->model->where('id', $id)->active()->first();

        if (!$page) {
            abort(404);
        }

        if ($page->getSlug() != $slug) {
            return redirect($page->getUrl(), 302);
        }

        $page->load($this->model->getRelationsInArticle());

        return view("pages.".$this->model->getViewFolder().".article", compact('page'));
    }

}
