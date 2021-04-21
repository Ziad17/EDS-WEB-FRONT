<?php
// phpinfo();
require_once "./Modules/Database/PersonAction.php";
require_once "./Modules/Database/FileAction.php";

require_once "./Modules/Database/MainAction.php";
require_once "./Modules/Permissions/InstitutionsPermissions.php";
require_once "./Modules/Database/InstitutionAction.php";
require_once "./Modules/Sessions/SessionManager.php";
require_once "./Modules/Encryption/EncryptionManager.php";
SessionManager::sessionSignIn('admin@gmail.com',2);

require_once "./Modules/File Managment/FileRepoHandler.php";

/*$person = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
$action = new FileAction($person);
$name="hello.txt";

$handler= new FileRepoHandler($action);
$content=stream_get_contents($handler->getFile($name));
echo htmlspecialchars($content);


$content = fopen("index.php", "r");

$name="hello.txt";
if($handler->createFile($name,$content))
{
    echo 'yes';
}
else{echo 'no';}*/






























/*//Testing Search

    $person = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
    $action = new PersonAction($person);
    $arr = $action->searchForPeopleByNameOrEmail('Zi');
    foreach ($arr as $item) {
        echo $item->getFirstName();
        echo "</br>";
        echo $item->getImgRef();
        echo "</br>";

    }
$arr = $action->searchForPeopleByAcademicOrPhone('nul');
foreach ($arr as $item) {
    echo $item->getFirstName();
    echo "</br>";
    echo $item->getImgRef();
    echo "</br>";

}*/



/*//Testing Encryption
$msg="admin@gmail.com";
echo $cipher=EncryptionManager::Encrypt($msg);
echo"</br>";

echo EncryptionManager::Decrypt($cipher);*/



/*//Testing getPersonsOfInstitution
SessionManager::sessionSignIn('admin@gmail.com',2);
$person=Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
$Action=new InstitutionAction($person);
$arr=$Action->getPersonsOfInstitution(1);
$i=0;
while($i<count($arr))
{
    echo $arr[$i]->getFirstName();
    echo"</br>";
    $i++;

}*/
?>