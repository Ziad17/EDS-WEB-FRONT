<?php /** @noinspection ALL */


class SearchAction extends Action
{

    private array $query;

    public function __construct(Person $myPersonRef)
    {
        parent::setConnection($this);
        $this->myPersonRef = $myPersonRef;

    }


    public function prepareQuery(string $textQuery): bool
    {
        $names = explode(" ", trim($textQuery));
        if (empty($names) || $names == array() || $names[0] == "" || $names[0] == " ") {
            return false;
        } else {
            $this->query = $names;
            return true;
        }


    }

    public function searchForPeople(): array  //of persons
    {

        $sql = "";
        if (count($this->query) < 1) {
            throw new SearchQueryInsuffecient("The query set is empty");
        }
        if (count($this->query) == 1) {
            $sql = "SELECT first_name,
       middle_name,
       last_name,
       institution_id,
       image_ref,
       contact_email,
       employee_title,
       institution_id
       FROM PersonsHierarchy_view WHERE first_name LIKE %?% AND NOT ID=?";
            $params = array($this->query[0],$this->myPersonRef->getID());


        } else if (count($this->query) == 2) {
            $sql = "SELECT first_name,
       middle_name,
       last_name,
       institution_id,
       image_ref,
       contact_email,
       employee_title,
       institution_id
       FROM PersonsHierarchy_view WHERE first_name LIKE %?% AND middle_name LIKE %?% AND NOT ID=?";
            $params = array($this->query[0],$this->query[1],$this->myPersonRef->getID());

        } else if (count($this->query) >= 3) {
            $sql = "SELECT first_name,
       middle_name,
       last_name,
       institution_id,
       image_ref,
       contact_email,
       employee_title,
       FROM PersonsHierarchy_view WHERE first_name LIKE %?% AND middle_name LIKE %?% AND last_name LIKE %?% AND NOT ID=?";
            $params = array($this->query[0],$this->query[1],$this->query[2],$this->myPersonRef->getID());
        }
        else{
            throw new SearchQueryInsuffecient("The query set is empty");

        }
        if ($sql == "" || empty($sql)) {
            throw new SearchQueryInsuffecient("The query set is empty");
        }

        $con = $this->getDatabaseConnection();
        $stmt = $this->getParameterizedStatement($sql, $con, $params);
        if(!$stmt)
        {
            throw new SQLStatmentException("failed to search for this person");
        }
        $matchs=array();
        while ($row=sqlsrv_fetch_array($stmt))
        {
            $first_name=$row[0];
            $middle_name=$row[1];
            $last_name=$row[2];
            $institution_id=$row[3];
            $image_ref=$row[4];
            $contact_email=$row[5];
            $employee_title=$row[6];

            $role=new PersonRole($employee_title,0,"",$this->getInstitutionNameByID($institution_id));
            $person=Person::Builder()->setFirstName($first_name)
                ->setMiddleName($middle_name)
                ->setLastName($last_name)
                ->setImgRef($image_ref)
                ->setRoles(array($role))
                ->build();
            $matchs[]=$person;

        }
        $this->closeConnection($con);
        return $matchs;



    }

    public function searchForInstitutions(): array //of institutions
    {
        $con=$this->getDatabaseConnection();
        $sql="SELECT * FROM Institutuion_view WHERE institution_name LIKE %?%";
        $params=array(implode($this->query));
        $stmt=$this->getParameterizedStatement($sql,$con,$params);
        if(!$stmt)
        {
            throw new SQLStatmentException("failed to search for this institution");
        }
        $matchs=array();
        while ($row=sqlsrv_fetch_array($stmt))
        {
            $institution_name=$row[0];
            $institution_contacts_website=$row[1];
            $inside_campus=$row[2];
            $primary_phone=$row[3];
            $secondary_phone=$row[4];
            $email=$row[5];
            $ID=$row[6];

          $intitution=new Institution($institution_name,$institution_contacts_website,$inside_campus,"","");
            $matchs[]=$intitution;

        }
        $this->closeConnection($con);
        return $matchs;



    }

    public function searchForFiles(): array //of files
    {
        $con=$this->getDatabaseConnection();
        $sql="SELECT * FROM FilesAttachedToRoles_view WHERE version_name LIKE %?% AND person_id=? AND file_permissions_sum>=1 AND exp_date<=GETDATE() AND active=1";
        $params=array(implode($this->query),$this->myPersonRef->getID());
        $stmt=$this->getParameterizedStatement($sql,$con,$params);
        if(!$stmt)
        {
            throw new SQLStatmentException("failed to search for this file");
        }
        $matchs=array();
        while ($row=sqlsrv_fetch_array($stmt))
        {
            $ID=$row[0];
            $parent_folder_id=$row[1];
            $date_created=$row[2];
            $author_id=$row[3];
            $current_file_version=$row[4];
            $active=$row[5];
            $locked=$row[6];
            $locked_until=$row[7];
            $person_id=$row[8];
            $file_permissions_sum=$row[9];
            $exp_date=$row[10];
            $version_name=$row[11];
            $file_version_size=$row[12];
            $file_type_extension=$row[13];

            $fileVersion=new FileVersion($current_file_version,$ID,"",$version_name,"","",$file_type_extension,0,null,$file_version_size);
            $file=new File($ID,$this->getNameFromPersonId($author_id),$date_created,$parent_folder_id,$fileVersion,null,$locked,$locked_until,$active);
            $matchs[]=$file;

        }
        $this->closeConnection($con);
        return $matchs;

    }

    public function searchForFolders(): array //of folders
    {

    }


}