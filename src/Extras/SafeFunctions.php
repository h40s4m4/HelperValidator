<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Extras;

use ArtekSoft\HelperValidator\Validators\StringValidator;
use InvalidArgumentException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Safe\Exceptions\PcreException as SafePcreException;

use function Safe\json_encode as safe_json_encode;
use function Safe\preg_match as safe_preg_match;
use function sprintf;

final class SafeFunctions
{
    /**
     * Execute the preg_match function in safe mode.
     *
     * @param mixed $valueString
     * @param mixed $regularExpression
     *
     * @return int
     *
     * @throws InvalidArgumentException In case of the preg_match function throws error.
     */
    public static function safePregMatch(mixed $valueString, mixed $regularExpression): int
    {
        // Check value and regular expression are valid String.
        StringValidator::checkIsStringNonEmpty($valueString, TRUE);
        StringValidator::checkIsStringNonEmpty($regularExpression, TRUE);

        try {
            $evaluatedValue = safe_preg_match($regularExpression, $valueString);
        } catch (SafePcreException $e) {
            throw new InvalidArgumentException(
                sprintf('Error en la evaluación de expresión regular: %s', $e->getMessage()),
            );
        }

        return $evaluatedValue;
    }

    /**
     * Execute the json_encode function in safe mode.
     *
     * @param string $valueString
     *
     * @return string
     *
     * @throws InvalidArgumentException In case of the json_encode function throws error.
     */
    public static function safeJsonEncode(string $valueString): string
    {
        // Check value are valid String.
        StringValidator::checkIsStringNonEmpty($valueString, TRUE);

        try {
            $jsonValueString = safe_json_encode($valueString);
        } catch (SafeJsonException $e) {
            throw new InvalidArgumentException(
                sprintf('Error al ejecutar JsonEncode: %s', $e->getMessage()),
            );
        }

        return $jsonValueString;
    }
}