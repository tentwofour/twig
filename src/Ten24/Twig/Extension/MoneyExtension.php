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
            new \Twig_SimpleFilter('cents_to_dollars', [$this, 'centsToDollars']),
        ];
    }

    /**
     * @param $cents
     *
     * @return float
     */
    public function centsToDollars($cents)
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