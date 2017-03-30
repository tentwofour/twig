<?php

namespace Ten24\Twig\Extension;

use Ten24\Component\Inflector\Inflector;

class InflectorExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('camelcase_to_capitalized_words', [$this, 'camelCaseToCapitalizedWords']),
            new \Twig_SimpleFilter('camelcase_to_sentence_case_words', [$this, 'camelCaseToSentenceCasedWords']),
            new \Twig_SimpleFilter('camelcase_to_lower_case_words', [$this, 'camelCaseToLowerCasedWords']),
        ];
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function camelCaseToCapitalizedWords($string)
    {
        return Inflector::camelCaseToCapitalizedWords($string);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function camelCaseToSentenceCasedWords($string)
    {
        return Inflector::camelCaseToSentenceCaseWords($string);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function camelCaseToLowerCasedWords($string)
    {
        return Inflector::camelCaseToLowerCaseWords($string);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ten24_twig.inflector';
    }
}