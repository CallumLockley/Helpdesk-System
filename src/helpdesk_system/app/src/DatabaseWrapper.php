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
            $query = "SELECT userId, password, permission FROM users WHERE username = :username";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username' => $username
                )
            );
        } catch(PDOException $error)
        {
            var_dump($error->getMessage());
            die();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (is_array($row))
        {
            if (password_verify($password, $row['password']))
            {
                session_reset();
                $_SESSION['user_id'] = $row['userId'];
                $_SESSION['username'] = $username;
                $_SESSION['userPerms'] = $row['permission'];
                $password_result = true;
            }else{
                $_SESSION['loginError'] = true;
            }
        }
        return $password_result;
    }

    //Get User Current Password
    public function getUserPassword($userId)
    {
        try{
            $connect = $this->openConnection();
            $query = "SELECT password FROM users WHERE userId = :userId";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'userId' => $userId,

                )
            );
            $result=true;
        }catch(PDOException $error)
        {
            var_dump($error->getMessage());
            die();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);


        return $row['password'];
    }
    //Update password
    public function updatePassword($userId, $new_hashed_password)
    {
        $result = false;
        try{
            $connect = $this->openConnection();
            $query = "UPDATE users SET password = :new_password WHERE userId = :userId";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'userId' => $userId,
                    'new_password' => $new_hashed_password
                )
            );
            $result=true;
        }catch(PDOException $error)
        {
            var_dump($error->getMessage());
            die();
        }

        return $result;
    }

    //Create Ticket
    public function createTicket($userId, $ticket_content)
    {
        $result = false;
        try{
            $connect = $this->openConnection();
            $query = "INSERT INTO tickets(user_id, title, priority, category, description) VALUES(:user_id, :title, :priority, :category, :description)";
            $statement = $connect->prepare($query);
            $statement->bindValue('user_id', $userId);
            $statement->bindValue('title', $ticket_content['title']);
            $statement->bindValue('priority', $ticket_content['priority']);
            $statement->bindValue('category', $ticket_content['category']);
            $statement->bindValue('description', $ticket_content['description']);

            $insert = $statement->execute();

            if($insert)
            { $result = true; }

        }catch(PDOException $error)
        {
            var_dump($error->getMessage());
            die();
        }
        return $result;

    }

    //Get all tickets

    //Get all tickets by given user
    public function getUsersTickets($userId)
    {
        try{
            $connect = $this->openConnection();
            $query = "select * from tickets";
            $statement = $connect->query($query);
            $tickets = $statement->fetchAll(PDO::FETCH_ASSOC);
            var_dump($tickets);
        }
        catch(PDOException $error)
        {
        die();
        }
    }

    //Get amount of tickets

    //Get amount of open tickets

}