<?php
namespace System;

/**
 * Crypt static class. This class allows to manipulate Mcrypt functions more easily.
 *
 * @package IRON
 * @link ... nothing yet...
 * @author Mickaël Boidin <mickael.boidin@icloud.com>
 */
class Crypt
{    
    /**
     * The encryption type
     * 
     * @var mixed
     * @access private
     * @static
     */
    private static $_typeOfEncryption = MCRYPT_RIJNDAEL_128;

    /**
     * The encryption mode
     * 
     * @var mixed
     * @access private
     * @static
     */
    private static $_modeOfEncryption = MCRYPT_MODE_ECB;

    /**
     * Vector generator.
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
     * Key generator.
     * 
     * @access private
     * @static
     * @param $salt The salt used for encryption and decryption
     * @return string
     */
    private static function _keyGenerator($salt)
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
     * Encrypt datas.
     * 
     * @access public
     * @static
     * @param mixed $data The uncrypted data to encrypt
     * @param string $salt The salt used for the encryption
     * @return string
     */
    public static function encrypt($data, $salt = SALT)
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
     * Decrypt datas.
     * 
     * @access public
     * @static
     * @param mixed $data The encrypted data to decrypt
     * @param string $salt The salt used for the encryption
     * @return string
     */
    public static function decrypt($data, $salt = SALT)
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
