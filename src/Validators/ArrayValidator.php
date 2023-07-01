<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Validators;

use InvalidArgumentException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as WebmozartException;

use function Safe\json_encode as safe_json_encode;
use function sprintf;

final class ArrayValidator
{
    /**
     * Checks if the delivered value is an ARRAY or not. The $value field supports any value type.
     *
     * IF it is a valid ARRAY, it returns TRUE.
     * It is NOT a valid ARRAY, it returns FALSE.
     *
     * @param mixed|null $value
     * @param bool       $hardException
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case $value is not a valid ARRAY and the flag $hardException = true.
     */
    public static function checkIsArray(mixed $value, bool $hardException = FALSE): bool
    {
        $isArray = TRUE;
        try {
            Assert::isArray($value, sprintf('El campo [%s] no es un Array', safe_json_encode($value)));
        } catch (WebmozartException|SafeJsonException $e) {
            if (TRUE === $hardException) {
                throw new InvalidArgumentException($e->getMessage());
            }

            $isArray = FALSE;
        }

        return $isArray;
    }

    /**
     * Checks if the provided KEY is in ARRAY.
     *
     * IF it exists KEY in ARRAY, it returns TRUE.
     * IF NOT it exists KEY in ARRAY, it returns FALSE.
     *
     * @param array  $array
     * @param string $keyName
     * @param bool   $hardException
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case $value is not a valid ARRAY and the flag $hardException = true.
     */
    public static function checkIfKeyExists(array $array, string $keyName, bool $hardException = FALSE): bool
    {
        $isValidKey = TRUE;
        try {
            Assert::keyExists($array, $keyName, sprintf('La llave [%s] no se encuentra dentro del Array', safe_json_encode($keyName)));
        } catch (WebmozartException|SafeJsonException $e) {
            if (TRUE === $hardException) {
                throw new InvalidArgumentException($e->getMessage());
            }

            $isValidKey = FALSE;
        }

        return $isValidKey;
    }
}