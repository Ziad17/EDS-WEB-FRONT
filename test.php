<?php
// phpinfo();

// PHP Data Objects(PDO) Sample Code:

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "ziadmohamd456", "pwd" => "01015790817aA", "Database" => "DMS_db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
 $serverName = "tcp:dms-kfs.database.windows.net,1433";
$conn =  sqlsrv_connect($serverName, $connectionInfo); 


$query="SELECT * FROM Person";
$stmt = sqlsrv_query($conn, $query);

while($row = sqlsrv_fetch_array($stmt)) {
    echo $row[1];
    echo "</br>";
    
    //...
}
?>
