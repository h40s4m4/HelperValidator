<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Validators;

use InvalidArgumentException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as WebmozartException;

use function Safe\json_encode as safe_json_encode;
use function sprintf;

final class StringValidator
{

    private const STRING_NON_EMPTY_EXCEPTION_MESSAGE = 'El campo [%s] se encuentra vacío o no es un string válido';

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
            Assert::stringNotEmpty($value, sprintf(self::STRING_NON_EMPTY_EXCEPTION_MESSAGE, safe_json_encode($value)));
        } catch (WebmozartException|SafeJsonException $e) {
            if (TRUE === $hardException) {
                throw new InvalidArgumentException($e->getMessage());
            }

            $isString = FALSE;
        }

        return $isString;
    }
}