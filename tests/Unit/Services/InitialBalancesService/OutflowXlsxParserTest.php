<?php

declare(strict_types=1);

namespace Tests\Unit\Services\InitialBalancesService;

use App\Services\InitialBalancesService\Data\OutflowData;
use App\Services\InitialBalancesService\Data\OutflowDetailsData;
use App\Services\InitialBalancesService\Exceptions\FileParsingException;
use App\Services\InitialBalancesService\OutflowXlsxParser;
use Tests\TestCase;
use Tests\Traits\TestStorage;

class OutflowXlsxParserTest extends TestCase
{
    use TestStorage;

    protected OutflowXlsxParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->initTestDisk();
        $this->parser = app(OutflowXlsxParser::class);
    }

    public function testUploadEmptyFile()
    {
        $this->assertThrows(
            fn () => $this->parser->parse(''),
            FileParsingException::class
        );
    }

    public function testUploadOutflows()
    {
        $file = $this->testDisk->get('InitialBalancesService/outflow.xlsx');
        $result = $this->parser->parse($file);

        $this->assertEquals(collect([
            OutflowData::from([
                'date' => '30.04.2017 23:59:59',
                'sum' => 528.52,
                'costItemName' => 'Дом',
                'details' => [
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: Электроэнергия',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 528.52,
                        'comment' => null,
                    ])
                ],
            ]),
            OutflowData::from([
                'date' => '30.04.2017 23:59:59',
                'sum' => 802.69,
                'costItemName' => 'Дом',
                'details' => [
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: Газ',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 802.69,
                        'comment' => null,
                    ])
                ],
            ]),
            OutflowData::from([
                'date' => '30.04.2017 23:59:59',
                'sum' => 3829.92,
                'costItemName' => 'Дом',
                'details' => [
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: ХВС',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 720.6,
                        'comment' => null,
                    ]),
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: Водоотведение',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 429.85,
                        'comment' => null,
                    ]),
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: Отопление',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 1362.09,
                        'comment' => null,
                    ]),
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: Ремонт',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 552.77,
                        'comment' => null,
                    ]),
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'ЖКХ: Содержание жилья',
                        'nomenclatureType' => 'ЖКХ',
                        'count' => 1,
                        'cost' => 764.61,
                        'comment' => null,
                    ]),
                ],
            ]),
            OutflowData::from([
                'date' => '08.05.2017 15:42:26',
                'sum' => 740.50,
                'costItemName' => 'Дом',
                'details' => [
                    OutflowDetailsData::from([
                        'nomenclatureName' => 'Продукты',
                        'nomenclatureType' => 'Продукты',
                        'count' => 1,
                        'cost' => 740.50,
                        'comment' => null,
                    ])
                ],
            ])
        ]), $result);
    }
}
