<?php
namespace Vis\Articles\Controllers;

use Vis\Articles\Interfaces\ArticleInterface;
use Vis\Builder\TreeController;

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

}
