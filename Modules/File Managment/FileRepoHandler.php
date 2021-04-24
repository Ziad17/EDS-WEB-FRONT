<?php
require_once "vendor/autoload.php";
require_once "./Modules/Exceptions/FileHandlerException.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\ServiceException;

class FileRepoHandler
{
    //TODO: Move every ConnectionString to environment variables
    private string $connectionString;
    private FileAction $fileAction;
    private BlobRestProxy $blobClient;
    private string $GENERAL_CONTAINER='general';
    private  string $IMAGES_CONTAINER='images';

    /**
     * FileRepoHandler constructor.
     * @param FileAction $fileAction
     * @throws ConnectionException
     */
    public function __construct(FileAction $fileAction)
    {
        $this->fileAction = $fileAction;
        try {
            $this->connectionString= "DefaultEndpointsProtocol=https;AccountName=kfsdocs;AccountKey=X2N+Kzd/wHAhNsPk2vLTiWtfD5E7k/MUiPsmOqhUes47pPdsuxFeG8JDIRJul7m0S6VA9eO8dguuN5DAfcEUFg==;EndpointSuffix=core.windows.net";
                $this->blobClient = BlobRestProxy::createBlobService($this->connectionString);
        }
        catch (Exception $e)
        {
            throw new ConnectionException($e->getMessage());
        }
    }

    //FIXME:: UNCOMMENT
/*
    public function createFile(FileVersion $fileMetaData, ResourceBundle $content) : bool
    {
        try {
        //$versionName=$fileMetaData->getName() . random_bytes(RANDOM_BYTES_LENGTH).'.' . $fileMetaData->getFileExtension();
         $this->blobClient->createBlockBlob(MAIN_BLOB_CONTAINER,
                $fileMetaData->getFileContentURL(),
                 $content);
        }
        catch (Exception $e)
        {throw new FileHandlerException($e->getMessage());}
        return true;
    }*/


    //FIXME:: REMOVE(ONLY FOR TEST PURPOSES)
    public function createFile(string $name,  $content) : bool
    {
        try {
            //$versionName=$fileMetaData->getName() . random_bytes(RANDOM_BYTES_LENGTH).'.' . $fileMetaData->getFileExtension();
            $this->blobClient->createBlockBlob($this->GENERAL_CONTAINER,
               $name,
                $content);
        }
        catch (Exception $e)
        {throw new FileHandlerException($e->getMessage());}
        return true;
    }


    public  function createImage(string $name,  $content) : bool
    {
        try {
            //$versionName=$fileMetaData->getName() . random_bytes(RANDOM_BYTES_LENGTH).'.' . $fileMetaData->getFileExtension();
            $this->blobClient->createBlockBlob($this->IMAGES_CONTAINER,
                $name,
                $content);
        }
        catch (Exception $e)
        {throw new FileHandlerException($e->getMessage());}
        return true;
    }


    //FIXME:: REMOVE(ONLY FOR TEST PURPOSES)

    public function getFile(string $fileName )
    {
        try {
            $content= $this->blobClient->getBlob('general',
                $fileName) ;
            return $content->getContentStream();
        }
        catch (Exception $e)
        {throw new FileHandlerException($e->getMessage());}

    }


    public function getImagePrivateURI($imgName) : string
    {
        try {
            $content= $this->blobClient->getBlob($this->IMAGES_CONTAINER,
                $imgName) ;
             $data=stream_get_contents($content->getContentStream());
            $im = imagecreatefromstring($data);

            ob_start();
            imagepng($im);
            $png = ob_get_clean();
             return "data:image/png;base64," . base64_encode($png);
        }
        catch (Exception $e)
        {throw new FileHandlerException($e->getMessage());}
    }

    //FIXME:: UNCOMMENT
    /*  public function getFile(FileVersion $fileMetaData)
      {
          try {
              $content= $this->blobClient->getBlob(MAIN_BLOB_CONTAINER,
                  $fileMetaData->getFileContentURL()) ;
              return $content->getContentStream();
          }
          catch (Exception $e)
          {throw new FileHandlerException($e->getMessage());}

      }*/

}
