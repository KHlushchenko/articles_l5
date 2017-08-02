<?php namespace Vis\Articles\Interfaces;

interface FilterInterface
{
    /**
     * Handle filter
     */
    public function handle();

    /**
     * Returns selected option for filter
     */
    public function getSelected();

    /**
     * Returns options list for filter
     */
    public function getOptions();

}
