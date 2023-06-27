<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Validators;

use ArtekSoft\HelperValidator\Extras\SafeFunctions;
use InvalidArgumentException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as WebmozartException;

use function Safe\json_encode as safe_json_encode;
use function sprintf;

final class StringValidator
{
    /**
     * Checks if the provided value is a STRING and is not EMPTY. The $value field supports any value type.
     *
     * IF it is a valid STRING, returns TRUE.
     * It is NOT a valid STRING or is EMPTY, returns FALSE.
     *
     * @param mixed $value
     * @param bool  $hardException
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case $value is not a valid STRING or is NOT EMPTY and the flag $hardException = true.
     */
    public static function checkIsStringNonEmpty(mixed $value, bool $hardException = FALSE): bool
    {
        $isString = TRUE;
        try {
            Assert::stringNotEmpty($value, sprintf('El campo [%s] se encuentra vacío o no es un string válido', safe_json_encode($value)));
        } catch (WebmozartException|SafeJsonException $e) {
            if (TRUE === $hardException) {
                throw new InvalidArgumentException($e->getMessage());
            }

            $isString = FALSE;
        }

        return $isString;
    }

    /**
     * Checks if the provided String matches the regular expression. If there is at least one match, it returns TRUE, otherwise it returns FALSE.
     *
     * @param string $value
     * @param string $regularExpression
     * @param bool   $hardException
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case $value is not a valid STRING or is NOT EMPTY and the flag $hardException = true.
     */
    public static function checkRegularExpressionInString(mixed $value, mixed $regularExpression, bool $hardException = FALSE): bool
    {
        $returnBoolean = FALSE;
        if (0 < SafeFunctions::safePregMatch($value, $regularExpression)) {
            $returnBoolean = TRUE;
        }

        if (FALSE === $returnBoolean && TRUE === $hardException) {
            throw new InvalidArgumentException('Error');
        }

        return $returnBoolean;
    }
}