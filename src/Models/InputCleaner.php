<?php namespace Vis\Articles\Models;

use Illuminate\Support\Facades\Input;

class InputCleaner
{
    public static function getOrderByFilter()
    {
        $orderFilter = 'created_at';

        if(Input::has('order')){
            switch (Input::get('order')){
                case 'date_event':
                    $orderFilter = 'event_start_at';
                    break;
                case 'cook':
                    $orderFilter = 'id_cook';
                    break;
                case 'name':
                    //fixme default locale
                    //fixme read config
                    $locale = App::getLocale();
                    $defaultLocale = Config::get('app.locale');
                    $orderFilter = $locale != $defaultLocale ? "title_".$locale :"title";
                    break;
                case 'date';
                default:
                    $orderFilter = 'created_at';
                    break;
            }
        }
        return $orderFilter;
    }

    public static function getCountFilter($perPageDefault)
    {
        $countFilter = $perPageDefault;

        if(Input::has('count') ){
            $inputCount = Input::get('count');
            if(is_numeric($inputCount)){
                $countFilter = $inputCount;
            }else{
                $countFilter = 999999;
            }
        }

        return $countFilter;
    }

    public static function getPageNumber()
    {
        $pageNumber = (int) Input::get('page');
        return $pageNumber;
    }

}