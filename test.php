<?php
// phpinfo();
require_once "./Modules/Database/MainAction.php";
require_once "./Modules/Permissions/InstitutionsPermissions.php";

// PHP Data Objects(PDO) Sample Code:

$Action=new MainAction();
$query="SELECT * FROM InstitutionPermissions ORDER BY bit_value";
$conn=$Action->getDatabaseConnection();
$stmt = sqlsrv_query($conn, $query);
while ($row =sqlsrv_fetch_array($stmt))
{
    print_r($row);
    echo"</br>";
}

echo"</br>";
echo"</br>";
echo"</br>";

$permissions=new InstitutionsPermissions(127);
print_r($permissions->getPermissionsBitArray());
echo $permissions->getPermissionsBitArray()[$permissions->CREATE_ROLE];
    ?>



