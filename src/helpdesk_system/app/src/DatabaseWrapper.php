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

    public function checkLoginDetails($username)
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
            die();
        }
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //Settings - Update Password
    public function getUserPassword($userId)
    {
        try{
            $connect = $this->openConnection();
            $query = "SELECT password FROM users WHERE userId = :user_id";
            $statement = $connect->prepare($query);
            $statement->bindValue(':user_id', $userId);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $error)
        {
            die();
        }
        return $row['password'];
    }

    public function updatePassword($userId, $new_hashed_password)
    {
        $result = false;
        try{
            $connect = $this->openConnection();
            $query = "UPDATE users SET password = :new_password, last_updated = CURRENT_TIMESTAMP WHERE userId = :userId";
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
            $query = "INSERT INTO tickets(userId, title, priority, category, description) VALUES(:user_id, :title, :priority, :category, :description)";
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
            die();
        }
        return $result;

    }
    public function getAllTickets()
    {
        try{
        $connect = $this->openConnection();
        $query = "SELECT tickets.*, users.username FROM tickets, users WHERE tickets.userId = users.userId and tickets.status = 'Open' ORDER BY tickets.created ASC;  ";
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
            $query = "select * from tickets where userId = :user_id ORDER BY status DESC;  ";
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
            $query = "UPDATE tickets SET status = 'Closed' WHERE id = :ticket_id;";
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
            $query = "select count(id) from tickets";
            $statement = $connect->query($query);
            $count = $statement->fetchColumn();
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
            $query = "select count(id) from tickets where status = 'Open'";
            $statement = $connect->query($query);
            $count = $statement->fetchColumn();
        }
        catch(PDOException $error)
        {
            die();
        }
        return $count;
    }
    public function getPriorityTicketCount(){
        try{
            $connect = $this->openConnection();
            $query = "select count(id) from tickets where priority = 'Low' and status = 'Open'";
            $statement = $connect->query($query);
            $count['low'] = $statement->fetchColumn();
            $query = "select count(id) from tickets where priority = 'Medium' and status = 'Open'";
            $statement = $connect->query($query);
            $count['medium'] = $statement->fetchColumn();
            $query = "select count(id) from tickets where priority = 'High' and status = 'Open'";
            $statement = $connect->query($query);
            $count['high'] = $statement->fetchColumn();
        }
        catch(PDOException $error)
        {
            die();
        }
        return $count;
    }
    public function getCommonCategory(){
        try{
            $connect = $this->openConnection();
            $query = "select count(id) from tickets where category = 'Hardware'";
            $statement = $connect->query($query);
            $category['hardware'] = $statement->fetchColumn();
            $query = "select count(id) from tickets where category = 'Account'";
            $statement = $connect->query($query);
            $category['account'] = $statement->fetchColumn();
            $query = "select count(id) from tickets where category = 'Software'";
            $statement = $connect->query($query);
            $category['software'] = $statement->fetchColumn();
            $query = "select count(id) from tickets where category = 'Other'";
            $statement = $connect->query($query);
            $category['other'] = $statement->fetchColumn();

        }        catch(PDOException $error)
        {
            die();
        }
        return $category;
    }

    public function getAverageDuration(){
        try{
            $connect = $this->openConnection();
            $query = "select created, closed from tickets where closed != ''";
            $statement = $connect->query($query);
            $ticket_times = $statement->fetchAll();
        }        catch(PDOException $error)
        {
            die();
        }
        return $ticket_times;
    }

    //Activity Logging
    public function logActivity($userId, $activity)
    {
        $result = false;
        try {
            $connect = $this->openConnection();
            $query = "INSERT INTO activity(userId, description) VALUES(:user_id, :description)";
            $statement = $connect->prepare($query);
            $statement->bindValue('user_id', $userId);
            $statement->bindValue('description', $activity);
            $activityInsert = $statement->execute();
            if($activityInsert)
            { $result = true; }
        }catch(PDOException $error)
        {
            die();
        }
        return $result;
    }

    public function insertUser($username, $password)
    {
        $result = false;
        try {
            $connect = $this->openConnection();
            $query = "INSERT INTO users(username, password) VALUES(:username, :password)";
            $statement = $connect->prepare($query);
            $statement->bindValue('username', $username);
            $statement->bindValue('password', $password);
            $activityInsert = $statement->execute();
            if($activityInsert)
            { $result = true; }
        }catch(PDOException $error)
        {
            die();
        }
        return $result;
    }



}