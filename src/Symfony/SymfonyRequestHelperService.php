<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Symfony;

use ArtekSoft\HelperValidator\Validators\ArrayValidator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

use function sprintf;

final class SymfonyRequestHelperService
{
    private const GET_POST_REQUEST_MESSAGE = 'El campo [%s] no se encuentra definido dentro del Request';

    /**
     * Gets an element from the request (based on POST) with the specified KEY. If the KEY does not exist, it returns NULL.
     *
     * @param Request $request
     * @param string  $key
     * @param bool    $hardException
     *
     * @return string|int|bool|float|array|null
     *
     * @throws InvalidArgumentException In case the value of the request does NOT have the KEY and the flag $hardException = true.
     */
    public static function getFromPostRequest(Request $request, string $key, bool $hardException = FALSE): string|int|bool|float|array|null
    {
        if ($request->request->has($key)) {
            return $request->request->get($key);
        }

        if (TRUE === $hardException) {
            throw new InvalidArgumentException(sprintf(self::GET_POST_REQUEST_MESSAGE, $key));
        }

        return NULL;
    }

    /**
     * Gets an element from the request (based on POST) with the specified KEY.
     * The Elements come from the DATA field of the request (if DATA doesn't come in the request, it will always throw an exception).
     * If the KEY does not exist, it returns NULL.
     *
     * @param Request $request
     * @param string  $key
     * @param bool    $hardException
     *
     * @return string|int|bool|float|array|null
     *
     * @throws InvalidArgumentException In case the value of the request doesn't contains 'data'.
     * @throws InvalidArgumentException In case the value of the request does NOT have the KEY and the flag $hardException = true.
     */
    public static function getFromPostRequestByData(Request $request, string $key, bool $hardException = FALSE): string|int|bool|float|array|null
    {
        $dataArray = self::getFromPostRequest($request, 'data', TRUE);
        if (ArrayValidator::checkIfKeyExists($dataArray, $key)) {
            return $dataArray[$key];
        }

        if (TRUE === $hardException) {
            throw new InvalidArgumentException(sprintf(self::GET_POST_REQUEST_MESSAGE, $key));
        }

        return NULL;
    }
}