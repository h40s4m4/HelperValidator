<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\ExtrasTest;

use ArtekSoft\HelperValidator\Extras\SafeFunctions;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class SafeFunctionsTest extends TestCase
{
    private const RUT_REGULAR_EXPRESSION = '/^[0-9]{8,9}[-|‐]{1}[0-9kK]{1}$/';

    /**
     * @param mixed $testValueString
     * @param mixed $testRegularExpression
     * @param mixed $testExpectedResult
     *
     * @return void
     *
     * @dataProvider safePregMatchProvider
     */
    public function testSafePregMatch(mixed $testValueString, mixed $testRegularExpression, mixed $testExpectedResult): void
    {
        $result = SafeFunctions::safeBasicPregMatch($testValueString, $testRegularExpression);
        $this->assertSame($testExpectedResult, $result);
    }

    /**
     * @param mixed $testValueString
     * @param mixed $testRegularExpression
     *
     * @return void
     *
     * @dataProvider safePregMatchExceptionsProvider
     */
    public function testSafePregMatchExceptions(mixed $testValueString, mixed $testRegularExpression): void
    {
        $this->expectException(InvalidArgumentException::class);
        SafeFunctions::safeBasicPregMatch($testValueString, $testRegularExpression);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for SafePregMatch test.
     *
     * @return array
     */
    public function safePregMatchProvider(): array
    {
        return [
            'normal_rut'    => ['test_value_string' => '17168421-8', 'test_regular_expression' => self::RUT_REGULAR_EXPRESSION, 'test_expected_result' => TRUE],
            'normal_string' => ['test_value_string' => '123', 'test_regular_expression' => self::RUT_REGULAR_EXPRESSION, 'test_expected_result' => FALSE],
        ];
    }

    /**
     * Data for SafePregMatch test, but used to throw exceptions.
     *
     * @return array
     */
    public function safePregMatchExceptionsProvider(): array
    {
        return [
            'error1' => ['test_value_string' => NULL, 'test_regular_expression' => NULL],
            'error2' => ['test_value_string' => 'a', 'test_regular_expression' => NULL],
            'error3' => ['test_value_string' => NULL, 'test_regular_expression' => 'a'],
        ];
    }
}