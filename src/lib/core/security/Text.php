<?php

namespace rave\lib\core\security;

class Text
{

    public static function clean($data)
    {
        return filter_var(trim($data), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public static function isEmail($email)
    {
    	return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
	
}