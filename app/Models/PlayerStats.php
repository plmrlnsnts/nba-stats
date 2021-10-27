<?php

namespace App\Models;

class PlayerStats extends Model
{
    protected $hidden = ['player_id'];

    public function getTotalPoints()
    {
        return collect([
            $this->attributes['3pt'] * 3,
            $this->attributes['2pt'] * 2,
            $this->attributes['free_throws'],
        ])->sum();
    }

    public function getFieldGoalsPercentage()
    {
        if (! $this->attributes['field_goals_attempted']) return 0;

        return round($this->attributes['field_goals'] / $this->attributes['field_goals_attempted'], 2) * 100 . '%';
    }

    public function getThreePointGoalPercentage()
    {
        if (! $this->attributes['3pt_attempted']) return 0;

        return round($this->attributes['3pt'] / $this->attributes['3pt_attempted'], 2) * 100 . '%';
    }

    public function getTwoPointGoalPercentage()
    {
        if (! $this->attributes['2pt_attempted']) return 0;

        return round($this->attributes['2pt'] / $this->attributes['2pt_attempted'], 2) * 100 . '%';
    }

    public function getFreeThrowPointGoalPrecentage()
    {
        if (! $this->attributes['free_throws_attempted']) return 0;

        return round($this->attributes['free_throws'] / $this->attributes['free_throws_attempted'], 2) * 100 . '%';
    }

    public function getTotalRebounds()
    {
        return $this->attributes['offensive_rebounds'] + $this->attributes['defensive_rebounds'];
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'total_points' => $this->getTotalPoints(),
            'field_goals_pct' => $this->getFieldGoalsPercentage(),
            '3pt_pct' => $this->getThreePointGoalPercentage(),
            '2pt_pct' => $this->getTwoPointGoalPercentage(),
            'free_throws_pct' => $this->getFreeThrowPointGoalPrecentage(),
            'total_rebounds' => $this->getTotalRebounds(),
        ]);
    }
}
