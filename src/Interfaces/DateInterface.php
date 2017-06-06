<?php namespace Vis\Articles\Interfaces;

interface DateInterface
{
    public function getYear($field = 'created_at');

    public function getMonth($field = 'created_at');

    public function getNameMonth($field = 'created_at');

    public function getShortNameMonth($field = 'created_at');

    public function getDay($field = 'created_at');

    public function getHour($field = 'created_at');

    public function getMinute($field = 'created_at');

    public function getSecond($field = 'created_at');

    public function getDate($field = 'created_at', $dateSeparator = ".");

    public function getNamedDate($field = 'created_at', $dateSeparator = " ");

    public function getTime($field = 'created_at', $timeSeparator = ":");

    public function getDateTime($field = 'created_at', $dateSeparator = ".", $timeSeparator = ":");
}

