<?php
namespace Vis\Articles\Filters;

use Carbon\Carbon;

final class FilterDateMonth extends AbstractFilter
{
    /**
     * Handles list of options for filter
     * @return array
     */
    protected function handleOptions(): array
    {
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $description = Carbon::createFromFormat('!m', $i)->formatLocalized('%B');
            $month[] = ['name' => $i, 'description' => $description, 'value' => $i];
        }

        return $month;
    }

    /**
     * Handles selected option for filter
     * @return int
     */
    protected function handleSelected():int
    {
        return (int) $this->getFromArray('month', $this->getOptions());
    }

}
