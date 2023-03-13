<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Validators;

use InvalidArgumentException;
use Safe\Exceptions\JsonException as SafeJsonException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as WebmozartException;

use function Safe\json_encode as safe_json_encode;
use function sprintf;

final class IntValidator
{
    /**
     * Checks if the delivered value is an INT and is not EMPTY. The $value field supports any value type.
     *
     * IF it is a valid INT, it returns TRUE.
     * It is NOT a valid INT or is EMPTY, it returns FALSE.
     *
     * @param mixed|null $value
     * @param bool       $hardException
     *
     * @return bool
     *
     * @throws InvalidArgumentException In case $value is not a valid INT or is NOT EMPTY and the flag $hardException = true.
     */
    public static function checkIsIntNonEmpty(mixed $value, bool $hardException = FALSE): bool
    {
        $isInt = TRUE;
        try {
            Assert::integer($value, sprintf('El campo [%s] se encuentra vacío o no es un INT válido', safe_json_encode($value)));
        } catch (WebmozartException|SafeJsonException $e) {
            if (TRUE === $hardException) {
                throw new InvalidArgumentException($e->getMessage());
            }

            $isInt = FALSE;
        }

        return $isInt;
    }
}