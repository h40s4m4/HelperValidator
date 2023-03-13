<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\NormalizerTests;

use ArtekSoft\HelperValidator\Normalizers\FromStringNormalizer;
use ArtekSoft\HelperValidator\Tests\DataProvider\DataProviderForTestTrait;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FromStringNormalizerTest extends TestCase
{
    use DataProviderForTestTrait;

    /**
     * @param mixed $testVariable
     * @param int   $testExpectedResult
     *
     * @return void
     *
     * @dataProvider getIntFromStringProvider
     */
    public function testGetIntFromString(mixed $testVariable, int $testExpectedResult): void
    {
        $result = FromStringNormalizer::getIntFromString($testVariable);
        $this->assertEquals($testExpectedResult, $result);
    }

    /**
     * @param mixed $testVariable
     *
     * @return void
     *
     * @dataProvider getIntFromStringExceptionProvider
     */
    public function testGetIntFromStringException(mixed $testVariable): void
    {
        $this->expectException(InvalidArgumentException::class);
        FromStringNormalizer::getIntFromString($testVariable);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for String converter.
     *
     * @return array
     */
    public function getIntFromStringProvider(): array
    {
        return [
            'string_int_normal'     => ['test_variable' => '1', 'test_expected_result' => 1],
            'string_int_zero'       => ['test_variable' => '0', 'test_expected_result' => 0],
            'string_int_negative'   => ['test_variable' => '-1', 'test_expected_result' => -1],
            'string_float_zero'     => ['test_variable' => '0.0', 'test_expected_result' => 0],
            'string_float_positive' => ['test_variable' => '1.1', 'test_expected_result' => 1],
            'string_float_negative' => ['test_variable' => '-1.1', 'test_expected_result' => -1],
        ];
    }

    /**
     * Data for String converter.
     *
     * @return array
     */
    public function getIntFromStringExceptionProvider(): array
    {
        $data = self::generalDataForTest();
        unset(
            $data['string_int_normal'],
            $data['string_int_zero'],
            $data['string_int_negative'],
            $data['string_float_zero'],
            $data['string_float_positive'],
            $data['string_float_negative'],
        );

        return $data;
    }
}