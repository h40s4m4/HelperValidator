<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\ValidatorTests;

use ArtekSoft\HelperValidator\Tests\DataProvider\DataProviderForTestTrait;
use ArtekSoft\HelperValidator\Validators\FloatValidator;
use PHPUnit\Framework\TestCase;

final class FloatValidatorTest extends TestCase
{
    use DataProviderForTestTrait;

    /**
     * @param mixed $testVariable
     * @param bool  $testExpectedResult
     *
     * @return void
     *
     * @dataProvider checkIsFloatProvider
     */
    public function testCheckIsFloatNonEmpty(mixed $testVariable, bool $testExpectedResult): void
    {
        $result = FloatValidator::checkIsFloatNonEmpty($testVariable);
        $this->assertSame($testExpectedResult, $result);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for float test, all floats be valid (but no INT), others things aren't valid.
     *
     * @return array
     */
    public function checkIsFloatProvider(): array
    {
        $data = self::generalDataForTest();

        $data['float_zero']['test_expected_result']     = TRUE;
        $data['float_positive']['test_expected_result'] = TRUE;
        $data['float_negative']['test_expected_result'] = TRUE;

        return $data;
    }
}