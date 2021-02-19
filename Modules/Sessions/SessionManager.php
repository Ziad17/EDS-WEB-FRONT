<?php


class SessionManager
{

    public const USER_EMAIL="user_email";
    public const USER_ID="user_id";
    public const USER_EXP_TIME_STAMP="user_exp_time_stamp";

    public static function sessionSignIn(String $email,int $id)
    {
        session_start();
        $_SESSION[self::USER_EMAIL] = $email;
        $_SESSION[self::USER_ID] = $id;
        $_SESSION[self::USER_EXP_TIME_STAMP]=date("Y-m-d h:i:s",strtotime("+1 days"));
    }

    public static function sessionLogOut()
    {
        session_destroy();
    }

    public static function validateSession(): bool
    {
        session_start();
        if(isset($_SESSION[self::USER_EMAIL]) && isset($_SESSION[self::USER_ID]) && isset($_SESSION[self::USER_EXP_TIME_STAMP]))
        {
            if(strtotime($_SESSION[self::USER_EXP_TIME_STAMP])>strtotime(date("Y-m-d h:i:s")))
            {
             //   echo $_SESSION[self::USER_ID];
              //  echo $_SESSION[self::USER_EMAIL];
              //   echo $_SESSION[self::USER_EXP_TIME_STAMP];

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