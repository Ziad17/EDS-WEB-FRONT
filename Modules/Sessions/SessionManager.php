<?php

error_reporting(0);
class SessionManager
{


    public const USER_EMAIL="user_email";
    public const USER_ID="user_id";
    public const USER_EXP_TIME_STAMP="user_exp_time_stamp";

    public static function getID():int
    {
        return (int)$_SESSION[self::USER_ID];
    }

    public static function getEmail():String
    {
        return (String)$_SESSION[self::USER_EMAIL];
    }
    public static function getTimeStamp()
    {
        return $_SESSION[self::USER_EXP_TIME_STAMP];
    }

    public static function sessionSignIn(String $email,int $id)
    {
        try {
            session_start();
        }
        catch (Exception $e){}
        $_SESSION[self::USER_EMAIL] = $email;
        $_SESSION[self::USER_ID] = $id;
        $_SESSION[self::USER_EXP_TIME_STAMP]=date("Y-m-d h:i:s",strtotime("+1 days"));
    }

    public static function sessionLogOut()
    {
        session_start();

        unset($_SESSION[self::USER_EMAIL]);
        unset($_SESSION[self::USER_ID]);
        unset($_SESSION[self::USER_EXP_TIME_STAMP]);

        session_destroy();
    }

    public static function validateSession(): bool
    {
        try {
            session_start();
        }
        catch (Exception $e){}
        if(isset($_SESSION[self::USER_EMAIL]) && isset($_SESSION[self::USER_ID]) && isset($_SESSION[self::USER_EXP_TIME_STAMP]))
        {
            if(strtotime($_SESSION[self::USER_EXP_TIME_STAMP])>strtotime(date("Y-m-d h:i:s")))
            {
                return true;

            }
            self::sessionLogOut();
            return false;

        }
        else{
            self::sessionLogOut();

            return false;
        }
    }


}