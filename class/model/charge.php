<?php

namespace Model;


class Charge extends Core
{
    public static $table = 'orderlist';

    public static $belongs_to = array(
        'user' => '\Model\User',
    );


    public function save()
    {
        return parent::save();
    }

}
