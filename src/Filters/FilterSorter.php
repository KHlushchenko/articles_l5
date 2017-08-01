<?php namespace Vis\Articles\Filters;

final class FilterSorter extends AbstractFilter
{
    /** Defines selected order filter
     * @var string
     */
    private $sortSelected;

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

    /** Handles sortSelected property
     * @return string
     */
    private function handleSortSelected()
    {
        return $this->getFromArray('sort', $this->getSortOptions()) ?: $this->model->getSortOrder();
    }

    /** Handles filters
     */
    public function handle()
    {
        $this->sortSelected = $this->handleSortSelected();
    }
}
