<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Tests\NormalizerTests;

use ArtekSoft\HelperValidator\Normalizers\StringSpecialCharactersNormalizer;
use PHPUnit\Framework\TestCase;

final class StringSpecialCharactersNormalizerTest extends TestCase
{
    /**
     * @param mixed $testVariable
     * @param bool  $testExpectedResult
     *
     * @return void
     *
     * @dataProvider fixDegreeSignProvider
     */
    public function testFixDegreeSign(mixed $testVariable, mixed $testExpectedResult): void
    {
        $result = StringSpecialCharactersNormalizer::fixDegreeSign($testVariable);
        $this->assertSame($testExpectedResult, $result);
    }

    ###############################################################
    ######################## DATA PROVIDERS #######################
    ###############################################################

    /**
     * Data for degree test.
     *
     * @return array
     */
    public function fixDegreeSignProvider(): array
    {
        return [
            'normal_degree'            => ['°', 'test_expected_result' => '°'],
            'normal_degree_with_text'  => ['°test', 'test_expected_result' => '°test'],
            'ordinal_degree'           => ['º', 'test_expected_result' => '°'],
            'ordinal_degree_with_text' => ['ºtest', 'test_expected_result' => '°test'],
        ];
    }
}