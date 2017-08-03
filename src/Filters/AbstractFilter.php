<?php namespace Vis\Articles\Filters;

use Vis\Articles\Interfaces\FilterInterface;
use Vis\Articles\Interfaces\FilterableArticleInterface;
use Illuminate\Support\Facades\Input;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * Defines articles model that will be used
     * @var FilterableArticleInterface
     */
    protected $model;

    /**
     * Defines list of options for filter
     * @var mixed
     */
    protected $options;

    /**
     * Defines selected option for filter
     * @var mixed
     */
    protected $selected;

    /**
     * ArticleFilterHandler constructor. Defined as private to prevent initiating of object
     * @param FilterableArticleInterface $model
     * @param array $additionalParams
     */
    public function __construct(FilterableArticleInterface $model, ...$additionalParams)
    {
        $this->model = $model;
    }

    /**
     * Returns options list for filter
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Returns selected option for filter
     * @return mixed
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * Helper function to get value from array set in model
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

    /**
     * Helper function to get value from Input by key
     * @param $key
     * @return mixed
     */
    protected function getFromInput($key)
    {
        return Input::get($key);
    }

    /**
     * Handles list of options for filter
     * @return string
     */
    abstract protected function handleOptions();

    /**
     * Handles selected option for filter
     * @return string
     */
    abstract protected function handleSelected();

    /**
     * Handles filters
     */
    public function handle()
    {
        $this->options  = $this->handleOptions();
        $this->selected = $this->handleSelected();

        return $this;
    }

}
