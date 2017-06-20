<?php namespace Vis\Articles\Interfaces;

interface FilterableArticleInterface
{
    /** Defines Eloquent relationship with filter model class
     * @return mixed
     */
    public function filterModel();
}

