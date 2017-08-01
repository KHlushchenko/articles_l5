<?php namespace Vis\Articles\Filters;

use Vis\Articles\Interfaces\FilterInterface;
use Vis\Articles\Models\AbstractArticle;
use Illuminate\Support\Facades\Input;

abstract class AbstractFilter implements FilterInterface
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

    /** Helper function to get value from array set in model
     * @param string $inputKey
     * @param array $array
     * @param string $column
     * @return string
     */
    protected function getFromArray(string $inputKey, array $array, string $column = 'name'): string
    {
        $value = $this->getFromInput($inputKey);

        if ($value === null || ($key = array_search($value, array_column($array, $column))) === false) {
            return '';
        }

        return $array[$key]['value'];
    }

    /** Helper function to get value from Input by key
     * @param $key
     * @return mixed
     */
    protected function getFromInput($key)
    {
        return Input::get($key);
    }
}

