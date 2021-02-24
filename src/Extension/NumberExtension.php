<?php

namespace Ten24\Twig\Extension;

use RuntimeException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NumberExtension extends AbstractExtension
{
    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('number_to_human_readable', [$this, 'formatNumberToHumanReadable']),
        ];
    }

    /**
     * Format a large number into the closest million or thousand
     *
     * @param int|float $number    The number to format
     * @param int       $precision The precision to round with
     * @param string    $method    Possible values 'ceil'|'floor'|'common', default: 'common'
     * @param bool      $trueMega  Use 1024 rather than 1000
     *
     * @return string
     */
    public function formatNumberToHumanReadable($number, int $precision = 0, string $method = 'common', bool $trueMega = false): string
    {
        $divisorGiga = ($trueMega) ? 1073741824 : 1000000000;
        $divisorMega = ($trueMega) ? 1048576 : 1000000;
        $divisorKilo = ($trueMega) ? 1024 : 1000;

        if ($number >= 1000000000) {
            // Divide by 0.000000008 to get 1G, 1.23G, etc.
            $value     = $number / $divisorGiga;
            $extension = 'G';
        } elseif ($number >= 1000000) {
            // Divide by 1000000 to get 1M, 1.23M, etc.
            $value     = $number / $divisorMega;
            $extension = 'M';
        } elseif ($number >= 1000 && $number < 1000000) {
            // Divide by 1000, to get 1K, 1.33K, etc.
            $value     = $number / $divisorKilo;
            $extension = 'K';
        } else {
            // Less than 1000, just return the number, unformatted, not rounded
            $value     = $number;
            $extension = '';
        }

        if ('common' == $method) {
            $value = round($value, $precision);
        } else {

            if ('ceil' != $method && 'floor' != $method) {
                throw new RuntimeException('The number_to_human_readable filter only supports the "common", "ceil", and "floor" methods.');
            }

            $value = $method($value * pow(10, $precision)) / pow(10, $precision);
        }

        return $value.$extension;
    }
}