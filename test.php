<?php
// phpinfo();
require_once "./Modules/Database/MainAction.php";
echo 'sssssss';
// PHP Data Objects(PDO) Sample Code:

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "ziadmohamd456", "pwd" => "01015790817aA", "Database" => "DMS_db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
 $serverName = "tcp:dms-kfs.database.windows.net,1433";
$conn =  sqlsrv_connect($serverName, $connectionInfo);

$query="SELECT institution_name FROM Institution";
$stmt = sqlsrv_query($conn, $query);
echo sqlsrv_errors($stmt)[0]['message'];


while($row = sqlsrv_fetch_array($stmt)) {
    echo $row[0];
    echo "</br>";
    
    //...
}

$person=Institution::Builder()->setName('asdasdasd')->build();
print ($person->getName());

$ma=new MainAction();
if(1)
{print($ma->getAllAvailableRoles(2)[0]->getJobTitle());}

if(strtotime(date("Y-m-d h:i:s"))>strtotime(date("Y-m-d h:i:s",mktime(1,25,0,2,19,2021))))
{
    echo "YES:";
}
echo date("Y-m-d",strtotime("+1 days"));


    ?>



