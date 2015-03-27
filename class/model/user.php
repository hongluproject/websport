<?php

namespace Model;

class User extends Core
{
    public static $table = 'user';
    public static $foreign_key = 'user_id';
    public static $belongs_to = array(
        'user' => '\Model\User',
    );

    public function isSuperAdmin()
    {
        return in_array($this->username, config('cas.admin'));
    }
}
