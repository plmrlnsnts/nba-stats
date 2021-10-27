<?php

namespace App\Formatters;

use Tightenco\Collect\Support\Collection;

class CSVFormatter
{
    /**
     * Send a CSV response to the client.
     *
     * @param \Tightenco\Collect\Support\Collection $collection
     * @return string|null
     */
    public function toResponse(Collection $collection)
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv";');

        if (! $collection->count()) return;

        return implode("\n", array_merge([
            $this->getCollectionHeaders($collection)->join(',')
        ], $collection->map(function ($row) {
            return implode(',', array_values($row));
        })->all()));
    }

    /**
     * Extract the headings from the collection.
     *
     * @param \Tightenco\Collect\Support\Collection $collection
     * @return \Tightenco\Collect\Support\Collection
     */
    protected function getCollectionHeaders($collection)
    {
        return collect($collection->first())->keys()->map(function($item) {
            return collect(explode('_', $item))->map(function($item) {
                return ucfirst($item);
            })->join(' ');
        });
    }
}
