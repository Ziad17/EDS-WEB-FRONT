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
    public function getInstitutionIDByName(string $getName):int
    {

        $conn=$this->getDatabaseConnection();
        $sql = "SELECT ID FROM Institution WHERE institution_name =?";
        $params = array($getName);
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            //TODO :PRODUCTION UNCOMMENT THIS
            //$error="Error fetching the required data";
            $error=sqlsrv_errors()[0]['message'];
            sqlsrv_close($conn);

            throw new SQLStatmentException($error);
        }
        else
        {
            $row=sqlsrv_fetch_object($stmt);
            return (int)$row->ID;
        }
    }
    protected function getSingleStatement(String $query,&$conn)
    {
        $stmt=sqlsrv_query($conn,$query);
        if(!$stmt)
        {
            $error=sqlsrv_errors()[0];
            throw new SQLStatmentException($error['message']);
        }
        else return $stmt;
    }
    protected function getParameterizedStatement(String $query,&$conn,array $params)
    {
        try {
            return sqlsrv_query($conn, $query, $params);

        }
        catch (Exception $e)
        {
            $error = sqlsrv_errors()[0];
echo $error['message'];
            throw new SQLStatmentException($error['message']);

        }
    }

/*   protected function  getInstitutionNameByID($id):String
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
   }*/

    public  function getInstitutionNameByID(int $id): String
    {
        $con=$this->getDatabaseConnection();
        $sql = "SELECT institution_name FROM Institution WHERE ID=?";
        $params = array($id);
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if ($stmt == false || !sqlsrv_has_rows($stmt)) {
            $this->closeConnection($conn);
            throw new SQLStatmentException("Error fetching the required data");
        }
        else
        {
            $row=sqlsrv_fetch_object($stmt);
            return (string)$row->institution_name;
        }

    }

    public function isUserExists(string $academicNumber, string $getEmail): bool
    {
        $conn = $this->getDatabaseConnection();
        $sql = "SELECT * FROM Person WHERE Person.academic_number=? OR Person.contact_email=?";
        $params = array("{$academicNumber}",
            "{$getEmail}");
        $stmt = $this->getParameterizedStatement($sql, $conn, $params);

        if ($stmt == false) {
            throw new SQLStatmentException("Couldn't execute this statement");
        }
        if (sqlsrv_has_rows($stmt)) {
            $row=sqlsrv_fetch_object($stmt);
            echo $row->ID;
            return true;
        }
        return false;
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

        try {
            sqlsrv_close($conn);
        } catch (Exception $e) {
        }
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
        $this->connectionInfo= array("UID" => "ziadmohamd456", "pwd" => "{01015790817aA}", "Database" => "DMS_db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
        $this->SERVER_NAME= "tcp:dms-kfs1.database.windows.net,1433";

    }

}
