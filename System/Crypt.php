<?php
namespace System;

/**
 * Crypt class.
 */
class Crypt
{    
    /**
     * _typeOfEncryption
     * 
     * (default value: MCRYPT_RIJNDAEL_128)
     * @var mixed
     * @access private
     * @static
     */
    private static $_typeOfEncryption = MCRYPT_RIJNDAEL_128;

    /**
     * modeOfEncryption
     * 
     * (default value: MCRYPT_MODE_ECB)
     * @var mixed
     * @access private
     * @static
     */
    private static $_modeOfEncryption = MCRYPT_MODE_ECB;

    /**
     * _iv generator function.
     * 
     * @access private
     * @static
     * @return string
     */
    private static function _iv()
    {
        return mcrypt_create_iv(
            mcrypt_get_iv_size(
                self::$_typeOfEncryption,
                self::$_modeOfEncryption
            )
        );
    }

    /**
     * _keyGenerator function.
     * 
     * @access private
     * @static
     * @param string $salt
     * @return string
     */
    private static function _keyGenerator(string $salt)
    {
        return substr(
            $salt,
            0,
            mcrypt_module_get_algo_key_size(
                self::$_typeOfEncryption
            )
        );
    }

    /**
     * encrypt function.
     * 
     * @access public
     * @static
     * @param string $data
     * @param string $salt (default: SALT)
     * @return string
     */
    public static function encrypt(string $data, string $salt = SALT)
    {
        return base64_encode(
            mcrypt_encrypt(
                self::$_typeOfEncryption,
                self::_keyGenerator($salt),
                $data,
                self::$_modeOfEncryption,
                self::_iv()
            )
        );
    }

    /**
     * decrypt function.
     * 
     * @access public
     * @static
     * @param string $data
     * @param string $salt (default: SALT)
     * @return string
     */
    public static function decrypt(string $data, string $salt = SALT)
    {
        return rtrim(
            mcrypt_decrypt(
                self::$_typeOfEncryption,
                self::_keyGenerator($salt),
                base64_decode($data),
                self::$_modeOfEncryption,
                self::_iv()
            )
        );
    }
}
