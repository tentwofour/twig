<?php

namespace Ten24\Twig\Extension;

use Ten24\Component\Inflector\Inflector;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class InflectorExtension extends AbstractExtension
{
    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('camelcase_to_capitalized_words', [$this, 'camelCaseToCapitalizedWords']),
            new TwigFilter('camelcase_to_sentence_case_words', [$this, 'camelCaseToSentenceCasedWords']),
            new TwigFilter('camelcase_to_lower_case_words', [$this, 'camelCaseToLowerCasedWords']),
        ];
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function camelCaseToCapitalizedWords($string): string
    {
        return Inflector::camelCaseToCapitalizedWords($string);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function camelCaseToSentenceCasedWords($string): string
    {
        return Inflector::camelCaseToSentenceCaseWords($string);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function camelCaseToLowerCasedWords($string): string
    {
        return Inflector::camelCaseToLowerCaseWords($string);
    }
}