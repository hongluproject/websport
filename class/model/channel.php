<?php

namespace Model;

class Channel extends Core
{

    public static $belongs_to = array(
        'user' => '\Model\User',
    );

}
