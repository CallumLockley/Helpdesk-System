<?php

namespace HelpdeskSystem;

class BcryptWrapper
{
    public function authenticateHash($string_check, $string_compare): bool
    {
        $authenticated = false;
        if(!empty($string_check) && !empty($string_compare)){
            if(password_verify($string_check,$string_compare))
            {
                $authenticated = true;
            }
        }
        return $authenticated;
    }

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