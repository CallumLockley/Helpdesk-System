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


}