<?php

namespace App\Repositories;

use App\Models\Player;
use Tightenco\Collect\Support\Collection;

class PlayersRepository
{
    /**
     * The allowed filters when retrieving player information.
     *
     * @var array
     */
    protected $filters = [
        'playerId' => 'roster.id',
        'player' => 'roster.name',
        'team' => 'roster.team_code',
        'position' => 'roster.position',
        'country' => 'roster.nationality',
    ];

    /**
     * Get all the player stats.
     *
     * @param \Tightenco\Collect\Support\Collection $request
     * @return \Tightenco\Collect\Support\Collection
     */
    public function get(Collection $request)
    {
        $sql = 'SELECT roster.* FROM roster';

        $wheres = $request->filter(function ($_, $key) {
            return in_array($key, array_keys($this->request));
        })->map(function ($value, $key) {
            return "{$this->request[$key]} = '{$value}'";
        });

        if ($wheres->isNotEmpty()) {
            $sql .= " WHERE {$wheres->implode(' AND ')}";
        }

        return collect(query($sql) ?: [])->mapInto(Player::class);
    }
}
