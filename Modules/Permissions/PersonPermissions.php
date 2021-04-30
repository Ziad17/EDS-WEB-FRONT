<?php
require_once 'Permissions.php';



class PersonPermissions extends Permissions
{


    //FIXME: put all of these in db table
    public int $VIEW_PERSON_PROFILE=                        0; //2**0
    public int $VIEW_ALL_PERSONS_HIERARCHY=                 1; //2**2
    public int $DEACTIVATE_PERSON_WITHIN_INSTITUTION=       2;
    public int $CREATE_PERSON_WITHIN_INSTITUTION=           3;
    public int $COUNT=4;



    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array=array(

        );
        $this->populatePermissionsArray($permissionSum,$this->COUNT);

    }







}

