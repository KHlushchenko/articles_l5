<?php namespace Vis\Articles\Handlers;

use Vis\Articles\Models\AbstractFilterableArticle;
use Illuminate\Support\Facades\Input;

final class ArticleFilterHandler
{
    /** Defines articles model that will be used
     * @var
     */
    private $model = "";

    /** Defines selected order filter
     * @var
     */
    private $sortSelected;

    /**Defines selected count filter
     * @var
     */
    private $countSelected;

    /** Returns sortOptions property from model class
     * @return mixed
     */
    public function getSortOptions(): array
    {
        return $this->model->getSortOptions();
    }

    /** Returns sortSelected property
     * @return mixed
     */
    public function getSortSelected(): string
    {
        return $this->sortSelected;
    }

    /** Returns countOptions property from model class
     * @return mixed
     */
    public function getCountOptions(): array
    {
        return $this->model->getCountOptions();
    }

    /** Returns countSelected property
     * @return mixed
     */
    public function getCountSelected(): int
    {
        return $this->countSelected;
    }

    /** Returns filterOptions from model class
     * @return mixed
     */
    public function getFilterOptions()
    {
        return $this->model->getFilterModelOptions();
    }

    /**
     * ArticleFilterHandler constructor. Defined as private to prevent initiating of object
     * @param AbstractFilterableArticle $model
     */
    private function __construct(AbstractFilterableArticle $model)
    {
        $this->model = $model;
    }

    /**
     * @param $needle
     * @param array $array
     * @param string $column
     * @return bool
     */
    private function getFromArray($needle, array $array, string $column = 'name')
    {
        if ($needle === null || ($key = array_search($needle, array_column($array, $column))) === false) {
            return false;
        }

        return $array[$key]['value'];
    }

    /** Returns current count selected option
     * @return int
     */
    private function handleCountSelected(): int
    {
        $countSelected = $this->getFromArray(Input::get('count'), $this->getCountOptions()) ?: $this->model->getPerPage();

        return $countSelected;
    }

    /** Returns current sorting selected option
     * @return string
     */
    private function handleSortSelected(): string
    {
        $sortSelected = $this->getFromArray(Input::get('sort'), $this->getSortOptions()) ?: $this->model->getSortOrder();

        return $sortSelected;
    }

    /** Entry point to ArticleFilterHandler object
     * @param AbstractFilterableArticle $model
     * @return static
     */
    public static function handleFilters(AbstractFilterableArticle $model)
    {
        $articleFilterHandler = new static($model);

        $articleFilterHandler->sortSelected  = $articleFilterHandler->handleSortSelected();
        $articleFilterHandler->countSelected = $articleFilterHandler->handleCountSelected();

        return $articleFilterHandler;
    }
}
