<?php namespace Vis\Articles\Controllers;

use Vis\Articles\Filters\FilterComposite;

abstract class AbstractFilterableArticleController extends AbstractArticleController
{
    /**
     * Property that defines filter composite
     * @var FilterComposite
     */
    protected $filter;

    /**
     * AbstractFilterableArticleController constructor. Sets filter property with FilterComposite
     */
    public function __construct()
    {
        parent::__construct();

        $this->filter = new FilterComposite($this->model);
    }

}
