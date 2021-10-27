<?php

namespace App;

use Tightenco\Collect\Support\Collection;

class ReportController
{
    public function export(Collection $request)
    {
        if (! in_array($request->get('type'), ['playerstats', 'players'])) {
            exit('The selected report type is invalid');
        }

        return (new ReportManager($request))->make(
            $request->get('type'),
            $request->get('format')
        );
    }
}
