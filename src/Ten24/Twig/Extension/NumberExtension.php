<?php

namespace Ten24\Twig\Extension;

class NumberExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('number_to_human_readable', [$this, 'formatNumberToHumanReadable']),
        ];
    }

    /**
     * Format a large number into the closest million or thousand
     *
     * @param int|float $number    The number to format
     * @param int       $precision The precision to round with
     * @param string    $method    Possible values 'ceil'|'floor'|'common', default: 'common'
     *
     * @return float
     */
    public function formatNumberToHumanReadable($number, $precision = 0, $method = 'common')
    {
        if ($number >= 1000000) {
            // Divide by 1000000 to get 1M, 1.23M, etc.
            $value     = $number / 1000000;
            $extension = 'M';
        } elseif ($number >= 1000 && $number < 1000000) {
            // Divide by 1000, to get 1K, 1.33K, etc.
            $value     = $number / 1000;
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
                throw new \RuntimeException('The number_to_human_readable filter only supports the "common", "ceil", and "floor" methods.');
            }

            $value = $method($value * pow(10, $precision)) / pow(10, $precision);
        }

        return $value.$extension;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ten24_twig.number';
    }
}