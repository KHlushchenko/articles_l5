<?php namespace Vis\Articles\Models;

use Vis\Articles\Interfaces\FilterableArticleInterface;

abstract class AbstractFilterableArticle extends AbstractArticle implements FilterableArticleInterface
{
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

    /** Returns sortOptions property
     * @return array
     */
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

    //todo this method should be hardly optimized
    /** Retrieves list of possible filter model objects and returns filterOptions collection
     * @return $filtersOptions
     */
    public function getFilterModelOptions()
    {
        $collection = collect();
        $articles = self::has('filterModel')->with('filterModel')->get();
        
        foreach($articles as $article){
            $collection->push($article->filterModel);
        }

        //fixme should be uniqueStrict for Laravel 5.4+
        $filtersOptions = $collection->unique();

        return $filtersOptions;
    }

    /** Scope to filter articles by filter model
     * @param $page
     * @param $query
     * @return mixed
     */
    public function scopeFilterByModel($query, $page)
    {
        return $query->whereHas('filterModel', function($subQuery) use ($page){
            $subQuery->where("id", $page->id);
        });
    }

}
