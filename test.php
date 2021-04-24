<?php
// phpinfo();
require_once "./Modules/Database/PersonAction.php";
require_once "./Modules/Database/FileAction.php";
require_once "./Modules/Validation/ImageValidator.php";

require_once "./Modules/Database/MainAction.php";
require_once "./Modules/Permissions/InstitutionsPermissions.php";
require_once "./Modules/Database/InstitutionAction.php";
require_once "./Modules/Sessions/SessionManager.php";
require_once "./Modules/Encryption/EncryptionManager.php";
SessionManager::sessionSignIn('admin@gmail.com', 2);
require_once "./Modules/File Managment/FileRepoHandler.php";


$person = Person::Builder()->setID(SessionManager::getID())->setEmail(SessionManager::getEmail())->build();
$action = new FileAction($person);
$name = "test1.jpg";
//header('Content-Disposition: attachment; filename="' . $name . '"');
$handler = new FileRepoHandler($action);

$img=$handler->getImagePrivateURI('search.png');
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $file_name = strtolower($_FILES["fileToUpload"]["name"]);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));;
    $file_size_in_bytes = $_FILES["fileToUpload"]["size"];

    $isImage = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if ($isImage) {

        $validator = new ImageValidator();
        $error = '';
        $error = $validator->validateExtension($file_ext);
        $error = $validator->validateSize($file_size_in_bytes);
        $error = $validator->validateName($file_name);
        if ($error != '') {
            echo $error;
            return;
        }
        $content=file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
        if($handler->createImage($file_name,$content))
        {echo 'success';}
        else{echo 'fail';}
    } else {
        echo 'its not an image';
    }
}
//header('Content-Type: image/png');
//imagepng($im);

/*


$content = fopen("index.php", "r");
/*
$name="hello.txt";
if($handler->createFile($name,$content))
{
    echo 'yes';
}
else{echo 'no';}

*/


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


/*//Testing `````````getPersonsOfInstitution`````````
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

<!DOCTYPE html>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<img src=' <?php
if (isset($img) )
{
    echo $img;
}
else{echo 'img/logo (1).png';}?> 'class="card-img-top" alt="...">
</body>
</html>

