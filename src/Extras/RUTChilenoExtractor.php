<?php

declare(strict_types=1);

namespace ArtekSoft\HelperValidator\Extras;

use ArtekSoft\HelperValidator\Normalizers\FromStringNormalizer;
use ArtekSoft\HelperValidator\Validators\IntValidator;
use ArtekSoft\HelperValidator\Validators\StringValidator;
use InvalidArgumentException;

use function array_reverse;
use function sprintf;
use function str_replace;
use function str_split;
use function strlen;
use function strtolower;
use function substr;

final class RUTChilenoExtractor
{
    private const REGEX_FOR_RUT_DV = '/(^[-]{1}+[0-9kK]).{0}$/';

    /**
     * Return null if the provided Rut is invalid.
     *
     * @param string|null $rutCandidate
     *
     * @return string|null
     *
     * @throws InvalidArgumentException IF violate some rules.
     */
    public static function validateRut(string|null $rutCandidate): string|null
    {
        // Verify that it is not empty and that the string is larger than 3 characters (1-9).
        if (! StringValidator::checkIsStringNonEmpty($rutCandidate) || strlen($rutCandidate) <= 3) {
            throw new InvalidArgumentException('RUT vacío o con menos de 3 caracteres.');
        }

        // Valida que sólo sean números, excepto el último dígito que pueda ser kK.
        if (! SafeFunctions::safePregMatch($rutCandidate, '/^[0-9.]+[-]?+[0-9kK]{1}/')) {
            throw new InvalidArgumentException('Error al digitar el RUT.');
        }

        $numericPart = self::getNumericPartFromRut($rutCandidate);
        $dv          = self::getDigitoVerificadorFromRut($rutCandidate);


        $returnValue = NULL;
        if (self::validaRutRule((string)$numericPart, $dv)) {
            $returnValue = sprintf('%s-%s', $numericPart, $dv);
        }

        return $returnValue;
    }

    /**
     * Verifies that the rut delivered, without the hyphen and check digit, is valid.
     *
     * @param string $rutCandidate
     *
     * @return int
     *
     * @throws InvalidArgumentException IF violate some rules.
     */
    public static function getNumericPartFromRut(string $rutCandidate): int
    {
        $numericPartString = str_replace(substr($rutCandidate, -2, 2), '', $rutCandidate);
        $numericPartInt    = FromStringNormalizer::getIntFromString($numericPartString);

        if (FALSE === IntValidator::checkIsIntNonEmpty($numericPartInt)) {
            throw new InvalidArgumentException('La parte numérica del RUT sólo debe contener números.');
        }

        return $numericPartInt;
    }

    /**
     * Get DV of RUT. First, check if the DV includes a '-' sign, and then return only the DV number in INT format.
     *
     * @param string $rutCandidate
     *
     * @return string
     *
     * @throws InvalidArgumentException IF violate some rules.
     */
    public static function getDigitoVerificadorFromRut(string $rutCandidate): string
    {
        // Extracts the last two characters of the RUT.
        $guionYVerificador = substr($rutCandidate, -2, 2);

        // Check 2 characters max lenght.
        if (2 !== strlen($guionYVerificador)) {
            throw new InvalidArgumentException('Error en el largo del dígito verificador.');
        }

        // Force the check digit to be of the form -[0-9] or -[kK].
        if (! SafeFunctions::safePregMatch($guionYVerificador, self::REGEX_FOR_RUT_DV)) {
            throw new InvalidArgumentException('El dígito verificador no cuenta con el patrón requerido.');
        }

        return strtolower(substr($guionYVerificador, -1));
    }

    /**
     * Applies the generic algorithm for calculating rut and check digit.
     *
     * @param string $numericPart
     * @param string $dv
     *
     * @return bool
     */
    private static function validaRutRule(string $numericPart, string $dv): bool
    {
        $i    = 2;
        $suma = 0;

        foreach (array_reverse(str_split($numericPart)) as $v) {
            if (8 === $i) {
                $i = 2;
            }

            $suma += ($v * $i);
            ++$i;
        }

        $dvr = (11 - ($suma % 11));
        if (11 === $dvr) {
            $dvr = 0;
        }

        if (10 === $dvr) {
            $dvr = 'k';
        }

        $dvr = (string)$dvr;

        return $dvr === $dv;
    }
}