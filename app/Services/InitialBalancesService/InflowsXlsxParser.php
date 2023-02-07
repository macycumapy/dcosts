<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService;

use App\Services\InitialBalancesService\DTO\InflowDTO;
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

        return collect($rows)->map(fn ($row) => InflowDTO::make([
            'date' => $row[0],
            'sum' => $row[1],
            'costItemName' => $row[2],
            'partnerName' => $row[3],
        ]));
    }
}
