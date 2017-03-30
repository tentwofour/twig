# Twig

A few Twig extensions

## EmailEncodingExtension

Provides a 'email_encode' filter, that encodes text into a random mix of ascii, hex, and plain characters. Pulled from the SF1 libraries.

### email_encode(\<string\> text)

```php
$ex = new EmailEncodingExtension()
$ex->filter('f@example.com');

// => &#x66;&#x40;&#101;&#120;a&#x6d;&#x70;&#108;&#101;&#x2e;&#x63;&#111;&#109;
```

```twig
{{ 'f@example.com'|email_encode }}
{# &#x66;&#x40;&#101;&#120;a&#x6d;&#x70;&#108;&#101;&#x2e;&#x63;&#111;&#109; #}
```

## DiffExtension

Provides 2 functions, 'diff', and 'diff_html'. 

### diff(\<iterable\> a, \<iterable\> b)

Differentiates 2 arrays, and returns a multi-dimensional array containing the differences.

```php
$ex = new DiffExtension();

// Will also work with multi-dimensional arrays

$a = [
    'key' => 'value',
];
$b = [
    'key' => 'value_2',
];
$ex->diff($a, $b);

// => [
//            0 => [
//                'd' => [
//                    'key' => 'value',
//                ],
//                'i' => [
//                    'key' => 'value_2',
//                ],
//            ],
//        ] 
```

```twig
{% set a = {'key': 'value'} %}
{% set b = {'key': 'value_2'} %}
{% set c = diff(a, b) %}
{# 
{
    {
        'd': {
            'key': 'value'
        },
        'i': {
            'key': 'value_2'
        }
    }
}
#}

```

### diff_html(\<string\> a, \<string\> b, \<string\> output)

Differentiates 2 strings, and returns an array containing the differences, surrounded by HTML <ins> and <del> tags.

Optionally returns a single string with the differences if *output* is set to 'string'.
 

```php
$ex  = new DiffExtension();
$old = 'That&#39;s what it said on &quot;Ask Jeeves.&quot;';
$new = 'That&#39;s what it said on &quot;Dogpile.&quot;';

// Output to array
$ex->diffHtml($old, $new, 'array');

// => [
//            'old' => 'That&#39;s what it said on <del>&quot;Ask Jeeves.&quot;</del>',
//            'new' => 'That&#39;s what it said on <ins>&quot;Dogpile.&quot;</ins>',
//        ]

// Output to single string
$ex->diffHtml($old, $new, 'string');

// => 'That&#39;s what it said on <del>&quot;Ask Jeeves.&quot;</del><ins>&quot;Dogpile.&quot;</ins>';
```

```twig
{{ diff_html('The lazy fox was eaten by the rabbid rabbit.', 'The stupid lazy fox was annihalited by the rabbit rabbit') }}

{# 'The <ins>stupid</ins>lazy fox was <del>eaten</del><ins>annihilated</ins>by the <del>rabbid rabbit.</del><ins>rabbit rabbit</ins>' #} 
```

## InflectorExtension

Provides string inflection functions: 'camelcase_to_capitalized_words', 'camelcase_to_sentence_case_words', and 'camelcase_to_lower_case_words'.

```php
$ex  = new InflectorExtension();
$string = 'camelCaseWordWith1Number';
$ex->camelCaseToCapitalizedWords($string)
// => 'Camel Case Word With 1 Number'
$ex->camelCaseToSentenceCasedWords($string)
// => 'Camel case word with 1 number'
$ex->camelCaseToLowerCasedWords($string)
// => 'camel case word with 1 number'
```

```twig
{{ 'camelCaseWordWith1Number'|camelcase_to_capitalized_words }}
{# 'Camel Case Word With 1 Number' #}

{{ 'camelCaseWordWith1Number'|camelcase_to_sentence_case_words}}
{# 'Camel case word with 1 number' #}

{{ 'camelCaseWordWith1Number'|camelcase_to_lower_case_words }}
{# 'camel case word with 1 number' #}
```

## MoneyExtension

Provides a 'cents_to_dollars' filter; which does exactly what it says it does.

```php
$ex = new MoneyExtension();
$ex->centsToDollars(1200);
// => '12.00'
```

```twig
{{ 1200|cents_to_dollars }}
{# '12.00' #}
```

## NumberExtension

Provides a 'number_to_human_readable' filter, to round to the closest thousand or million, and add a suffix (K, M).

### number_to_human_readable(<int|float> number, <int> $precision, <string> method)

```php
$ex = new NumberExtension();
$ex->formatNumberToHumanReadable(1200000);
// => '1.2M'

$ex->formatNumberToHumanReadable(999.99);
// => '1K'

$ex->formatNumberToHumanReadable(3154.14159, 2, 'ceil');
// => 3.16K'

$ex->formatNumberToHumanReadable(3154.14159, 2, 'floor');
// => 3.15K
```

```twig
{{ 1200000|number_to_human_readable }}
{# '1.2M' #}
```