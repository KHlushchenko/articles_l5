<?php namespace Vis\Articles\Models;

use \BaseModel;
use \Setting;

use Vis\Articles\Interfaces\DateInterface;
use Vis\Articles\Traits\DateTrait;

abstract class AbstractArticle extends BaseModel implements DateInterface
{
    use DateTrait;

    /** Defines folder in which views are stored
     * @var
     */
    protected $viewFolder = "";

    /** Defines sorting order
     * @var string
     */
    protected $sortOrder = 'created_at:desc';

    /** Optional property. Defines setting name that contains pagination number
     * @var
     */
    protected $perPageSettingName = "";

    /** Defines pagination number
     * @var
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
}
