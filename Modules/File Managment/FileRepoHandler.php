<?php


use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class FileRepoHandler
{
    //TODO: Move every ConnectionString to environment variables
    private string $connectionString;
    private FileFolderAction $fileAction;
    private BlobRestProxy $blobClient;

    /**
     * FileRepoHandler constructor.
     * @param FileFolderAction $fileAction
     * @throws ConnectionException
     */
    public function __construct(FileFolderAction $fileAction)
    {
        $this->fileAction = $fileAction;
        try {
            $this->connectionString= "DefaultEndpointsProtocol=https;AccountName=edsfilestorage;AccountKey=qu349dZBhYUNd33L9RKUp5/eHreodM5Gz0xbyXCtHDWzOuXc0JwCrSrqU3T7zY9NcSTbkFWwR05T6gMTicXHLQ==;EndpointSuffix=core.windows.net";
            $this->blobClient = BlobRestProxy::createBlobService($this->connectionString);
        }
        catch (Exception $e)
        {
            throw new ConnectionException($e->getMessage());
        }
    }


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
    }
    public function getFile(FileVersion $fileMetaData)
    {
        try {
            $content= $this->blobClient->getBlob(MAIN_BLOB_CONTAINER,
                $fileMetaData->getFileContentURL()) ;
            return $content->getContentStream();
        }
        catch (Exception $e)
        {throw new FileHandlerException($e->getMessage());}

    }

}
