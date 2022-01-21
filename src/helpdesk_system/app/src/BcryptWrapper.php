<?php

namespace HelpdeskSystem;

class BcryptWrapper
{
    public function generateHash($string): string
    {
        $hashed_password = '';
        if(!empty($string))
        {
            $options= array('cost'=>BCRYPT_COST);
            $hashed_password = password_hash($string.BCRYPT_SALT, BCRYPT_AL,$options);
        }
        return $hashed_password;
    }
}