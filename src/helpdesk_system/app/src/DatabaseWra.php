<?php

namespace HelpdeskSystem;

use PDO;
use PDOException;

class DatabaseWra
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

    public function checkLoginDetails($username, $userPassword): int
    {
        try{
            $connect = $this->openConnection();
            $query = "SELECT username, password FROM users WHERE username = :username AND password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username' => $username,
                    'password' => $userPassword
                )
            );
            $resultCount = $statement->rowCount();
            if($resultCount > 0 ){
                $_SESSION['usernameLogin'] = $username;
                return 1;
            }
        } catch(PDOException $error)
        {
            $message = $error->getMessage();
            return 0;
        }
        return 0;
    }

    //Get user info from username

    //Check if user info matches for logging in


    //Update password

    //Get all tickets

    //Get all tickets by given user

    //Get amount of tickets

    //Get amount of open tickets

}