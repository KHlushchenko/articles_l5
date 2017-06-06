<div class="filters-container text-right">
    <div class="filter-btn">{{__('Фильтры')}}</div>
    <div class="row-inline filters-row">
        <div class="col-inline-xs-6 middle filter">
            <select class="filter-url-select">
                <option value="{{$noFilterUrl}}">{{__('Все')}}</option>
                @foreach($filters as $key=>$filter)
                    <option value="{{$filter->getUrl()}}" {{URL::current() == $filter->getUrl() ? 'selected' : ''}}>{{$filter->t('title')}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-inline-xs-6 middle text-right sorting">
            <form name="filter_form" method="GET">
                <div class="sorting-select">
                    <select name="order" class='filter-select'>
                        @foreach($orderOptions as $key=>$orderOption)
                            <option value="{{$orderOption}}" {{$orderFilter == $key ? 'selected' : ''}}>{{__($orderOption)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="show-select">
                    <select name="count" class='filter-select'>
                        @foreach($countOptions as $key=>$optionValue)
                            <option value="{{$optionValue}}" {{$countFilter == $optionValue ? 'selected' : ''}}>{{__("по")}} {{$optionValue}}</option>
                        @endforeach
                        <option value="all" {{$countFilter == 999999 ? 'selected' : ''}}>{{__("Все")}}</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>