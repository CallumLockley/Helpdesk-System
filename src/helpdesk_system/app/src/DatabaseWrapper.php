<?php

namespace HelpdeskSystem;

use PDO;
use PDOException;

class DatabaseWrapper
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }


    public function openConnection()
    {
        $dsn = "mysql:host=localhost;dbname=helpdesk_system;charset=UTF8";
        try {
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            return new PDO($dsn, 'root', '', $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function checkLoginDetails($username, $password)
    {
        $password_result = false;
        try{
            $connect = $this->openConnection();
            $query = "SELECT password, permission FROM users WHERE username = :username";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username' => $username
                )
            );
        } catch(PDOException $error)
        {
            $message = $error->getMessage();
            die();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (is_array($row))
        {
            if (password_verify($password, $row['password']))
            {
                $_SESSION['username'] = $username;
                $_SESSION['userPerms'] = $row['permission'];
                $password_result = true;
            }
        }
        return $password_result;
    }


    //Update password

    //Get all tickets

    //Get all tickets by given user

    //Get amount of tickets

    //Get amount of open tickets

}