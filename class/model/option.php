<?php

namespace Model;

class Option extends Core
{
    public static $table = 'options';

    public static $body_fields = array('comment');

    public static $belongs_to = array(
        'user' => '\Model\User',
    );

}
