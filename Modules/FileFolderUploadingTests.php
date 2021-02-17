<?php

$myRef=Person::Builder()->setID(16)->build();
$folderAction=new FolderAction($myRef);


$folderToCreate=new Folder();
$fileToCreate=new File()