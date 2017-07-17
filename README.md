# Articles
Пакет для Laravel 5.2+ предназначенный работы с материалами, которые можно предоставить в виде "Каталог статей - Статья".

Разделы
1. [Установка](#Установка)
2. [Спецификация нефильтруемых статей](#Спецификация-нефильтруемых-статей)
3. [Спецификация фильтруемых статей](#Спецификация-фильтруемых-статей)


## Установка
Выполняем
```json
    composer require "vis/articles_l5":"1.*"
```

## Спецификация нефильтруемых статей
Для использования функционала нефильтруемых статей необходимо:

1. Создать модель, которая наследует Vis\Articles\Models\AbstractArticle, которая в свою очередь наследует BaseModel

```php
    use Vis\Articles\Models\AbstractArticle;
    
    class PackageArticle extends AbstractArticle
    {    
        protected $table = 'package_articles';
    
        protected $viewFolder = 'package_articles';
    
        protected $sortOrder = "created_at:desc";
    
        protected $perPage = 25;
        protected $perPageSettingName = 'kol_statei-v-kataloge-novostei';
    
        public function getUrl()
        {
            return route("package_article", [$this->getSlug(), $this->id]);
        }
    }
```
Описание свойств:

Путь к папке с view templates </br> 
Если значение 'sub_folder.package_articles', тогда view должны лежать в папке /resources/views/pages/sub_folder/package_articles</br>
Значение: путь к папке через точки 
```php
    protected $viewFolder = 'package_articles';
```

Путь к папке с view templates </br> 
Значение: название_поля:порядок, по умолчанию: created_at:desc
```php
    protected $sortOrder = "created_at:desc";
```

Количество статей на странице каталога</br> 
Значение: целое число, по умолчанию: 12
```php
    protected $perPage = 25;
```

Название опции в CMS, которая содержит количество статей на странице каталога. Если указано, то параметр $perPage игнорируется</br> 
Значение: строка с названием опции в CMS
```php
    protected $perPageSettingName = 'kol_statei-v-kataloge-novostei';
```

2. Создать контроллер, который наследует Vis\Articles\Controllers\AbstractArticleController

```php
    use Vis\Articles\Controllers\AbstractArticleController;
    
    class PackageArticlesController extends AbstractArticleController
    {
        protected $model = "PackageArticle";
    }
```

Описание свойств:

Название модели, которая будет использоваться</br> 
Значение: строка с названием модели </br>
```php
     protected $model = "PackageArticle";
```

3. Создать шаблон в \config\builder\tree.php
```php
    'articles_catalog' => array(
        'action' => 'PackageArticlesController@showCatalog',
        'node_definition' => 'node',
        'check' => function() {
            return true;
        },
        'title' => 'Каталог статей',
    ),
```

4. Определить именной роут, по которому будут доступны статьи
```php
    Route::get('/test-articles-catalog/{slug}-{id}', [
        'as' => 'package_article',
        'uses' => 'PackageArticlesController@showArticle'
    ]);
```

5. Создать два шаблона **article.blade.php** и **catalog.blade.php** в соответствующей параметру $viewFolder папке.
Пример article.blade.php
```php
@extends('layouts.default')

@section('main')

    <section class="article-section">
        <div class="article-text">
            <h1>
                {{$page->t('title')}}
            </h1>
        </div>
    </section>

@stop
```

Пример catalog.blade.php
```php
@extends('layouts.default')

@section('main')

    <section class="associations-page">
        <div class="container">

            <div class="associations-list">
                @foreach($articles as $key => $article)
                    <div class="associations-item">
                        <div class="text">
                            <div class="title">
                                <a href="{{$article->getUrl()}}">
                                    {{$article->t('title')}}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@stop
```


## Спецификация фильтруемых статей
Часть параметров наследуется от нефильтруемой модели, их описание опущено. </br>
Для использования функционала фильтруемых статей необходимо:

1. Создать модель, которая наследует Vis\Articles\Models\AbstractArticle, которая в свою очередь наследует BaseModel

```php
use Vis\Articles\Models\AbstractFilterableArticle;

class PackageFilterableArticle extends AbstractFilterableArticle
{
    protected $table = 'articles_filterable';

    protected $viewFolder = 'package_filterable_articles';

    protected $sortOrder = "created_at:desc";

    protected $perPage = 25;
    protected $perPageSettingName = 'kol_statei-v-kataloge-novostei';

    protected $sortOptions = [
        ['name' => 'title', 'description' => 'По названию','value' => 'title:asc'],
        ['name' => 'new_first', 'description' => 'от новых к старым','value' => 'created_at:desc'],
        ['name' => 'old_first', 'description' => 'от старых к новым','value' => 'created_at:asc'],
    ];

    protected $countOptions = [
        ['name' => '15','description' => 'По 15', 'value' => 15 ],
        ['name' => 'all','description' => 'Все', 'value' => 99999999 ],
    ];

    protected $relationsInCatalog = [];

    protected $relationsInArticle = [];

    public function getUrl()
    {
       return route("package_filterable_article", [$this->filterModel->getSlug(),$this->getSlug(), $this->id]);
    }

    public function filterModel()
    {
        return $this->belongsTo('Tree');
    }
```
Описание дополнительных свойств:

Фильтры порядка сортировки </br> 
Значение: массив $sortOptions['name' => '', 'description' => '','value' => '']
```php
    protected $sortOptions = [
        ['name' => 'title', 'description' => 'По названию','value' => 'title:asc'],
        ['name' => 'new_first', 'description' => 'от новых к старым','value' => 'created_at:desc'],
        ['name' => 'old_first', 'description' => 'от старых к новым','value' => 'created_at:asc'],
    ];
```

Фильтры количества отображения на странице </br> 
Значение: массив $countOptions['name' => '', 'description' => '','value' => '']
```php
    protected $countOptions = [
        ['name' => '15','description' => 'По 15', 'value' => 15 ],
        ['name' => 'all','description' => 'Все', 'value' => 99999999 ],
    ];
```

Массив названий дополнительных Eloquent связей, которые необходимо загрузить в каталоге </br> 
Необходим для реализации Lazy Eager loading на страницах каталогов
Значение: массив $relationsInCatalog['', ...]
```php
    protected $relationsInCatalog = [];
```

Массив названий дополнительных Eloquent связей, которые необходимо загрузить в статье </br> 
Необходим для реализации Lazy Eager loading на страницах статей
Значение: массив $relationsInArticle['', ...]
```php
    protected $relationsInArticle = [];
```

Обязательный для реализации метод-связь с моделью фильтром. </br>
В таблице статьи поле-фильтр **должно** называться filter_model_id </br>
Указанная модель может быть как деревом, так и внешней моделью</br>
Значение: название связанной модели
```php
    public function filterModel()
    {
        return $this->belongsTo('Tree');
    }
```

2. Создать контроллер, который наследует Vis\Articles\Controllers\AbstractArticleController

```php
    use Vis\Articles\Controllers\AbstractFilterableArticleController;
    
    class PackageFilteredArticlesController extends AbstractFilterableArticleController
    {
        protected $model = "PackageFilterableArticle";
    }
```


3. Создать шаблон в \config\builder\tree.php
```php
    'filterable_catalog' => array(
        'action' => 'PackageFilteredArticlesController@showCatalog',
        'node_definition' => 'node',
        'check' => function() {
            return true;
        },
        'title' => 'фильтруемый каталог',
    ),
```
Если модель фильтров является деревом, тогда создаем еще шаблон: 
```php
    'filterable_sub_catalog' => array(
        'action' => 'PackageFilteredArticlesController@showSubCatalog',
        'node_definition' => 'node',
        'check' => function() {
            return true;
        },
        'title' => 'фильтруемый подкаталог',
    ),
```

Если модель фильтров внешняя модель, тогда необходимо создать роут для отслеживания фильтра:
```php
    Route::get('/test-filterable-articles-catalog-foreign/{catalog}', [
        'as' => 'test-filterable-articles-catalog-foreign',
        'uses' => 'PackageFilteredForeignArticlesController@showSubCatalog'
    ]);
```

Примечание. Для корректной работы у внешней модели-фильтра необходимо наличие поля slug. </br>
Для его автоматического заполнения в  definition`е этой модели можно определить предоставляемый handler Vis\Articles\Handlers\SlugHandler.

4. Определить именной роут, по которому будут доступны статьи
```php
    Route::get('/test-filterable-articles-catalog/{catalog}/{slug}-{id}', [
        'as' => 'package_filterable_article',
        'uses' => 'PackageFilteredArticlesController@showArticle'
    ]);
```

5. Создать два шаблона **article.blade.php** и **catalog.blade.php** в соответствующей параметру $viewFolder папке.</br>
Аналогично нефильтруемым статьям

6. Создать шаблон фильтров, который необходимо будет подключить на странице каталога. </br>
Желательно разместить его в views/partials, для того чтобы можно было подключать один шаблон фильтров на всех каталогах. </br>
Пример такого шаблона:
```php
<div class="filters-container text-right">
    <div class="filter-btn">{{__('Фильтры')}}</div>
    <div class="row-inline filters-row">
        <div class="col-inline-xs-6 middle filter">
            <select class="filter-url-select">
                <option value="{{$noFilterUrl}}">{{__('Все')}}</option>
                @foreach($filters->getFilterOptions() as $filter)
                    <option value="{{$filter->getUrl()}}" {{URL::current() == $filter->getUrl() ? 'selected' : ''}}>{{$filter->t('title')}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-inline-xs-6 middle text-right sorting">
            <form name="filter_form" method="GET">
                <div class="sorting-select">
                    <select name="sort" class='filter-select'>
                        @foreach($filters->getSortOptions() as $sortOption)
                            <option value="{{$sortOption['name']}}" {{$sortOption['value'] == $filters->getSortSelected() ?'selected' : ''}}>{{$sortOption['description']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="show-select">
                    <select name="count" class='filter-select'>
                        @foreach($filters->getCountOptions() as $optionValue)
                            <option value="{{$optionValue['name']}}" {{$optionValue['value'] == $filters->getCountSelected() ? 'selected' : ''}}>{{$optionValue['description']}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    'use strict';

    var Articles =
        {
            init: function ()
            {
                Articles.initSelects();
            },

            initSelects: function()
            {
                $(".filter-select").change(function() {
                    $(this).parents("form[name='filter_form']").submit();
                });

                $(".filter-url-select").change(function() {
                    location.href = $(this).find("option:selected").val();
                });

            },
        };

    jQuery(document).ready(function() {
        Articles.init();
    });
</script>
```
