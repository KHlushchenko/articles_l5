<?php namespace Vis\Articles\Filters;

use Vis\Articles\Models\AbstractArticle;
use Illuminate\Support\Facades\Input;

abstract class AbstractFilter
{
    /** Defines articles model that will be used
     * @var AbstractArticle
     */
    protected $model;

    /**
     * ArticleFilterHandler constructor. Defined as private to prevent initiating of object
     * @param AbstractArticle $model
     * @param array $additionalParams
     */
    public function __construct(AbstractArticle $model, ...$additionalParams)
    {
        $this->model = $model;
    }

    /**
     * @param string $needle
     * @param array $array
     * @param string $column
     * @return string
     */
    protected function getFromArray(string $needle, array $array, string $column = 'name'): string
    {
        $needle = Input::get($needle);

        if ($needle === null || ($key = array_search($needle, array_column($array, $column))) === false) {
            return '';
        }

        return $array[$key]['value'];
    }

    //fixme move this method to interface?

    /** Handles filters
     */
    abstract public function handle();

}
