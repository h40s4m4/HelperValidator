<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Symfony;

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
}