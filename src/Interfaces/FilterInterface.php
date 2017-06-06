<?php namespace Vis\Articles\Interfaces;

interface FilterInterface
{
    public function scopeIsMain($query);

    public function scopeByCreatedAt($query);
}
