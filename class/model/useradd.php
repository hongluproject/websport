<?php

namespace Model;

class Useradd extends Core
{

    public static $table = 'user';

    public static $belongs_to = array(
        'user' => '\Model\User',
    );



}
