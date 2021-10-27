<?php

namespace App\Repositories;

use App\Models\PlayerStats;
use Tightenco\Collect\Support\Collection;

class PlayerStatsRepository
{
    /**
     * The allowed filters when retrieving player stats.
     *
     * @var array
     */
    protected $filters = [
        'playerId' => 'roster.id',
        'player' => 'roster.name',
        'team' => 'roster.team_code',
        'position' => 'roster.pos',
        'country' => 'roster.nationality',
    ];

    /**
     * Get all the player stats.
     *
     * @param \Tightenco\Collect\Support\Collection $filters
     * @return \Tightenco\Collect\Support\Collection
     */
    public function get(Collection $filters)
    {
        $sql = <<<SQL
SELECT roster.name, player_totals.*
FROM player_totals
INNER JOIN roster ON roster.id = player_totals.player_id
SQL;

        $wheres = $filters->filter(function ($_, $key) {
            return in_array($key, array_keys($this->filters));
        })->map(function ($value, $key) {
            return "{$this->filters[$key]} = '{$value}'";
        });

        if ($wheres->isNotEmpty()) {
            $sql .= " WHERE {$wheres->implode(' AND ')}";
        }

        return collect(query($sql) ?: [])->mapInto(PlayerStats::class);
    }
}
