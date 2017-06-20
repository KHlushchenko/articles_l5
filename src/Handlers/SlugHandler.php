<?php namespace Vis\Articles\Handlers;

use Vis\Builder\Handlers\CustomHandler;

class SlugHandler extends CustomHandler
{
    public function onInsertRowResponse(array &$response)
    {
        $model =  $this->controller->getDefinition()['options']['model'];
        $model::where('id',$response['id'])->update(['slug' => Jarboe::urlify(($response['values']['title']))]);
    } // end onInsertRowResponse
    
    public function onUpdateRowResponse(array &$response)
    {
        $model =  $this->controller->getDefinition()['options']['model'];
        $model::where('id',$response['id'])->update(['slug' => Jarboe::urlify(($response['values']['title']))]);
    }

}