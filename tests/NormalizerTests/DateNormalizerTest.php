<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\NormalizerTests;

use ArtekSoft\HelperValidator\Normalizers\DateNormalizer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Safe\DateTime;
use Safe\Exceptions\DatetimeException;

final class DateNormalizerTest extends TestCase
{
    private const YMD_G = 'Y-m-d';
    private const YMD_S = 'Y/m/d';
    private const DMY_G = 'd-m-Y';
    private const DMY_S = 'd/m/Y';

    /**
     * @param mixed $testStringDate
     * @param mixed $testStringFormat
     * @param bool  $testExpectedResult
     *
     * @return void
     *
     * @dataProvider datesProviderCorrect
     */
    public function testDateStringToDateTimeInterface(mixed $testStringDate, mixed $testStringFormat, mixed $testExpectedResult): void
    {
        $result = DateNormalizer::dateStringToDateTimeInterface($testStringDate, $testStringFormat);
        $this->assertEquals($testExpectedResult, $result);
    }

    /**
     * @param mixed $testStringDate
     * @param mixed $testStringFormat
     *
     * @return void
     *
     * @dataProvider datesProviderIncorrect
     */
    public function testDateStringToDateTimeInterfaceIncorrect(mixed $testStringDate, mixed $testStringFormat): void
    {
        $this->expectException(InvalidArgumentException::class);
        DateNormalizer::dateStringToDateTimeInterface($testStringDate, $testStringFormat);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for DateStringToDateTimeInterface test.
     *
     * @return array
     *
     * @throws DatetimeException
     */
    private function datesProviderCorrect(): array
    {
        $testedCorrectDate = Datetime::createFromFormat('Y-m-d', '1989-03-28');

        return [
            // Correct dates.
            'Y-m-d_normal' => ['test_string_date' => '1989-03-28', 'test_string_format' => self::YMD_G, 'test_expected_result' => $testedCorrectDate],
            'Y/m/d_normal' => ['test_string_date' => '1989/03/28', 'test_string_format' => self::YMD_S, 'test_expected_result' => $testedCorrectDate],
            'd-m-Y_normal' => ['test_string_date' => '28-03-1989', 'test_string_format' => self::DMY_G, 'test_expected_result' => $testedCorrectDate],
            'd/m/Y_normal' => ['test_string_date' => '28/03/1989', 'test_string_format' => self::DMY_S, 'test_expected_result' => $testedCorrectDate],
        ];
    }

    /**
     * Data for DateStringToDateTimeInterface test, but used to throw exceptions.
     *
     * @return array
     */
    private function datesProviderIncorrect(): array
    {
        return [
            'null_error'                 => ['test_string_date' => NULL, 'test_string_format' => self::YMD_G],

            // Outbound date.
            'Y-m-d_error'                => ['test_string_date' => '1989-03-32', 'test_string_format' => self::YMD_G],
            'Y/m/d_error'                => ['test_string_date' => '1989/03/32', 'test_string_format' => self::YMD_S],
            'd-m-Y_error'                => ['test_string_date' => '32-03-1989', 'test_string_format' => self::DMY_G],
            'd/m/Y_error'                => ['test_string_date' => '32/03/1989', 'test_string_format' => self::DMY_S],

            // Letter.
            'Y-m-d_letter_error'         => ['test_string_date' => 'a1989-03-32', 'test_string_format' => self::YMD_G],
            'Y/m/d_letter_error'         => ['test_string_date' => 'a1989/03/32', 'test_string_format' => self::YMD_S],
            'd-m-Y_letter_error'         => ['test_string_date' => 'a32-03-1989', 'test_string_format' => self::DMY_G],
            'd/m/Y_letter_error'         => ['test_string_date' => 'a32/03/1989', 'test_string_format' => self::DMY_S],

            // Correct dates, incorrect format.
            'Y-m-d_normal_format_error'  => ['test_string_date' => '1989-03-28', 'test_string_format' => self::YMD_S],
            'Y/m/d_normal_format_error'  => ['test_string_date' => '1989/03/28', 'test_string_format' => self::YMD_G],
            'd-m-Y_normal_format_error'  => ['test_string_date' => '28-03-1989', 'test_string_format' => self::DMY_S],
            'd/m/Y_normal_format_error'  => ['test_string_date' => '28/03/1989', 'test_string_format' => self::DMY_G],

            // Correct dates, stupid format.
            'Y-m-d_normal_format_stupid' => ['test_string_date' => '1989-03-28', 'test_string_format' => 'abc'],
        ];
    }
}