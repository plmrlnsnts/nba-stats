<?php

namespace App\Formatters;

use LSS\Array2XML;
use Tightenco\Collect\Support\Collection;

class XMLFormatter
{
    /**
     * Send an XML response to the client.
     *
     * @param \Tightenco\Collect\Support\Collection $collection
     * @return string
     */
    public function toResponse(Collection $collection)
    {
        header('Content-type: text/xml');

        $entry = $collection->map(function ($row) {
            $result = [];

            foreach ($row as $key => $value) {
                $result[$this->normalizeKey($key)] = $value;
            }

            return $result;
        })->all();

        return Array2XML::createXML('data', compact('entry'))->saveXML();
    }

    /**
     * Fix any keys starting with numbers.
     *
     * @param string $key
     * @return string
     */
    protected function normalizeKey($key)
    {
        $numbers = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

        return preg_replace_callback('(\d)', function ($matches) use ($numbers) {
            return $numbers[$matches[0]] . '_';
        }, $key);
    }
}
