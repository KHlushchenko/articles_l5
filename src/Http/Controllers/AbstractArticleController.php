<?php namespace Vis\Articles\Controllers;

use Vis\Articles\Models\AbstractArticle;
use Vis\Builder\TreeController;

abstract class AbstractArticleController extends TreeController
{
    /** Property that defines articles model
     * @var AbstractArticle
     */
    protected $model = "";

    /** Initiates instance of model
     * AbstractArticleController constructor.
     */
    public function __construct()
    {
        $this->setModel(new $this->model);
    }

    /** Sets instance of AbstractArticle as usable Model
     * @param AbstractArticle $model
     */
    private function setModel(AbstractArticle $model)
    {
        $this->model = $model;
    }

}
