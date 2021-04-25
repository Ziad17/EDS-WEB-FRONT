<?php

require_once PERMISSIONS_BASE_PATH."/Permissions.php";


class PersonPermissions extends Permissions
{


    //FIXME: put all of these in db table
    public int $VIEW_PERSON_PROFILE=                        0; //2**0
    public int $VIEW_ALL_PERSONS_IN_INSTITUTION=            1; //2**1
    public int $VIEW_ALL_PERSONS_HIERARCHY=                 2; //2**2
    public int $DEACTIVATE_PERSON_WITHIN_INSTITUTION=       3;
    public int $CREATE_PERSON_WITHIN_INSTITUTION=         4;
    public int $DEACTIVATE_PERSON_OUTSIDE_INSTITUTION=      5;
    public int $ACTIVATE_PERSON_OUTSIDE_INSTITUTION=        6;
    public int $COUNT=7;



    public function __construct(int $permissionSum)
    {
        $this->permissions_bit_array=array(

        );
        $this->populatePermissionsArray($permissionSum,$this->COUNT);

    }







}

