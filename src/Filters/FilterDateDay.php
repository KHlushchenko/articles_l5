<?php namespace Vis\Articles\Filters;

final class FilterDateDay extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return mixed
     */
    protected function handleOptions(): array
    {
        return [];
    }

    /**
     * Handles selected option for filter
     * @return int
     */
    protected function handleSelected(): int
    {
        $day = (int)$this->getFromInput('day');

        if ($day && $day <= 31) {
            return $day;
        }

        return 0;
    }

}
