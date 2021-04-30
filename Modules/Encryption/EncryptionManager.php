<?php


class EncryptionManager
{

    //TODO::Store These Values in the environment of the server

    private static string $METHOD='AES-256-CTR';
    private static string $IV='5789463210364851';
    private static string $KEY='JustARandomKey';
    private static int $OPTIONS=0;



    public static function Encrypt(string $text):string
    {
        return openssl_encrypt($text,self::$METHOD,self::$KEY,self::$OPTIONS,self::$IV);

    }

    public static function Decrypt(string $cipher):string
    {
        return openssl_decrypt($cipher,self::$METHOD,self::$KEY,self::$OPTIONS,self::$IV);

    }
}