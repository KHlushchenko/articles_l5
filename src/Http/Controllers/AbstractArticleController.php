<?php namespace Vis\Articles\Controllers;

use Illuminate\Support\Facades\Redirect;
use Vis\Builder\TreeController;
use Vis\Articles\Models\InputCleaner;
use \Setting;

abstract class AbstractArticleController extends TreeController
{
    protected $model;

    public function __construct()
    {
        $this->model = new $this->model;
    }

    public function showCatalog()
    {
        $page = $this->node;

        $perPage = Setting::get($this->model->getPerPageSetting(), 12);

        $articles = $this->model->active()->byCreatedAt()->paginate($perPage);

        return view("pages.".$this->model->getViewFolder() .".catalog", compact('articles', 'page'));
    } // end showListCategory

    public function showCatalogWithFilters($slug = null)
    {
        $filterModel = $this->model->getFilterModel();

        //fixme ALL filter
        if($slug){
            $page = $filterModel::where('slug', $slug)->active()->first();
            if (!$page) {
                abort(404);
            }
            $noFilterUrl = str_replace("/".$page->getSlug(), "",$page->getUrl());
        }else{
            $page = $this->node;
            $noFilterUrl = $page->getUrl();
        }

        $filters = $filterModel::active()->get();

        $orderOptions = $this->model->getSortOptions();
        $orderFilter = InputCleaner::getOrderByFilter();

        $perPageDefault = Setting::get($this->model->getPerPageSetting(), 12);
        $countFilter = InputCleaner::getCountFilter($perPageDefault);

        $countOptions = [
            $perPageDefault,
            $perPageDefault*2,
            $perPageDefault*3,
        ];

        $articles = $this->model->active()->with('type')->orderBy($orderFilter);

        //fixme ALL filter
        if( $slug ) {
            $articles->whereParent_id($page->id);
        }

        $articles = $articles->paginate($countFilter);

        return view("pages.".$this->model->getViewFolder() .".catalog_with_filters",
            compact(
                'page',
                'filters',
                'articles',
                'noFilterUrl',
                'perPageDefault',
                'orderFilter',
                'orderOptions',
                'countFilter',
                'countOptions'
            )
        );
    }

    public function showSingle($slug, $id)
    {
        $page = $this->model->where('id', $id)->active()->first();

        if (!$page) {
            abort(404);
        }

        if ($page->getSlug() != $slug) {
            return Redirect::to($page->getUrl(), 302);
        }

        return view("pages.".$this->model->getViewFolder().".article", compact('page'));
    } // end showSingle

    public function showSingleByParent($catalog,$slug, $id)
    {
        $page = $this->model->where('id', $id)->with('type')->active()->first();

        if (!$page) {
            abort(404);
        }

        if ($page->type->getSlug() != $catalog) {
            return Redirect::to($page->getUrl(), 302);
        }

        if ($page->getSlug() != $slug) {
            return Redirect::to($page->getUrl(), 302);
        }

        return view("pages.".$this->model->getViewFolder().".article", compact('page'));
    } // end showSingle

}
