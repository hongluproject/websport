<?php

namespace Model;

/**
 * @property string $id
 * @property string $team_a
 * @property string $team_a_logo
 * @property string $team_b
 * @property string $team_b_logo
 * @property string $start_time
 * @property string $end_time
 * @property string $channel_ids
 * @property string $details
 * @property string $touzhu
 * @property string $background
 * @property User $user
 */
class Team extends Core
{
    public static $table = 'ma_team';

    public static $belongs_to = array(
        'user' => '\Model\User',
    );



}
