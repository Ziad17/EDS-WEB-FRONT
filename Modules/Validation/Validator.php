<?php

declare(strict_types=1);
abstract class Validator
{

    protected String $ERROR;
     public abstract function validate():bool;
     public final function getError():String
     {
         return $this->ERROR;
     }

    public final function isErrorPresent():bool
    {
        if(empty($this->ERROR))
        {
            return  false;
        }
        return true;
    }
    

    

}









?>