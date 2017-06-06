<?php namespace Vis\Articles\Traits;

trait ArticleTrait
{
    protected $perPageSetting;

    protected $viewFolder;

    public function getPerPageSetting()
    {
        return $this->perPageSetting;
    }

    public function getViewFolder()
    {
        return $this->viewFolder;
    }

}
