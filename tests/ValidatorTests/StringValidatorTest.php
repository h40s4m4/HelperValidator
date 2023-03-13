<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\ValidatorTests;

use ArtekSoft\HelperValidator\Tests\DataProvider\DataProviderForTestTrait;
use ArtekSoft\HelperValidator\Validators\StringValidator;
use PHPUnit\Framework\TestCase;

final class StringValidatorTest extends TestCase
{
    use DataProviderForTestTrait;

    /**
     * @param mixed $testVariable
     * @param bool  $testExpectedResult
     *
     * @return void
     *
     * @dataProvider checkIsStringProvider
     */
    public function testCheckIsStringNonEmpty(mixed $testVariable, bool $testExpectedResult): void
    {
        $result = StringValidator::checkIsStringNonEmpty($testVariable);
        $this->assertSame($testExpectedResult, $result);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for string test, all strings are valid, others things aren't valid.
     *
     * @return array
     */
    public function checkIsStringProvider(): array
    {
        $data = self::generalDataForTest();

        // Numeric Values.
        $data['string_int_normal']['test_expected_result']   = TRUE;
        $data['string_int_zero']['test_expected_result']     = TRUE;
        $data['string_int_negative']['test_expected_result'] = TRUE;

        // Float Values (Chilean System).
        $data['string_float_zero']['test_expected_result']     = TRUE;
        $data['string_float_positive']['test_expected_result'] = TRUE;
        $data['string_float_negative']['test_expected_result'] = TRUE;

        // Strings.
        $data['string']['test_expected_result'] = TRUE;

        return $data;
    }
}