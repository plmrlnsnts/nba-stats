<?php

namespace App\Reports;

use App\Repositories\PlayerStatsRepository;
use Tightenco\Collect\Support\Collection;

class PlayerStatsReport
{
    /**
     * A unique name for this report.
     *
     * @var string
     */
    public static $name = 'playerstats';

    /**
     * Generate the data for this report.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    public function generate(Collection $request)
    {
        return (new PlayerStatsRepository)->get($request)->map(function ($row) {
            return $row->toArray();
        })->sortBy(
            $request->get('sort'),
            SORT_REGULAR,
            $request->get('direction') === 'desc'
        )->values();
    }
}
