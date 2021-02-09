<?php

declare(strict_types=1);
abstract class Validator
{

    protected bool $IS_ERROR_PRESENT=false;


    protected array $ERRORS_LIST=array();
     public abstract function isValid():bool;
     public final function getERRORSLIST():array
     {
         return $this->ERRORS_LIST;
     }

    public final function isErrorPresent():bool
    {
        return $this->IS_ERROR_PRESENT;
    }
    

    

}









?>