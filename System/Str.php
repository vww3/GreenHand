<?php
namespace System;

/**
 * String class.
 */
class Str
{
     /**
     * simplify a string function.
     * 
     * Very great for URLs ;)
     *
     * @access public
     * @static
     * @param string $string
     * @return string
     */
    public static function simplify(string $string)
    {
        return utf8_encode(
            // Replacement of specials caracters
            preg_replace(
                array(
                    utf8_decode('@[ÈÉÊËèéêë]@i'),            // --> e
                    utf8_decode('@[ÀÁÂÃÄÅàáâãäå\@]@i'),      // --> a
                    utf8_decode('@[ÌÍÎÏìíîï]@i'),            // --> i
                    utf8_decode('@[ÙÚÛÜùúûü]@i'),            // --> u
                    utf8_decode('@[ÒÓÔÕÖðòóôõö]@i'),         // --> o
                    utf8_decode('@[çÇ]@i'),                  // --> c
                    utf8_decode('@[Ýýÿ]@i'),                 // --> y
                    utf8_decode('@[,;:!§/().?*°&#"=+]@i'),   // Must be removed
                    utf8_decode('@[\s\']@')                  // --> -
                ),
                array('e','a','i','u','o','c','y','','-'),
                // Convert to utf-8
                utf8_decode(
                    // Lowercase
                    mb_strtolower(
                        trim(
                            // No more HTML tags
                            strip_tags($string)
                        ),'UTF-8'
                    )
                )
            )
        );
    }
    
    /**
     * clean a string function.
     *
     * Good for database injection
     *
     * @access public
     * @static
     * @param string $string
     * @param bool $allowHTMLTags (default: true)
     * @return string
     */
    public static function clean(string $string, bool $allowHTMLTags = true)
    {
        if (!$allowHTMLTags)
            $string = strip_tags($string);
            
        return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);                
    }
    
    /**
     * Get length of string function.
     *
     * @access public
     * @static
     * @param string $string
     * @return string
     */
    public static function length(string $string)
    {
	    return strlen($string);
    }
    
    /**
     * Compare two string function.
     *
     * @access public
     * @static
     * @param string $string1
     * @param string $string2
     * @return string
     */
    public static function isSame(string $string1, string $string2)
    {
	    return $string1 == $string2;
    }
    
    
    /**
     * isDate function.
     * 
     * @access public
     * @static
     * @param string $string
     * @param string $format (default: 'd-m-Y')
     * @return bool
     */
    public static function is(string $string, string $format = 'd-m-Y')
    {
        $date = DateTime::createFromFormat($format, $string);
        
        return $date && $date->format($format) == $string;
    }
   
    /**
     * isEmail function.
     *
     * @access public
     * @static
     * @param string $string
     * @return bool
     */
    public static function isEmail(string $string)
    {
	    return filter_var($string, FILTER_VALIDATE_EMAIL);
    }
}
