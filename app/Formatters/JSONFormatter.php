<?php

namespace App\Formatters;

use Tightenco\Collect\Support\Collection;

class JSONFormatter
{
    /**
     * Send a JSON response to the client.
     *
     * @param \Tightenco\Collect\Support\Collection $collection
     * @return string
     */
    public function toResponse(Collection $collection)
    {
        header('Content-type: application/json');

        return json_encode($collection);
    }
}
