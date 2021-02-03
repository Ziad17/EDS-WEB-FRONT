<?php


class FileValidator
{
    public static function validateFile(FileVersion $fileVersion): String
    {
         $error="Unsupported File Format";
         foreach (SUPPORTED_FILES as $type)
         {
             if(strtoupper($type)==strtoupper($fileVersion->getFileExtension()))
             {
                 $error="";
                 break;
             }
         }
         if(empty($error))
         {
             if($fileVersion->getSizeInBytes()<=MAXIMUM_FILE_SIZE_IN_BYTES)
             {
                 return "";

             }
             else{return "The File Size Limit Is ".(MAXIMUM_FILE_SIZE_IN_BYTES/1024/1024)."MB";}

         }
         else{return $error;}

    }

}