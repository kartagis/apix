<?php
/**
 * User: aligurbuz
 */

namespace src\services;
use src\services\httprequest as request;


class csrf {


    /**
     * The default token name
     */
    public static $_instance=null;
    public static  $token_name = "_csrf_token_645a83a41868941e4692aa31e7235f2";

    /**
     * The symfony request
     */
    public $request;

    /**
     * construct method for generate csrf token
     *
     * @param string request - defaults to the default symfony package
     * @return void
     */
    public function __construct()
    {
        //symfony request load
        $this->request=new request();

    }

    /**
     * (Re-)Generate a token and write it to session
     *
     * @param string $token_name - defaults to the default token name
     * @return void
     */
    public function generateToken()
    {
        //self instance
        self::$_instance=(self::$_instance==null) ? new self() : self::$_instance;

        // generate as random of a token as possible
        $clientIp   = self::$_instance->request->getClientIp();
        $clientIpHash=sha1(uniqid(sha1($clientIp), true));
        \session::set(self::$token_name,$clientIpHash);
        return $clientIpHash;
    }

    /**
     * Get the token.  If it's not defined, this will go ahead and generate one.
     *
     * @param string $token_name - defaults to the default token name
     * @return string
     */
    public static function getToken()
    {
        if (empty(\session::get(self::$token_name))) {

            self::$_instance=(self::$_instance==null) ? new self() : self::$_instance;
            return self::$_instance->generateToken();
        }

        return \session::get(self::$token_name);
    }

    /**
     * Get the token name.  This is just a CRUD method to make your code cleaner.
     *
     * @param string $token_name
     * @return string
     */
    public static function getTokenName()
    {
        return self::$token_name;
    }

    /**
     * Validate the token.  If there's not one yet, it will set one and return false.
     *
     * @param array $request_data - your whole POST/GET array - will index in with the token name to get the token.
     * @param string $token_name - defaults to the default token name
     * @return bool
     */
    public static function validate($request_data = array(), $token_name = self::TOKEN_NAME)
    {
        if (empty($_SESSION[$token_name])) {
            static::generateToken($token_name);
            return false;
        } elseif (empty($request_data[$token_name])) {
            return false;
        } else {
            return static::compare($request_data[$token_name], static::getToken($token_name));
        }
    }

    /**
     * Get a hidden input string with the token/token name in it.
     *
     * @param string $token_name - defaults to the default token name
     * @return string
     */
    public static function getHiddenInputString($token_name = self::TOKEN_NAME)
    {
        return sprintf('<input type="hidden" name="%s" value="%s"/>', $token_name, static::getToken($token_name));
    }

    /**
     * Get a query string mark-up with the token/token name in it.
     *
     * @param string $token_name - defaults to the default token name
     * @return string
     */
    public static function getQueryString($token_name = self::TOKEN_NAME)
    {
        return sprintf('%s=%s', $token_name, static::getToken($token_name));
    }

    /**
     * Get an array with the token (useful for form libraries, etc.)
     *
     * @param string $token_name
     * @return array
     */
    public static function getTokenAsArray($token_name = self::TOKEN_NAME)
    {
        return array(
            $token_name => self::getToken($token_name)
        );
    }

    /**
     * Constant-time string comparison.  This comparison function is timing-attack safe
     *
     * @param string $hasha
     * @param string $hashb
     * @return bool
     */
    public static function compare($hasha = "", $hashb = "")
    {
        // we want hashes_are_not_equal to be false by the end of this if the strings are identical

        // if the strings are NOT equal length this will return true, else false
        $hashes_are_not_equal = strlen($hasha) ^ strlen($hashb);

        // compare the shortest of the two strings (the above line will still kick back a failure if the lengths weren't equal.  this just keeps us from over-flowing our strings when comparing
        $length = min(strlen($hasha), strlen($hashb));
        $hasha = substr($hasha, 0, $length);
        $hashb = substr($hashb, 0, $length);

        // iterate through the hashes comparing them character by character
        // if a character does not match, then return true, so the hashes are not equal
        for ($i = 0; $i < strlen($hasha); $i++) {
            $hashes_are_not_equal += !(ord($hasha[$i]) === ord($hashb[$i]));
        }

        // if not hashes are not equal, then hashes are equal
        return !$hashes_are_not_equal;
    }

}
