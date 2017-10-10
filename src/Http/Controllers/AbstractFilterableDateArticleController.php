<?php

namespace Vis\Articles\Controllers;

class AbstractFilterableDateArticleController extends AbstractFilterableArticleController
{
    /**
     * Returns catalog of articles filtered by date
     * @return mixed
     */
    public function showCatalog()
    {
        $page    = $this->node;
        $filters = $this->filter;

        $filters->addDateYear()->addDateMonth()->handle();

        $dateYear   = $filters->getDateYear()->getSelected();
        $dateMonth  = $filters->getDateMonth()->getSelected();
        $sortOrder  = $this->model->getSortOrder();
        $perPage    = $this->model->getPerPage();

        $articles = $this->model->active()
            ->filterDateYear($dateYear)
            ->filterDateMonth($dateMonth)
            ->filterCustomOrder($sortOrder)
            ->paginate($perPage);

        $articles->load($this->model->getRelationsInCatalog());

        return view("pages." . $this->model->getViewFolder() . ".catalog", compact('page', 'articles', 'filters'));
    }

}
