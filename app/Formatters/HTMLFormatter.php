<?php

namespace App\Formatters;

use Tightenco\Collect\Support\Collection;

class HTMLFormatter
{
    /**
     * Send a JSON response to the client.
     *
     * @param \Tightenco\Collect\Support\Collection $collection
     * @return string
     */
    public function toResponse(Collection $collection)
    {
        if ($collection->isEmpty()) {
            return $this->render('Sorry, no matching data was found');
        }

        $rows = array_merge([
            '<tr><th>' . $this->getCollectionHeaders($collection)->join('</th><th>') . '</th></tr>',
        ], collect($collection)->map(function ($row) {
            return '<tr>' . implode('', array_map(function ($values) {
                return "<td>{$values}</td>";
            }, $row)) . '</tr>';
        })->all());

        return $this->render('<table>'.implode('', $rows).'</table>');
    }

    /**
     * Extract the headings from the collection.
     *
     * @param \Tightenco\Collect\Support\Collection $collection
     * @return \Tightenco\Collect\Support\Collection
     */
    protected function getCollectionHeaders(Collection $collection)
    {
        return collect($collection->first())->keys()->map(function($item) {
            return collect(explode('_', $item))->map(function($item) {
                return ucfirst($item);
            })->join(' ');
        });
    }

    /**
     * Render the content to a formatted HTML document.
     *
     * @param string $body
     * @return string
     */
    public function render($body)
    {
        $template = file_get_contents(__DIR__.'/../../resources/views/report.html');
        $template = str_replace('{{ BODY }}', $body, $template);
        return $template;
    }
}
