<?php

namespace Core;
/**
 * Internationalization (i18n) class. Provides language loading and translation
 * methods without dependencies on [gettext](http://php.net/gettext).
 *
 * Typically this class would never be used directly, but used via the __()
 * function, which loads the message and replaces parameters:
 *
 *     // Display a translated message
 *     echo _('Hello, world');
 *
 *     // With parameter replacement
 *     echo _('Hello, :user', array(':user' => $username));
 *
 * @package    Kohana
 * @category   Base
 * @author     Kohana Team
 * @copyright  (c) 2008-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class I18n {

    /**
     * @var  string   target language: en-us, es-es, zh-cn, etc
     */
    public static $lang = 'en-us';

    /**
     * @var  string  source language: en-us, es-es, zh-cn, etc
     */
    public static $source = 'en-us';

    /**
     * @var  array  cache of loaded languages
     */
    protected static $_cache = array();

    /**
     * Get and set the target language.
     *
     *     // Get the current language
     *     $lang = I18n::lang();
     *
     *     // Change the current language to Spanish
     *     I18n::lang('es-es');
     *
     * @param   string   new language setting
     * @return  string
     * @since   3.0.2
     */
    public static function lang($lang = NULL)
    {
        if ($lang)
        {
            // Normalize the language
            I18n::$lang = strtolower(str_replace(array(' ', '_'), '-', $lang));
        }

        return I18n::$lang;
    }

    /**
     * Returns translation of a string. If no translation exists, the original
     * string will be returned. No parameters are replaced.
     *
     *     $hello = I18n::get('Hello friends, my name is :name');
     *
     * @param   string   text to translate
     * @param   string   target language
     * @return  string
     */
    public static function get($string, $lang = NULL)
    {
        if ( ! $lang)
        {
            // Use the global target language
            $lang = I18n::$lang;
        }

        // Load the translation table for this language
        $table = I18n::load($lang);

        // Return the translated string if it exists
        return isset($table[$string]) ? $table[$string] : $string;
    }

    /**
     * Returns the translation table for a given language.
     *
     *     // Get all defined Spanish messages
     *     $messages = I18n::load('es-es');
     *
     * @param   string   language to load
     * @return  array
     */
    public static function load($lang)
    {
        if (isset(I18n::$_cache[$lang]))
        {
            return I18n::$_cache[$lang];
        }

        // New translation table
        $table = array();

        // Split the language: language, region, locale, etc
        $parts = explode('-', $lang);
        $path = implode(DS, $parts);

        $file = SP . 'Locale' . DS . $path . EXT;
        if (file_exists($file))
        {
            $table = include($file);
        }

        // Cache the translation table locally
        return I18n::$_cache[$lang] = $table;
    }

    public static function prefered_language($available_languages, $http_accept_language="auto") 
    {
        if ($http_accept_language == "auto") $http_accept_language = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';

        preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" .
                       "(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i", 
        $http_accept_language, $hits, PREG_SET_ORDER);

        // default language (in case of no hits) is the first in the array
        $bestlang = $available_languages[0];
        $bestqval = 0;

        foreach ($hits as $arr) 
        {
            // read data from the array of this hit
            $langprefix = strtolower ($arr[1]);
            if (!empty($arr[3])) 
            {
                $langrange = strtolower ($arr[3]);
                $language = $langprefix . "-" . $langrange;
            }
            else $language = $langprefix;
            $qvalue = 1.0;
            if (!empty($arr[5])) $qvalue = floatval($arr[5]);
             
            // find q-maximal language
            if (in_array($language,$available_languages) && ($qvalue > $bestqval)) 
            {
                $bestlang = $language;
                $bestqval = $qvalue;
            }
            // if no direct hit, try the prefix only but decrease q-value by 10% (as http_negotiate_language does)
            else if (in_array($langprefix,$available_languages) && (($qvalue*0.9) > $bestqval)) 
            {
                $bestlang = $langprefix;
                $bestqval = $qvalue*0.9;
            }
        }
        return $bestlang;
    }

} // End I18n
