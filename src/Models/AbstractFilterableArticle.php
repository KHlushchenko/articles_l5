<?php
namespace Vis\Articles\Models;

use Carbon\Carbon;
use Vis\Articles\Interfaces\FilterableArticleInterface;

abstract class AbstractFilterableArticle extends AbstractArticle implements FilterableArticleInterface
{
    /**
     * Defines array of arrays of sorting options
     * Signature: [ ['name', 'description', 'value']
     * @var array
     */
    protected $sortOptions = [];

    /**
     * Defines array of arrays of counting options
     * Signature: [ ['name', 'description', 'value']
     * @var array
     */
    protected $countOptions = [];

    /**
     * Defines dateField for model
     * @var string
     */
    protected $dateField = 'created_at';

    /**
     * Returns sortOptions property
     * @return array
     */
    public function getSortOptions(): array
    {
        return $this->sortOptions;
    }

    /**
     * Returns countOptions property
     * @return array
     */
    public function getCountOptions(): array
    {
        return $this->countOptions;
    }

    /**
     * Returns dateField property
     * @return string
     */
    public function getDateField(): string
    {
        return $this->dateField;
    }

    /**
     * Scope to filter articles by filter model
     * @param $query
     * @param $relationName
     * @param $relationSelected
     * @return mixed
     */
    public function scopeFilterRelation($query, $relationName, $relationSelected)
    {
        if (!$relationSelected) {
            return $query;
        }

        return $query->whereHas($relationName, function ($subQuery) use ($relationSelected) {
            $subQuery->where("id", $relationSelected->id);
        });
    }

    /**
     * Scope to filter articles by day of date field
     * @param $query
     * @param int $day
     * @return mixed
     */
    public function scopeFilterDateDay($query, int $day = 0)
    {
        if ($day) {
            $query->whereDay($this->getDateField(), '=', $day);
        }

        return $query;
    }

    /**
     * Scope to filter articles by month of date field
     * @param $query
     * @param int $month
     * @return mixed
     */
    public function scopeFilterDateMonth($query, int $month = 0)
    {
        if ($month) {
            $query->whereMonth($this->getDateField(), '=', $month);
        }

        return $query;
    }

    /**
     * Scope to filter articles by year of date field
     * @param $query
     * @param int $year
     * @return mixed
     */
    public function scopeFilterDateYear($query, int $year = 0)
    {
        if ($year) {
            $query->whereYear($this->getDateField(), '=', $year);
        }

        return $query;
    }

    /**
     * Scope to filter articles by date field in strict comparision
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $day
     * @return mixed
     */
    public function scopeFilterDateStrict($query, int $year = 0, int $month = 0, int $day = 0)
    {
        return $query->filterDateDay($day)->filterDateMonth($month)->filterDateYear($year);
    }

    /**
     * Scope to filter articles by date field in range
     * @param $query
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @return mixed
     */
    public function scopeFilterDateRange($query, Carbon $dateFrom, Carbon $dateTo)
    {
        return $query->whereBetween($this->getDateField(), [$dateFrom, $dateTo]);
    }

}
