<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Symfony;

use ArtekSoft\HelperValidator\Validators\ArrayValidator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

use function sprintf;

final class SymfonyRequestHelperService
{
    /**
     * Fetch an element from the request post based on the supplied KEY. If the KEY does not exist, it returns NULL.
     *
     * @param Request $request
     * @param string  $key
     * @param bool    $hardException
     *
     * @return string|int|bool|float|null
     *
     * @throws InvalidArgumentException In case the value of the request does NOT have the KEY and the flag $hardException = true.
     */
    public static function getElementFromPostRequest(Request $request, string $key, bool $hardException = FALSE): string|int|bool|float|null
    {
        if ($request->request->has($key)) {
            return $request->request->get($key);
        }

        if (TRUE === $hardException) {
            throw new InvalidArgumentException(
                sprintf('El campo [%s] no se encuentra definido dentro del Request', $key),
            );
        }

        return NULL;
    }

    /**
     * Gets an element from the request based on the KEY.
     * The Elements come from the DATA field of the request (if DATA does not come within the request, it will always throw an exception).
     * If the KEY does not exist, it returns NULL.
     *
     * @param Request $request
     * @param string  $key
     * @param bool    $hardException
     *
     * @return string|int|bool|float|null
     *
     * @throws InvalidArgumentException In case the value of the request does NOT have the KEY and the flag $hardException = true.
     */
    public static function getElementFromPostRequestByData(Request $request, string $key, bool $hardException = FALSE): string|int|bool|float|null
    {
        // Check 'data' value.
        if (! $request->request->has('data')) {
            throw new InvalidArgumentException('Data no se encuentra definido dentro del Request');
        }

        // Check key in arrayData, and return if exists.
        $dataArray = $request->get('data');
        if (ArrayValidator::checkIfKeyExists($dataArray, $key)) {
            return $dataArray[$key];
        }

        if (TRUE === $hardException) {
            throw new InvalidArgumentException(
                sprintf('El campo [%s] no se encuentra definido dentro del Request', $key),
            );
        }

        return NULL;
    }
}