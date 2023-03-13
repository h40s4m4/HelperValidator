<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Normalizers;

use ArtekSoft\HelperValidator\Validators\StringValidator;
use DateTimeInterface;
use InvalidArgumentException;
use Safe\DateTime;
use Safe\Exceptions\DatetimeException;

use function sprintf;

final class DateNormalizer
{
    /**
     * Converts a string to a DateTime object.
     *
     * By default, it is created using the Y-m-d format, but you can optionally change the format.
     *
     * This normalizer throws Exception if find an error.
     *
     * @param mixed  $stringDate
     * @param string $format
     *
     * @return DateTimeInterface
     *
     * @throws InvalidArgumentException In case $stringDate is not a valid STRING or is EMPTY.
     * @throws InvalidArgumentException In case the date is not convertible.
     * @throws InvalidArgumentException In case the date is null.
     * @throws InvalidArgumentException In case the date input date is different of datetime format date.
     */
    public static function dateStringToDateTimeInterface(mixed $stringDate, string $format = 'Y-m-d'): DateTimeInterface
    {
        // Throws exception if the string is null or is not a String.
        StringValidator::checkIsStringNonEmpty($stringDate, TRUE);

        // Create valid Datetime Object.
        try {
            $datetimeValue = Datetime::createFromFormat($format, $stringDate);
        } catch (DatetimeException $e) {
            throw new InvalidArgumentException(
                sprintf(
                    'El string [%s], para el formato formato [%s] no es válido como una fecha, con el error: %s',
                    $stringDate,
                    $format,
                    $e->getMessage(),
                ),
            );
        }

        // Validate if the In and out date is the same, this is for date like 29-02-1989.
        if ($datetimeValue->format($format) !== $stringDate) {
            throw new InvalidArgumentException(sprintf('La fecha entregada [%s] no es una fecha válida', $stringDate));
        }

        return $datetimeValue;
    }
}