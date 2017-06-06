<?php namespace Vis\Articles\Models;

use \BaseModel;

use Vis\Articles\Interfaces\ArticleInterface;
use Vis\Articles\Interfaces\FilterInterface;
use Vis\Articles\Interfaces\DateInterface;

abstract class AbstractArticle extends BaseModel implements ArticleInterface, FilterInterface, DateInterface
{
    use Vis\Articles\Traits\ArticleTrait;
    use Vis\Articles\Traits\DateTrait;
    use Vis\Articles\Traits\FilterTrait;

    //fixme
    public function type()
    {
        return $this;
    }

    public function getFilterModel(){

        $relatedClass = $this->type()->getRelated();

        return $relatedClass;
    }

}