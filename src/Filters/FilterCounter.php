<?php namespace Vis\Articles\Filters;

final class FilterCounter extends AbstractFilter
{
    /** Defines selected count filter
     * @var string
     */
    private $countSelected;

    /** Returns countOptions property from model class
     * @return mixed
     */
    public function getCountOptions(): array
    {
        return $this->model->getCountOptions();
    }

    /** Returns countSelected property
     * @return int
     */
    public function getCountSelected(): int
    {
        return $this->countSelected;
    }

    /** Handles countSelected property
     * @return string
     */
    private function handleCountSelected()
    {
        return $this->getFromArray('count', $this->getCountOptions()) ?: $this->model->getPerPage();
    }

    /** Handles filters
     */
    public function handle()
    {
        $this->countSelected = $this->handleCountSelected();
    }
}
