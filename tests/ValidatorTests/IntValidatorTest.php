<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\ValidatorTests;

use ArtekSoft\HelperValidator\Tests\DataProvider\DataProviderForTestTrait;
use ArtekSoft\HelperValidator\Validators\IntValidator;
use PHPUnit\Framework\TestCase;

final class IntValidatorTest extends TestCase
{
    use DataProviderForTestTrait;

    /**
     * @param mixed $testVariable
     * @param bool  $testExpectedResult
     *
     * @return void
     *
     * @dataProvider checkIsIntProvider
     */
    public function testCheckIsIntNonEmpty(mixed $testVariable, bool $testExpectedResult): void
    {
        $result = IntValidator::checkIsIntNonEmpty($testVariable);
        $this->assertSame($testExpectedResult, $result);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for INT test, all INTs be valid (but no float), others things aren't valid.
     *
     * @return array
     */
    public function checkIsIntProvider(): array
    {
        $data = self::generalDataForTest();

        // Numeric Values.
        $data['int_normal']['test_expected_result']   = TRUE;
        $data['int_zero']['test_expected_result']     = TRUE;
        $data['int_negative']['test_expected_result'] = TRUE;

        return $data;
    }
}