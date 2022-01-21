<?php

namespace HelpdeskSystem;

class Validator
{
    public function __construct()
    {
    }
    public function __destruct()
    {
    }

    public function validateEmail($tainted_email)
    {
        return  filter_var($tainted_email, FILTER_VALIDATE_EMAIL);
    }

    public function validateUpdatedPassword($tainted_password): bool
    {
        $validated = "yes";
        $password_length = 8;
        var_dump($tainted_password);
        $to_check_password = filter_var($tainted_password, FILTER_SANITIZE_STRING);
var_dump($to_check_password);

        $uppercase = preg_match('#[A-Z]#', $to_check_password);
        $lowercase = preg_match('#[a-z]#', $to_check_password);
        $number    = preg_match('#[0-9]#', $to_check_password);
        $special   = preg_match('#[^\w]#', $to_check_password);
        $length    = strlen($to_check_password) >= 8;

        if(!$uppercase || !$lowercase || !$number || !$special || !$length) {
            $validated = 'Bad Password';
        }
        return $validated;
    }

}