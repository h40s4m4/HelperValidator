<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Extras;

use InvalidArgumentException;
use Safe\DateTime as SafeDateTime;
use Safe\Exceptions\DatetimeException as SafeDateTimeException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Safe\Exceptions\PcreException as SafePcreException;

use function Safe\json_encode as safe_json_encode;
use function Safe\preg_match as safe_preg_match;
use function sprintf;

/**
 * Use thecodingmachine/safe functions.
 * A set of core PHP functions rewritten to throw exceptions instead of returning false when an error is encountered.
 */
final class SafeFunctions
{
    private const SAFE_PREG_MATCH_MESSAGE       = 'Error en la evaluación de expresión regular: %s';
    private const SAFE_JSON_ENCODE_MESSAGE      = 'Error al ejecutar JsonEncode: %s';
    private const SAFE_DATE_FROM_FORMAT_MESSAGE = 'El string [%s], para el formato formato [%s] no es válido como una fecha, con el error: %s';

    /**
     * Execute the preg_match function in safe mode. It's assumed that the input values are valid and correct.
     * Returns:
     *      - If valid, return TRUE.
     *      - If NOT valid, return false.
     *
     *
     * @param string $valueString
     * @param string $regularExpression
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case of the preg_match function throws error.
     */
    public static function safeBasicPregMatch(string $valueString, string $regularExpression): bool
    {
        try {
            $evaluatedValue = safe_preg_match($regularExpression, $valueString);
        } catch (SafePcreException $e) {
            throw new InvalidArgumentException(
                sprintf(self::SAFE_PREG_MATCH_MESSAGE, $e->getMessage()),
            );
        }

        return $evaluatedValue === 1;
    }

    /**
     * Execute the json_encode function in safe mode. It's assumed that the input values are valid and correct.
     *
     * @param string $valueString
     *
     * @return string
     *
     * @throws InvalidArgumentException In case of the json_encode function throws error.
     */
    public static function safeJsonEncode(string $valueString): string
    {
        try {
            $jsonValueString = safe_json_encode($valueString);
        } catch (SafeJsonException $e) {
            throw new InvalidArgumentException(
                sprintf(self::SAFE_JSON_ENCODE_MESSAGE, $e->getMessage()),
            );
        }

        return $jsonValueString;
    }

    /**
     * Execute the createFromFormat of DateTime in safe mode. It's assumed that the input values are valid and correct.
     *
     * @param string $stringDate
     * @param string $format
     *
     * @return SafeDateTime
     *
     * @throws InvalidArgumentException In case of the json_encode function throws error.
     */
    public static function safeDateFromFormat(string $stringDate, string $format): SafeDateTime
    {
        try {
            $dateTimeValue = SafeDateTime::createFromFormat($format, $stringDate);
        } catch (SafeDateTimeException $e) {
            throw new InvalidArgumentException(
                sprintf(
                    self::SAFE_DATE_FROM_FORMAT_MESSAGE,
                    $stringDate,
                    $format,
                    $e->getMessage(),
                ),
            );
        }

        return $dateTimeValue;
    }
}