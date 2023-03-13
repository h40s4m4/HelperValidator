<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Normalizers;

use ArtekSoft\HelperValidator\Validators\StringValidator;
use InvalidArgumentException;

use function is_numeric;
use function sprintf;

final class FromStringNormalizer
{
    /**
     * Extract an INT value from a String.
     *
     * OBS: Float values inside String change to INT value.
     *
     * @param mixed $stringWithInt
     *
     * @return int
     *
     * @throws InvalidArgumentException If the String doesn't have numeric transformation.
     */
    public static function getIntFromString(mixed $stringWithInt): int
    {
        StringValidator::checkIsStringNonEmpty($stringWithInt, TRUE);

        if (! is_numeric($stringWithInt)) {
            throw new InvalidArgumentException(sprintf('El string [%s] no contiene un INT para su conversión', $stringWithInt));
        }

        return (int)$stringWithInt;
    }
}