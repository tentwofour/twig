<?php

namespace Ten24\Twig\Extension;

use Ten24\Component\Formatter\MoneyFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class MoneyExtension
 *
 * @package Ten24\Twig\Extension
 */
class MoneyExtension extends AbstractExtension
{
    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('cents_to_dollars', [$this, 'centsToDollars']),
            new TwigFilter('dollars_to_cents', [$this, 'dollarsToCents']),
            new TwigFilter('cents_to_dollars_localized', [$this, 'centsToDollarsLocalized']),
        ];
    }

    /**
     * @param int $cents
     *
     * @return float
     */
    public function centsToDollars(int $cents): float
    {
        return MoneyFormatter::centsToDollars($cents);
    }

    /**
     * @param float $dollars
     *
     * @return int
     */
    public function dollarsToCents(float $dollars): int
    {
        return MoneyFormatter::dollarsToCents($dollars);
    }

    /**
     * @param        $cents
     * @param string $currency
     *
     * @return string
     */
    public function centsToDollarsLocalized($cents, string $currency = 'cad'): string
    {
        return \twig_localized_currency_filter(MoneyFormatter::centsToDollars($cents), $currency);
    }
}