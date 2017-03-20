<?php

namespace Ten24\Twig\Extension;

class DiffExtension extends \Twig_Extension
{
    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('diff', [$this, 'diff']),
            new \Twig_SimpleFunction('diff_html', [$this, 'diffHtml'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Given an input of:
     * $new   = [
     *      'key' => 'value',
     *      'key2' => 'value'
     * ];
     * $old   = [
     *      'key'  => 'value',
     * ];
     *
     * This function will return:
     *
     * [
     *      0 => [
     *          'd' => [],
     *          'i' => [],
     *      ],
     *      'key' => 'value',
     *      1 => [
     *          'd' => [
     *              'key2' => 'value',
     *          ],
     *          'i' => [],
     *      ],
     * ];
     *
     * Paul's Simple Diff Algorithm v 0.1
     * (C) Paul Butler 2007 <http://www.paulbutler.org/>
     *
     * @see https://github.com/paulgb/simplediff
     *
     * @param array $old
     * @param array $new
     *
     * @return array
     */
    public function diff($old, $new)
    {
        $matrix = [];
        $maxlen = 0;
        $omax   = 0;
        $nmax   = 0;
        $old    = is_array($old) ? $old : [$old];
        $new    = is_array($new) ? $new : [$new];

        foreach ($old as $oindex => $ovalue) {
            $nkeys = array_keys($new, $ovalue);
            foreach ($nkeys as $nindex) {
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                if ($matrix[$oindex][$nindex] > $maxlen) {
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax   = $oindex + 1 - $maxlen;
                    $nmax   = $nindex + 1 - $maxlen;
                }
            }
        }
        if ($maxlen == 0) {
            return [['d' => $old, 'i' => $new]];
        }

        return array_merge(
            $this->diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
            array_slice($new, $nmax, $maxlen),
            $this->diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
        );
    }

    /**
     * Paul's Simple Diff Algorithm v 0.1
     * (C) Paul Butler 2007 <http://www.paulbutler.org/>
     *
     * @see https://github.com/paulgb/simplediff
     *
     * @param string $old
     * @param string $new
     * @param string $output
     *
     * @return array|string
     */
    public function diffHtml($old, $new, $output = 'array')
    {
        if (!in_array($output, ['array', 'string'])) {
            throw new \RuntimeException(
                sprintf('Unknown output type "%s"', $output)
            );
        }

        $ret = '';
        $arr = [
            'old' => '',
            'new' => '',
        ];

        $diff = $this->diff(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));

        //die(print_r($diff));
        foreach ($diff as $k) {
            if (is_array($k)) {
                $deletions  = !empty($k['d']) ? '<del>'.implode(' ', $k['d']).'</del>' : '';
                $insertions = !empty($k['i']) ? '<ins>'.implode(' ', $k['i']).'</ins>' : '';
                $deletions  = $deletions.(!empty($deletions) ? ' ' : '');
                $insertions = $insertions.(!empty($insertions) ? ' ' : '');
                $ret .= trim($deletions).$insertions;
                $arr['old'] .= $deletions;
                $arr['new'] .= $insertions;
            } else {
                // No differences
                $str = $k.' ';
                $ret .= $str;
                $arr['old'] .= $str;
                $arr['new'] .= $str;
            }
        }

        // cleanup
        $ret        = trim(ltrim($ret));
        $arr['old'] = trim(ltrim($arr['old']));
        $arr['new'] = trim(ltrim($arr['new']));

        return ($output === 'string') ? $ret : $arr;
    }

    public function getName()
    {
        return 'ten24_twig.diff';
    }
}