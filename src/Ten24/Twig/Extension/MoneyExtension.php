<?php

namespace Ten24\Twig\Extension;

use Ten24\Component\Formatter\MoneyFormatter;

/**
 * Class MoneyExtension
 *
 * @package Ten24\Twig\Extension
 */
class MoneyExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('centsToDollars', [$this, 'centsToDollars']),
            new \Twig_SimpleFilter('centsToDollarsLocalized', [$this, 'centsToDollarsLocalized']),
        ];
    }

    /**
     * @param $cents
     *
     * @return float
     */
    public function centsToDollars($cents)
    {
        return number_format(MoneyFormatter::centsToDollars($cents), 2);
    }

    /**
     * @param string|int $cents
     *
     * @return string
     */
    public function centsToDollarsLocalized($cents)
    {
        return MoneyFormatter::centsToDollars($cents);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ten24_twig.money';
    }
}