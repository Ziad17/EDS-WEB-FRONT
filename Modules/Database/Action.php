<?php

require 'Modules/Exceptions/SQLStatmentException.php';
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
            throw new SQLStatmentException(sqlsrv_errors()['code']);
        }
        else return $stmt;
    }
    protected function getParameterizedStatement(String $query,&$conn,array $params)
    {
        $stmt=sqlsrv_query($conn,$query,$params);
        if(!$stmt)
        {
            $error=sqlsrv_errors()[0];
            throw new SQLStatmentException($error['message']);
        }
        else return $stmt;
    }

   protected function  getIntitutionNameByID($id):String
   {
       $conn = $this->getDatabaseConnection();
       $sql = "SELECT institution_name FROM Institutuion_view WHERE ID=?";
       $params = array($id);
       $stmt = $this->getParameterizedStatement($sql, $conn, $params);
       if ($stmt == false || !sqlsrv_has_rows($stmt)) {
           $this->closeConnection($conn);
           throw new SQLStatmentException("Could not get details of the institution");
       }
       $name = sqlsrv_fetch_array($stmt)[0][0];
       $this->closeConnection($conn);
       return $name;
   }


    protected function getIdFromPersonEmail(string $targetEmail): int
    {
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT ID FROM Person WHERE contact_email=?";
        $params = array($targetEmail);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the person id");
        }
        $id = sqlsrv_fetch_array($stmt)[0][0];
        $this->closeConnection($conn);
        return $id;
    }

    protected function getEmailFromPersonId(int $id): String
    {
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT contact_email FROM Person WHERE ID=?";
        $params = array($id);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the person id");
        }
        $email = sqlsrv_fetch_array($stmt)[0][0];
        $this->closeConnection($conn);
        return $email;
    }


    protected function getNameFromPersonId(int $id): String
    {
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT first_name,last_name FROM Person WHERE ID=?";
        $params = array($id);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Could not get details of the person id");
        }
        $first = sqlsrv_fetch_array($stmt)[0][0];
        $second = sqlsrv_fetch_array($stmt)[0][1];

        $this->closeConnection($conn);
        return $first." ".$second;
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