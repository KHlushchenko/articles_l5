<?php namespace Vis\Articles\Interfaces;

interface ArticleInterface
{
    public function getPerPageSetting();

    public function getViewFolder();

    public function getSortOptions();
}
