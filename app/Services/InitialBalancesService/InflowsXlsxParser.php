<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService;

use App\Services\InitialBalancesService\Data\InflowData;
use App\Services\InitialBalancesService\Exceptions\FileParsingException;
use Illuminate\Support\Collection;
use Shuchkin\SimpleXLSX;

class InflowsXlsxParser
{
    public function parse(string $fileData): Collection
    {
        $xlsx = SimpleXLSX::parseData($fileData);
        if (!$xlsx) {
            throw new FileParsingException();
        }

        $rows = $xlsx->rows();
        array_shift($rows);

        return collect($rows)->map(fn ($row) => InflowData::from([
            'date' => $row[0],
            'sum' => $row[1],
            'categoryName' => $row[2],
            'partnerName' => $row[3],
        ]));
    }
}
