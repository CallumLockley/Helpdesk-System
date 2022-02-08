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

    //Settings - Update Password
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

    //Ticket
    public function createTicket($userId, $ticket_content)
    {
        $result = false;
        try{
            $connect = $this->openConnection();
            $query = "INSERT INTO tickets(user_id, title, priority, category, description) VALUES(:user_id, :title, :priority, :category, :description)";
            $statement = $connect->prepare($query);
            var_dump($userId);
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
    public function getAllTickets()
    {
        try{
        $connect = $this->openConnection();
        $query = "SELECT tickets.*, users.username FROM tickets, users WHERE tickets.user_id = users.userId and tickets.status = 'Open' ORDER BY tickets.created ASC;  ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $tickets = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $error)
    {
        die();
    }
        return $tickets;

    }
    public function getUsersTickets($userId)
    {
        try{
            $connect = $this->openConnection();
            $query = "select * from tickets where user_id = :user_id ORDER BY created ASC;  ";
            $statement = $connect->prepare($query);
            $statement->bindParam(':user_id', $userId);
            $statement->execute();
            $tickets = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $error)
        {
        die();
        }
        return $tickets;
    }
    public function getSpecificTicket($ticketId)
    {
        try{
            $connect = $this->openConnection();
            $query = "select * from tickets where id = :ticketId;";
            $statement = $connect->prepare($query);
            $statement->bindParam(':ticketId', $ticketId);
            $statement->execute();
            $tickets = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $error)
        {
            die();
        }
        return $tickets;
    }

    public function resolveTicket($ticketId){
        $result = false;
        try{
            $connect = $this->openConnection();
            $query = "UPDATE tickets SET status = 'closed' WHERE id = :ticket_id;";
            $statement = $connect->prepare($query);
            $statement->bindParam(':ticket_id', $ticketId);
            $updated = $statement->execute();
            if($updated) {
                $result = true;
            }
        }catch(PDOException $error)
        {
            var_dump($error->getMessage());
            die();
        }
        return $result;
    }

    //Comments
    public function getTicketsComment($ticketId)
    {
        try{
            $connect = $this->openConnection();
            $query = "select comments.message, comments.created, users.username from comments INNER JOIN users on comments.userId=users.userId where comments.ticketId = :ticket_id ORDER BY comments.created DESC; ";
            $statement = $connect->prepare($query);
            $statement->bindParam(':ticket_id', $ticketId);
            $statement->execute();
            $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

        }  catch(PDOException $error)
        {
            die();
        }
        return $comments;
    }
    public function newComment($ticketId, $userId, $message)
    {
        $result = false;
        try{
            $connect = $this->openConnection();
            $query = "INSERT INTO comments(ticketId, userId, message) VALUES(:ticket_id, :user_id, :message)";
            $statement = $connect->prepare($query);
            $statement->bindValue('ticket_id', $ticketId);
            $statement->bindValue('user_id', $userId);
            $statement->bindValue('message', $message);
            $insert = $statement->execute();

            if($insert){
                $result = true;
            }
        }catch (PDOException $error)
        {
            var_dump($error);
            die();
        }
        return $result;
    }

    //Admin Panel
    public function getAmountTickets()
    {
        try{
            $connect = $this->openConnection();
            $query = "select * from tickets";
            $statement = $connect->query($query);
            $count = $statement->rowCount();
        }
        catch(PDOException $error)
        {
            die();
        }
        return $count;
    }
    public function getAmountTicketsOpen()
    {
        try{
            $connect = $this->openConnection();
            $query = "select * from tickets where status = 'open'";
            $statement = $connect->query($query);
            $count = $statement->rowCount();
        }
        catch(PDOException $error)
        {
            die();
        }
        return $count;
    }
}