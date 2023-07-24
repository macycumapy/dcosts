<?php

declare(strict_types=1);

namespace Tests\Unit\Services\InitialBalancesService;

use App\Services\InitialBalancesService\Data\InflowData;
use App\Services\InitialBalancesService\Exceptions\FileParsingException;
use App\Services\InitialBalancesService\InflowsXlsxParser;
use Tests\TestCase;
use Tests\Traits\TestStorage;

class InflowXlsxParserTest extends TestCase
{
    use TestStorage;

    protected InflowsXlsxParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->initTestDisk();
        $this->parser = app(InflowsXlsxParser::class);
    }

    public function testUploadEmptyFile()
    {
        $this->assertThrows(
            fn () => $this->parser->parse(''),
            FileParsingException::class
        );
    }

    public function testUploadInflows()
    {
        $file = $this->testDisk->get('InitialBalancesService/inflow.xlsx');
        $result = $this->parser->parse($file);

        $this->assertEquals(collect([
            InflowData::from([
                'date' => '25.04.2011 12:00',
                'sum' => 1000,
                'costItemName' => 'Зарплата',
                'partnerName' => 'Экспобанк',
            ]),
            InflowData::from([
                'date' => '25.04.2012',
                'sum' => 1000,
                'costItemName' => 'Зарплата',
                'partnerName' => 'Экспобанк',
            ]),
            InflowData::from([
                'date' => '25.04.2011',
                'sum' => 1000,
                'costItemName' => 'Кэшбэк',
                'partnerName' => 'Тинькофф',
            ])
        ]), $result);
    }
}
