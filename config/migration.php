<?php

define('EZ_FILED_INT', 'integer');
define('EZ_FILED_STR', 'string');
define('EZ_FILED_PRI', 'primary');
define('EZ_FILED_DTM', 'datetime');

if (!function_exists('ezField'))
{
    function ezField($type = EZ_FILED_INT, $length = false)
    {
        $field = array(
            'type'   => $type,
        );
        if ($length) $field['length'] = $length;
        return $field;
    }
}

// 宏定义
$field = array(
    'id'          => ezField(EZ_FILED_PRI),
    'type'        => ezField(EZ_FILED_STR, 50),
    'title'       => ezField(EZ_FILED_STR, 100),
    'user_id'     => ezField(EZ_FILED_INT, 2147483647),
    'zt_id'       => ezField(EZ_FILED_INT, 2147483647),
    'body'        => ezField(EZ_FILED_STR, 65535),
    'create_time' => ezField(EZ_FILED_DTM, 100),
    'modify_time' => ezField(EZ_FILED_DTM, 100),
    'status'      => ezField(EZ_FILED_INT, 1),
    'pb_status'   => ezField(EZ_FILED_INT, 1),
    'message'     => ezField(EZ_FILED_STR, 255),
);

return array(
    'dp_users'         => array(
        'id'          => $field['id'],
        'username'    => ezField(EZ_FILED_STR, 32),
        'mail'        => ezField(EZ_FILED_STR, 100),
        'body'        => $field['body'],
        'admin'       => $field['status'],
        'status'      => $field['status'],
        'user_id'     => $field['user_id'],
        'modify_time' => $field['modify_time'],
        'create_time' => $field['create_time'],
    ),

    'dp_options'       => array(
        'id'          => $field['id'],
        'key'         => ezField(EZ_FILED_STR, 255),
        'value'       => ezField(EZ_FILED_STR, 255),
        'body'        => $field['body'],
        'user_id'     => $field['user_id'],
        'modify_time' => $field['modify_time'],
        'create_time' => $field['create_time'],
    ),

    'dp_matches'       => array(
        'id'          => $field['id'],
        'title'       => ezField(EZ_FILED_STR, 255),
        'body'        => $field['body'],
        'user_id'     => $field['user_id'],
        'modify_time' => $field['modify_time'],
        'create_time' => $field['create_time'],
    ),

    'dp_horn'      => array(
        'id'          => $field['id'],
        'pbid'          => $field['id'],
        'ids'          => $field['type'],
        'body'        => $field['body'],
        'pb_status'   => $field['pb_status'],
        'user_id'     => $field['user_id'],
        'modify_time' => $field['modify_time'],
        'create_time' => $field['create_time'],
    ),

    'dp_horn'      => array(
        'id'          => $field['id'],
        'pbid'          => $field['id'],
        'ids'          => $field['type'],
        'body'        => $field['body'],
        'pb_status'   => $field['pb_status'],
        'user_id'     => $field['user_id'],
        'modify_time' => $field['modify_time'],
        'create_time' => $field['create_time'],
    ),

    'dp_horn_channel'      => array(
        'id'          => $field['id'],
        'channel_key'   => $field['title'],
        'status'     => $field['status'],
        'create_time' => $field['create_time'],
    ),

    'dp_horn_conf'      => array(
        'id'          => $field['id'],
        'title'   => $field['title'],
        'status'     => $field['status'],
        'modify_time' => $field['modify_time'],
    ),
    'news' =>array(
        'link'=>$field['link'],
        'cover_pic'=>$field['cover_pic'],
    )
);