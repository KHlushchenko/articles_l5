<?php namespace Vis\Articles\Traits;

trait FilterTrait
{
    protected $sortOptions = [
        'created_at' => 'date',
        'title'      => 'name',
    ];

    public function getSortOptions()
    {
        return $this->sortOptions;
    }

    public function scopeIsMain($query)
    {
        return $query->where("is_main", 1);
    }

    public function scopeByCreatedAt($query)
    {
        return $query->orderBy("created_at", "desc");
    }
}
