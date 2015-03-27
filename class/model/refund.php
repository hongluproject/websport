<?php

namespace Model;


class Refund extends Core
{
    public static $table = 'refund';

    public static $belongs_to = array(
        'user' => '\Model\User',
    );


    public function save()
    {
        return parent::save();
    }

}
