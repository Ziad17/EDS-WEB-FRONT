
<?php

require_once "./Database/MainAction.php";
require_once './Business/Person.php';
try {
    $person = new Person("yh00@gmail.com",
        "1234567891234506",
        "hey",
        "noew",
        "now",
        "Facultyrrrr",
        "Female");
    $mainAction = new MainAction();
    $arr = $mainAction->getAllCities();
    print_r($arr);
    echo 'hey';
}
catch (Exception $e)
{
    echo $e->getMessage();

}
echo 'heyse';

