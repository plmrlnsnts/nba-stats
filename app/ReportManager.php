<?php

namespace App;

use App\Formatters\CSVFormatter;
use App\Formatters\HTMLFormatter;
use App\Formatters\JSONFormatter;
use App\Formatters\XMLFormatter;
use App\Reports\PlayersReport;
use App\Reports\PlayerStatsReport;
use Exception;
use Tightenco\Collect\Support\Collection;

class ReportManager
{
    /**
     * The request object as a collection.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    protected $request;

    /**
     * Create a new report manager instance.
     *
     * @param \Tightenco\Collect\Support\Collection $request
     */
    public function __construct(Collection $request)
    {
        $this->request = $request;
    }

    /**
     * Create the report based on the given name.
     *
     * @param string $name
     * @param string $format
     * @return string
     */
    public function make($name, $format = 'html')
    {
        $report = collect($this->reports())->first(function ($report) use ($name) {
            return $report::$name === $name;
        }, function () use ($name) {
            throw new Exception("Report type [$name] is not suppported");
        });

        $result = (new $report)->generate($this->request);

        $formatter = collect($this->formats())->first(function ($_, $key) use ($format) {
            return $key === strtolower($format);
        }, function () {
            return $this->defaultFormatter();
        });

        return (new $formatter)->toResponse($result);
    }

    /**
     * List all the supported reports.
     *
     * @return array
     */
    public function reports()
    {
        return [
            PlayersReport::class,
            PlayerStatsReport::class,
        ];
    }

    /**
     * List all the supported response formats.
     *
     * @return array
     */
    public function formats()
    {
        return [
            'csv' => CSVFormatter::class,
            'html' => HTMLFormatter::class,
            'json' => JSONFormatter::class,
            'xml' => XMLFormatter::class,
        ];
    }

    /**
     * Get the default formatter.
     *
     * @return mixed
     */
    public function defaultFormatter()
    {
        return HTMLFormatter::class;
    }
}
