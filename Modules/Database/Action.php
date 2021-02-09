<?php

require './Exceptions/SQLStatmentException.php';
abstract class Action
{
    protected Person $myPersonRef;

    /**
     * @return Person
     */
    public function getMyPersonRef(): Person
    {
        return $this->myPersonRef;
    }

    protected function getSingleStatement(String $query,&$conn)
    {
        $stmt=sqlsrv_query($conn,$query);
        if(!$stmt)
        {
            throw new SQLStatmentException(sqlsrv_errors());
        }
        else return $stmt;
    }
    protected function getParameterizedStatement(String $query,&$conn,array $params)
    {
        $stmt=sqlsrv_query($conn,$query,$params);
        if(!$stmt)
        {
            throw new SQLStatmentException(sqlsrv_errors());
        }
        else return $stmt;
    }



    protected function closeConnection(&$conn)
    {
        sqlsrv_close($conn);
    }

     private String $SERVER_NAME;
     private array $connectionInfo;

    /**
     *
     *
     * Action constructor.
     */

    /**
     */
    public function getDatabaseConnection()
    {

        return  sqlsrv_connect($this->SERVER_NAME, $this->connectionInfo);
    }

    protected function setConnection(Action $action)
    {
        $this->connectionInfo= array("UID" => "ziadmohamd456", "pwd" => "01015790817aA", "Database" => "DMS_db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
        $this->SERVER_NAME="tcp:dms-kfs.database.windows.net,1433";

    }

}