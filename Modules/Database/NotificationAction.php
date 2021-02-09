<?php


class NotificationAction extends Action
{

    /**
     * NotificationAction constructor.
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->myPersonRef = $person;
    }

    public function getNotificationsByQuery($query,$params): array //of Notifications
    {
        $con = $this->getDatabaseConnection();
        $stmt = $this->getParameterizedStatement($query, $con, $params);
        if ($stmt == false) {
            $this->closeConnection($con);
            throw new SQLStatmentException("Could not fetch notification information");
        }
        if (!sqlsrv_has_rows($stmt)) {
            $this->closeConnection($con);
            throw new NoNotificationsFoundException("Could not fetch notification information");
        }
        $arrayOfNotifications = array();
        while ($row = sqlsrv_fetch($stmt)) {
            $ID = $row[0];

            $notificationName = $row[1];
            $seen = $row[2];
            $fileID = $row[3];
            $dateCreated = $row[5];
            $senderEmail = $row[6];
            $senderFirstName = $row[7];
            $senderMiddleName = $row[8];
            $senderLastName = $row[9];
            $notification = new Notification($ID,
                $notificationName,
                $senderEmail,
                $senderFirstName,
                $senderMiddleName,
                $senderLastName,
                $seen, $dateCreated, $fileID);
            $arrayOfNotifications[]=$notification;
        }
        return $arrayOfNotifications;
    }

    public function getAllNotifications(): array
    {
        $sql = "SELECT * FROM Notification_view WHERE Notification.person_id=? GROUP BY date_created ASC";
        $params = array($this->myPersonRef->getID());
        return $this->getNotificationsByQuery($sql,$params);
    }

    public function getUnreadNotifications(): array
    {
        $sql = "SELECT * FROM Notification_view WHERE Notification.person_id=? AND seen=? GROUP BY date_created ASC";
        $params = array($this->myPersonRef->getID(),false);
        return $this->getNotificationsByQuery($sql,$params);
    }
    public function getReadNotifications(): array
    {
        $sql = "SELECT * FROM Notification_view WHERE Notification.person_id=? AND seen=? GROUP BY date_created ASC";
        $params = array($this->myPersonRef->getID(),true);
        return $this->getNotificationsByQuery($sql,$params);
    }
    public function markNotificationAsRead(int $notificationID): bool
    {
        $con=$this->getDatabaseConnection();
        $sql="UPDATE PersonNotification SET seen=? WHERE PersonNotification.ID=? AND PersonNotification.person_id=?";
        $params=array(true,$notificationID,$this->myPersonRef->getID());
        $stmt=$this->getParameterizedStatement($sql,$con,$params);
        if($stmt==false)
        {
            $this->closeConnection($con);
            throw new SQLStatmentException("This Notification can not be read");
        }
        if(sqlsrv_rows_affected($stmt)==false)
        {
            $this->closeConnection($con);
            return false;
        }
        return true;

    }
    public function markArrayOfNotificationsAsRead(array $array)
    {
        foreach ($array as $notification)
        {
            $this->markNotificationAsRead($notification->getID());
        }

    }


}