<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Validators;

use InvalidArgumentException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as WebmozartException;

use function Safe\json_encode as safe_json_encode;
use function sprintf;

final class FloatValidator
{
    private const FLOAT_NON_EMPTY_EXCEPTION_MESSAGE = 'El campo [%s] se encuentra vacío o no es un FLOAT válido';

    /**
     * Checks if the provided value is a FLOAT and is not EMPTY. The $value field supports any value type.
     *
     * IF it is a valid FLOAT, it returns TRUE.
     * It is NOT a valid FLOAT or is EMPTY, it returns FALSE.
     *
     * @param mixed|null $value
     * @param bool       $hardException
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case $value is not a valid FLOAT or is NOT EMPTY and the flag $hardException = true.
     */
    public static function checkIsFloatNonEmpty(mixed $value, bool $hardException = FALSE): bool
    {
        $isFloat = TRUE;
        try {
            Assert::float($value, sprintf(self::FLOAT_NON_EMPTY_EXCEPTION_MESSAGE, safe_json_encode($value)));
        } catch (WebmozartException|SafeJsonException $e) {
            if (TRUE === $hardException) {
                throw new InvalidArgumentException($e->getMessage());
            }

            $isFloat = FALSE;
        }

        return $isFloat;
    }
}