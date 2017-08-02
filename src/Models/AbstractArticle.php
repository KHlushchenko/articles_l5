<?php namespace Vis\Articles\Models;

use Carbon\Carbon;

use \BaseModel;
use \Setting;

use Vis\Articles\Interfaces\DateInterface;
use Vis\Articles\Traits\DateTrait;

//fixme split into AbstractArticle and AbstractFilterableArticle
abstract class AbstractArticle extends BaseModel implements DateInterface
{
    use DateTrait;

    /** Defines folder in which views are stored
     * @var string
     */
    protected $viewFolder = "";

    /** Defines sorting order
     * @var string
     */
    protected $sortOrder = 'created_at:desc';

    /** Optional property. Defines setting name that contains pagination number
     * @var string
     */
    protected $perPageSettingName = "";

    /** Defines pagination number
     * @var int
     */
    protected $perPage = 12;

    /** Defines array of related eager loading methods for catalog
     * @var array
     */
    protected $relationsInCatalog = [];

    /** Defines array of related eager loading methods for article
     * @var array
     */
    protected $relationsInArticle = [];

    /** Defines array of arrays of sorting options
     * Signature: [ ['name', 'description', 'value']
     * @var array
     */
    protected $sortOptions = [];

    /** Defines array of arrays of counting options
     * Signature: [ ['name', 'description', 'value']
     * @var array
     */
    protected $countOptions = [];

    /** Defines dateField for model
     * @var string
     */
    protected $dateField = 'created_at';

    /** Returns viewFolder property
     * @return string
     */
    public function getViewFolder(): string
    {
        return $this->viewFolder;
    }

    /** Returns sortOrder property
     * @return string
     */
    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }

    /** Returns perPage property
     * @return int
     */
    public function getPerPage(): int
    {
        if ($this->perPageSettingName && $perPage = Setting::get($this->perPageSettingName)) {
            $this->perPage = $perPage;
        }

        return $this->perPage;
    }

    /** Returns relationsInCatalog property
     * @return array
     */
    public function getRelationsInCatalog(): array
    {
        return $this->relationsInCatalog;
    }

    /** Returns relationsInArticle property
     * @return array
     */
    public function getRelationsInArticle(): array
    {
        return $this->relationsInArticle;
    }

    public function getSortOptions(): array
    {
        return $this->sortOptions;
    }

    /** Returns countOptions property
     * @return array
     */
    public function getCountOptions(): array
    {
        return $this->countOptions;
    }

    /** Returns dateField property
     * @return string
     */
    public function getDateField(): string
    {
        return $this->dateField;
    }

    /** Scope to filter articles by filter model
     * @param $query
     * @param $page
     * @param $filterName
     * @return mixed
     */
    public function scopeFilterByModel($query, $page, $filterName)
    {
        if (!$page) {
            return $query;
        }

        return $query->whereHas($filterName, function ($subQuery) use ($page) {
            $subQuery->where("id", $page->id);
        });
    }

    /** Scope to retrieve only articles for main page
     * @param $query
     * @return mixed
     */
    public function scopeIsMain($query)
    {
        return $query->where("is_main", 1);
    }

    /** Scope to order articles by field:order signature
     * @param $query
     * @param string $order
     * @return mixed
     */
    public function scopeCustomOrder($query, string $order)
    {
        if (list($field, $order) = array_filter(explode(":", $order))) {
            return $query->orderBy($field, $order);
        }

        return $query;
    }

    /** Scope to filter articles by date field in range
     * @param $query
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @return mixed
     */
    public function scopeDateRange($query, Carbon $dateFrom, Carbon $dateTo)
    {
       return $query->whereBetween($this->getDateField(), [$dateFrom, $dateTo]);
    }

    /** Scope to filter articles by date field in strict comparision
     * @param $query
     * @param array $date
     * @return mixed
     */
    public function scopeDateStrict($query, array $date)
    {
        $date = implode("-", array_filter($date));

        if ($date) {
            return $query->where($this->getDateField(), 'like', $date . '%');
        }

        return $query;
    }

}
