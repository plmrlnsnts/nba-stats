<?php

namespace App\Reports;

use App\Repositories\PlayersRepository;
use Tightenco\Collect\Support\Collection;

class PlayersReport
{
    /**
     * A unique name for this report.
     *
     * @var string
     */
    public static $name = 'players';

    /**
     * Generate the data for this report.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    public function generate(Collection $request)
    {
        return (new PlayersRepository)->get($request)->map(function ($row) {
            return $row->toArray();
        })->sortBy(
            $request->get('sort'),
            SORT_REGULAR,
            $request->get('direction') === 'desc'
        )->values();
    }
}
