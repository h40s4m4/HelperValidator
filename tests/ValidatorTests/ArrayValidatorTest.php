<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\ValidatorTests;

use ArtekSoft\HelperValidator\Tests\DataProvider\DataProviderForTestTrait;
use ArtekSoft\HelperValidator\Validators\ArrayValidator;
use PHPUnit\Framework\TestCase;

final class ArrayValidatorTest extends TestCase
{
    use DataProviderForTestTrait;

    /**
     * @param mixed $testVariable
     * @param bool  $testExpectedResult
     *
     * @return void
     *
     * @dataProvider checkIsArrayProvider
     */
    public function testCheckIsArray(mixed $testVariable, bool $testExpectedResult): void
    {
        $result = ArrayValidator::checkIsArray($testVariable);
        $this->assertSame($testExpectedResult, $result);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for array test, all arrays be valid, others things aren't valid.
     *
     * @return array
     */
    public function checkIsArrayProvider(): array
    {
        $data = self::generalDataForTest();

        $data['array_empty']['test_expected_result']                     = TRUE;
        $data['array_null']['test_expected_result']                      = TRUE;
        $data['array_string']['test_expected_result']                    = TRUE;
        $data['array_int']['test_expected_result']                       = TRUE;
        $data['array_associative_null_string']['test_expected_result']   = TRUE;
        $data['array_associative_string_null']['test_expected_result']   = TRUE;
        $data['array_associative_int_null']['test_expected_result']      = TRUE;
        $data['array_associative_null_int']['test_expected_result']      = TRUE;
        $data['array_associative_null_null']['test_expected_result']     = TRUE;
        $data['array_associative_string_string']['test_expected_result'] = TRUE;
        $data['array_associative_string_int']['test_expected_result']    = TRUE;
        $data['array_associative_int_string']['test_expected_result']    = TRUE;
        $data['array_associative_int_int']['test_expected_result']       = TRUE;

        return $data;
    }
}