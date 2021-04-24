<?php

require_once "Validator.php";

class ImageValidator extends Validator
{

    private  array  $ALLOWED_EXTENSIONS=array('jpg','jpeg','png');
    private int $ALLOWED_SIZE_IN_BYTES=1048576;

    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
    }
    public  function validateName(string $name):string
    {

        if($name!=null && trim($name)!="")
        {return '';}
        return 'Image Name Is Invalid';
    }
    public function validateSize(int $sizeInBytes):bool
    {
        if($sizeInBytes<=$this->ALLOWED_SIZE_IN_BYTES)
        {return '';}
        return 'Image Size Must Be Lower Than 1MB';
    }
    public function validateExtension(string $ExtensionWithOrWithoutDot):bool
    {
        $ext=$ExtensionWithOrWithoutDot;
        if(strpos($ExtensionWithOrWithoutDot,'.')>=0)
        {
            $ext=substr($ExtensionWithOrWithoutDot,'.');
        }
        if(in_array($ext,$this->ALLOWED_EXTENSIONS))
        {return '';}
        return 'Incorrect Format';


    }
}