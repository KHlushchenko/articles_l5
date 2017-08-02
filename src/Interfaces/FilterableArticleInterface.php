<?php namespace Vis\Articles\Interfaces;

use Carbon\Carbon;

interface FilterableArticleInterface extends ArticleInterface
{
    /**
     * Returns sortOptions property
     * @return array
     */
    public function getSortOptions(): array;

    /**
     * Returns countOptions property
     * @return array
     */
    public function getCountOptions(): array;

    /**
     * Returns dateField property
     * @return string
     */
    public function getDateField(): string;

    /**
     * Scope to filter articles by filter model
     * @param $query
     * @param $relationName
     * @param $relationSelected
     * @return mixed
     */
    public function scopeFilterRelation($query, $relationName, $relationSelected);

    /**
     * Scope to filter articles by date field in range
     * @param $query
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @return mixed
     */
    public function scopeFilterDateRange($query, Carbon $dateFrom, Carbon $dateTo);

    /**
     * Scope to filter articles by date field in strict comparision
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $day
     * @return mixed
     */
    public function scopeFilterDateStrict($query, int $year  = null, int $month  = null, int $day = null);
}
