<?php


abstract class Action
{
    protected DatabaseConnection $databaseConnection;

    /**
     * Action constructor.
     * @param DatabaseConnection $databaseConnection
     */

    /**
     * @return DatabaseConnection
     */
    public function getDatabaseConnection(): DatabaseConnection
    {
        return $this->databaseConnection;
    }

}