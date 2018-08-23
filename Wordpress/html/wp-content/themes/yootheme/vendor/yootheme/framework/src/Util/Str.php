<?php

namespace YOOtheme\Util;

class Str
{
    use MethodTrait;

    /**
     * Checks if string matches a given pattern.
     *
     * @param  string  $pattern
     * @param  string  $value
     * @return bool
     */
    public static function is($pattern, $string)
    {
        static $cache;

        if ($pattern == $string) {
            return true;
        }

        if (empty($cache[$pattern])) {

            $regexp = addcslashes($pattern, '/\\.+^$()=!<>|');
            $regexp = strtr($regexp, ['*' => '.*', '?' => '.?']);
            $regexp = static::convertBraces($regexp);

            $cache[$pattern] = "#^{$regexp}$#i";
        }

        return (bool) preg_match($cache[$pattern], $string);
    }

    /**
     * Checks if string contains a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if string starts with a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if string ends with a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the string length.
     *
     * @param  string $string
     * @return int
     */
    public static function length($string)
    {
        return mb_strlen($string);
    }

    /**
     * Converts string to upper case.
     *
     * @param  string $string
     * @return string
     */
    public static function toUpper($string)
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    /**
     * Convert string to lower case.
     *
     * @param  string $string
     * @return string
     */
    public static function toLower($string)
    {
        return mb_strtolower($string, 'UTF-8');
    }

    /**
     * Convert string to title case.
     *
     * @param  string $string
     * @return string
     */
    public static function titleCase($string)
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Convert string's first character to upper case.
     *
     * @param  string $string
     * @return string
     */
    public static function ucfirst($string)
    {
        return static::upper(static::substr($string, 0, 1)).static::substr($string, 1);
    }

    /**
     * Returns part of a string.
     *
     * @param  string   $string
     * @param  int      $start
     * @param  int|null $length
     * @return string
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param  string $string
     * @param  int    $limit
     * @param  string $end
     * @return string
     */
    public static function limit($string, $limit = 100, $end = '...')
    {
        if (mb_strwidth($string, 'UTF-8') <= $limit) {
            return $string;
        }

        return rtrim(mb_strimwidth($string, 0, $limit, '', 'UTF-8')).$end;
    }

    /**
     * Limit the number of words in a string.
     *
     * @param  string $string
     * @param  int    $words
     * @param  string $end
     * @return string
     */
    public static function words($string, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $string, $matches);

        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
        }

        return rtrim($matches[0]).$end;
    }

    /**
     * Generates a "random" alpha-numeric string.
     *
     * @param  int    $length
     * @return string
     */
    public static function random($length = 16)
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
    }

    /**
     * Converts a glob braces to a regex.
     *
     * @param  string $pattern
     * @return string
     */
    protected static function convertBraces($pattern)
    {
        if (preg_match_all('/{((?:[^{}]+|(?R))*)}/', $pattern, $matches, PREG_OFFSET_CAPTURE)) {

            list($matches, $replaces) = $matches;

            foreach ($matches as $i => $m) {
                $replace = str_replace(',', '|', static::convertBraces($replaces[$i][0]));
                $pattern = substr_replace($pattern, "({$replace})", $m[1], strlen($m[0]));
            }
        }

        return $pattern;
    }
}
