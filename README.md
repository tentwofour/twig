# Twig

A few Twig extensions

## Email Encoding Extension

Randomly encodes passed text into a mix of ascii, hex, and plain characters. Pulled from the SF1 libraries.

```php
$ex = new EmailEncodingExtension()
$ex->filter('f@example.com');
// => &#x66;&#x40;&#101;&#120;a&#x6d;&#x70;&#108;&#101;&#x2e;&#x63;&#111;&#109;
```