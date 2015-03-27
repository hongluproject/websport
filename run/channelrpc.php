<?php


class SortListInput


{


    /**


     * 当前页


     * @var int


     */


    public $nowPage = 1;






    /**


     * 每页数据


     * @var int


     */


    public $pageSize = 30;





    /**


     * 地区码


     * @var int


     */


    public $areaCode = 0;






    /**


     * 分类ID


     * @var int


     */


    public $cataId = -1;






    /**


     * 年代


     * @var int


     */


    public $year = -1;






    /**


     * 排序方式:


     * 0 :热度


     * 1 :更新时间


     * 2 :权重


     * 3 :名称


     * 4 :评分


     * 5 :总人气


     * 6 :7天的人气


     * 7 :30天的人气


     * 8 :上升最快(播放次数差)


     * 9 :上升最快(排名差)


     * 10:评论数11:直播在线人数12: 顶踩比率


     * @var int


     */


    public $sortType = 0;






    /**


     * 地区


     * @var string


     */


    public $areas = '';






    /**


     * 是否vip


     * -1表示不过滤，0表示只返回非VIP内容，1表示只返回VIP内容


     * @var int


     */


    public $vip = -1;






    /**


     * @var string


     */


    public $source = '';






    /**


     * 1=剧场版,2=OVA,3=完结,4=连载,5=新番


     * @var int


     */


    public $videoStatus = 0;






    /**


     * 0=常规,1=高清,2=蓝光,3=抢先版,4=片花


     * @var int


     */


    public $videoType = -1;






    /**


     * 视频类型，0=直播,3=点播，4=二代直播,21=剧集,22=合集 以“,”隔开，如：“0,4”


     * @var string


     */


    public $vt = '';






    /**


     * 内容类型，0=正片，1=预告，2=花絮（99为非正片）


     * @var int


     */


    public $conType = -1;






    /**


     * 版权 （1：有版权）


     * @var int


     */


    public $copyright = -1;

    /**


     * 我方是否独家(0:否，1：是)


     * @var int


     */


    public $pptvOnly = 0;






    /**


     * 最后更新时间(0:最近24h，1：最近一周 ，2：最近一个月， 3：最近3个月)


     * @var int


     */


    public $update = -1;






    /**


     * 百科类型（动作，爱情...）


     * @var string


     */


    public $bkClass = '';






    /**


     * 付费信息


     * @var int


     */


    public $payInfo = -1;






    /**


     * 码流率


     * @var int


     */


    public $ft = -1;






    /**


     * 1表示VIP用户，0表示普通用户，对VIP用户使用强制地区屏蔽


     * @var int


     */


    public $userLevel = 0;






    public $coolUser = 0;


}






if (!extension_loaded('xxtea')) {


    function long2str($v, $w) {


        $len = count($v);


        $n = ($len - 1) << 2;


        if ($w) {


            $m = $v[$len - 1];


            if (($m < $n - 3) || ($m > $n)) return false;


            $n = $m;


        }


        $s = array();


        for ($i = 0; $i < $len; $i++) {


            $s[$i] = pack("V", $v[$i]);


        }


        if ($w) {


            return substr(join('', $s), 0, $n);


        }


        else {


            return join('', $s);


        }


    }






    function str2long($s, $w) {


        $v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3));


        $v = array_values($v);


        if ($w) {


            $v[count($v)] = strlen($s);


        }


        return $v;


    }






    function int32($n) {


        while ($n >= 2147483648) $n -= 4294967296;


        while ($n <= -2147483649) $n += 4294967296;


        return (int)$n;


    }






    function xxtea_encrypt($str, $key) {


        if ($str == "") {


            return "";


        }


        $v = str2long($str, true);


        $k = str2long($key, false);


        if (count($k) < 4) {


            for ($i = count($k); $i < 4; $i++) {


                $k[$i] = 0;


            }


        }


        $n = count($v) - 1;






        $z = $v[$n];


        $y = $v[0];


        $delta = 0x9E3779B9;


        $q = floor(6 + 52 / ($n + 1));


        $sum = 0;


        while (0 < $q--) {


            $sum = int32($sum + $delta);


            $e = $sum >> 2 & 3;


            for ($p = 0; $p < $n; $p++) {


                $y = $v[$p + 1];


                $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));


                $z = $v[$p] = int32($v[$p] + $mx);


            }


            $y = $v[0];


            $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));


            $z = $v[$n] = int32($v[$n] + $mx);


        }


        return long2str($v, false);


    }






    function xxtea_decrypt($str, $key) {


        if ($str == "") {


            return "";


        }


        $v = str2long($str, false);


        $k = str2long($key, false);


        if (count($k) < 4) {


            for ($i = count($k); $i < 4; $i++) {


                $k[$i] = 0;


            }


        }


        $n = count($v) - 1;






        $z = $v[$n];


        $y = $v[0];


        $delta = 0x9E3779B9;


        $q = floor(6 + 52 / ($n + 1));


        $sum = int32($q * $delta);


        while ($sum != 0) {


            $e = $sum >> 2 & 3;


            for ($p = $n; $p > 0; $p--) {


                $z = $v[$p - 1];


                $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));


                $y = $v[$p] = int32($v[$p] - $mx);


            }


            $z = $v[$n];


            $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));


            $y = $v[0] = int32($v[0] - $mx);


            $sum = int32($sum - $delta);


        }


        return long2str($v, true);


    }


}






class PHPRPC_Date {






// public fields






    var $year = 1;


    var $month = 1;


    var $day = 1;


    var $hour = 0;


    var $minute = 0;


    var $second = 0;


    var $millisecond = 0;






// constructor






    function PHPRPC_Date() {


        $num = func_num_args();


        $time = false;


        if ($num == 0) {


            $time = getdate();


        }


        if ($num == 1) {


            $arg = func_get_arg(0);


            if (is_int($arg)) {


                $time = getdate($arg);


            }


            elseif (is_string($arg)) {


                $time = getdate(strtotime($arg));


            }


        }


        if (is_array($time)) {


            $this->year = $time['year'];


            $this->month = $time['mon'];


            $this->day = $time['mday'];


            $this->hour = $time['hours'];


            $this->minute = $time['minutes'];


            $this->second = $time['seconds'];


        }


    }






// public instance methods






    function addMilliseconds($milliseconds) {


        if (!is_int($milliseconds)) return false;


        if ($milliseconds == 0) return true;


        $millisecond = $this->millisecond + $milliseconds;


        $milliseconds = $millisecond % 1000;


        if ($milliseconds < 0) {


            $milliseconds += 1000;


        }


        $seconds = (int)(($millisecond - $milliseconds) / 1000);


        $millisecond = (int)$milliseconds;


        if ($this->addSeconds($seconds)) {


            $this->millisecond = (int)$milliseconds;


            return true;


        }


        else {


            return false;


        }


    }






    function addSeconds($seconds) {


        if (!is_int($seconds)) return false;


        if ($seconds == 0) return true;


        $second = $this->second + $seconds;


        $seconds = $second % 60;


        if ($seconds < 0) {


            $seconds += 60;


        }


        $minutes = (int)(($second - $seconds) / 60);


        if ($this->addMinutes($minutes)) {


            $this->second = (int)$seconds;


            return true;


        }


        else {


            return false;


        }


    }






    function addMinutes($minutes) {


        if (!is_int($minutes)) return false;


        if ($minutes == 0) return true;


        $minute = $this->minute + $minutes;


        $minutes = $minute % 60;


        if ($minutes < 0) {


            $minutes += 60;


        }


        $hours = (int)(($minute - $minutes) / 60);


        if ($this->addHours($hours)) {


            $this->minute = (int)$minutes;


            return true;


        }


        else {


            return false;


        }


    }






    function addHours($hours) {


        if (!is_int($hours)) return false;


        if ($hours == 0) return true;


        $hour = $this->hour + $hours;


        $hours = $hour % 24;


        if ($hours < 0) {


            $hours += 24;


        }


        $days = (int)(($hour - $hours) / 24);


        if ($this->addDays($days)) {


            $this->hour = (int)$hours;


            return true;


        }


        else {


            return false;


        }


    }






    function addDays($days) {


        if (!is_int($days)) return false;


        $year = $this->year;


        if ($days == 0) return true;


        if ($days >= 146097 || $days <= -146097) {


            $remainder = $days % 146097;


            if ($remainder < 0) {


                $remainder += 146097;


            }


            $years = 400 * (int)(($days - $remainder) / 146097);


            $year += $years;


            if ($year < 1 || $year > 9999) return false;


            $days = $remainder;


        }


        if ($days >= 36524 || $days <= -36524) {


            $remainder = $days % 36524;


            if ($remainder < 0) {


                $remainder += 36524;


            }


            $years = 100 * (int)(($days - $remainder) / 36524);


            $year += $years;


            if ($year < 1 || $year > 9999) return false;


            $days = $remainder;


        }


        if ($days >= 1461 || $days <= -1461) {


            $remainder = $days % 1461;


            if ($remainder < 0) {


                $remainder += 1461;


            }


            $years = 4 * (int)(($days - $remainder) / 1461);


            $year += $years;


            if ($year < 1 || $year > 9999) return false;


            $days = $remainder;


        }


        $month = $this->month;


        while ($days >= 365) {


            if ($year >= 9999) return false;


            if ($month <= 2) {


                if ((($year % 4) == 0) ? (($year % 100) == 0) ? (($year % 400) == 0) : true : false) {


                    $days -= 366;


                }


                else {


                    $days -= 365;


                }


                $year++;


            }


            else {


                $year++;


                if ((($year % 4) == 0) ? (($year % 100) == 0) ? (($year % 400) == 0) : true : false) {


                    $days -= 366;


                }


                else {


                    $days -= 365;


                }


            }


        }


        while ($days < 0) {


            if ($year <= 1) return false;


            if ($month <= 2) {


                $year--;


                if ((($year % 4) == 0) ? (($year % 100) == 0) ? (($year % 400) == 0) : true : false) {


                    $days += 366;


                }


                else {


                    $days += 365;


                }


            }


            else {


                if ((($year % 4) == 0) ? (($year % 100) == 0) ? (($year % 400) == 0) : true : false) {


                    $days += 366;


                }


                else {


                    $days += 365;


                }


                $year--;


            }


        }


        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);


        $day = $this->day;


        while ($day + $days > $daysInMonth) {


            $days -= $daysInMonth - $day + 1;


            $month++;


            if ($month > 12) {


                if ($year >= 9999) return false;


                $year++;


                $month = 1;


            }


            $day = 1;


            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);


        }


        $day += $days;


        $this->year = $year;


        $this->month = $month;


        $this->day = $day;


        return true;


    }






    function addMonths($months) {


        if (!is_int($months)) return false;


        if ($months == 0) return true;


        $month = $this->month + $months;


        $months = ($month - 1) % 12 + 1;


        if ($months < 1) {


            $months += 12;


        }


        $years = (int)(($month - $months) / 12);


        if ($this->addYears($years)) {


            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $months, $this->year);


            if ($this->day > $daysInMonth) {


                $months++;


                $this->day -= $daysInMonth;


            }


            $this->month = (int)$months;


            return true;


        }


        else {


            return false;


        }


    }






    function addYears($years) {


        if (!is_int($years)) return false;


        if ($years == 0) return true;


        $year = $this->year + $years;


        if ($year < 1 || $year > 9999) return false;


        $this->year = $year;


        return true;


    }






    function after($when) {


        if (!is_a($when, 'PHPRPC_Date')) {


            $when = PHPRPC_Date::parse($when);


        }


        if ($this->year < $when->year) return false;


        if ($this->year > $when->year) return true;


        if ($this->month < $when->month) return false;


        if ($this->month > $when->month) return true;


        if ($this->day < $when->day) return false;


        if ($this->day > $when->day) return true;


        if ($this->hour < $when->hour) return false;


        if ($this->hour > $when->hour) return true;


        if ($this->minute < $when->minute) return false;


        if ($this->minute > $when->minute) return true;


        if ($this->second < $when->second) return false;


        if ($this->second > $when->second) return true;


        if ($this->millisecond < $when->millisecond) return false;


        if ($this->millisecond > $when->millisecond) return true;


        return false;


    }






    function before($when) {


        if (!is_a($when, 'PHPRPC_Date')) {


            $when = new PHPRPC_Date($when);


        }


        if ($this->year < $when->year) return true;


        if ($this->year > $when->year) return false;


        if ($this->month < $when->month) return true;


        if ($this->month > $when->month) return false;


        if ($this->day < $when->day) return true;


        if ($this->day > $when->day) return false;


        if ($this->hour < $when->hour) return true;


        if ($this->hour > $when->hour) return false;


        if ($this->minute < $when->minute) return true;


        if ($this->minute > $when->minute) return false;


        if ($this->second < $when->second) return true;


        if ($this->second > $when->second) return false;


        if ($this->millisecond < $when->millisecond) return true;


        if ($this->millisecond > $when->millisecond) return false;


        return false;


    }






    function equals($when) {


        if (!is_a($when, 'PHPRPC_Date')) {


            $when = new PHPRPC_Date($when);


        }


        return (($this->year == $when->year) &&


            ($this->month == $when->month) &&


            ($this->day == $when->day) &&


            ($this->hour == $when->hour) &&


            ($this->minute == $when->minute) &&


            ($this->second == $when->second) &&


            ($this->millisecond == $when->millisecond));


    }






    function set() {


        $num = func_num_args();


        $args = func_get_args();


        if ($num >= 3) {


            if (!PHPRPC_Date::isValidDate($args[0], $args[1], $args[2])) {


                return false;


            }


            $this->year  = (int)$args[0];


            $this->month = (int)$args[1];


            $this->day   = (int)$args[2];


            if ($num == 3) {


                return true;


            }


        }


        if ($num >= 6) {


            if (!PHPRPC_Date::isValidTime($args[3], $args[4], $args[5])) {


                return false;


            }


            $this->hour   = (int)$args[3];


            $this->minute = (int)$args[4];


            $this->second = (int)$args[5];


            if ($num == 6) {


                return true;


            }


        }


        if (($num == 7) && ($args[6] >= 0 && $args[6] <= 999)) {


            $this->millisecond = (int)$args[6];


            return true;


        }


        return false;


    }






    function time() {


        return mktime($this->hour, $this->minute, $this->second, $this->month, $this->day, $this->year);


    }






    function toString() {


        return sprintf('%04d-%02d-%02d %02d:%02d:%02d.%03d',


            $this->year, $this->month, $this->day,


            $this->hour, $this->minute, $this->second,


            $this->millisecond);


    }






// magic method for PHP 5






    function __toString() {


        return $this->toString();


    }






// public instance & static methods






    function dayOfWeek() {


        $num = func_num_args();


        if ($num == 3) {


            $args = func_get_args();


            $y = $args[0];


            $m = $args[1];


            $d = $args[2];


        }


        else {


            $y = $this->year;


            $m = $this->month;


            $d = $this->day;


        }


        $d += $m < 3 ? $y-- : $y - 2;


        return ((int)(23 * $m / 9) + $d + 4 + (int)($y / 4) - (int)($y / 100) + (int)($y / 400)) % 7;


    }






    function dayOfYear() {


        static $daysToMonth365 = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365);


        static $daysToMonth366 = array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366);


        $num = func_num_args();


        if ($num == 3) {


            $args = func_get_args();


            $y = $args[0];


            $m = $args[1];


            $d = $args[2];


        }


        else {


            $y = $this->year;


            $m = $this->month;


            $d = $this->day;


        }


        $days = PHPRPC_Date::isLeapYear($y) ? $daysToMonth365 : $daysToMonth366;


        return $days[$m - 1] + $d;


    }






// public static methods






    function now() {


        $date = new PHPRPC_Date();


        return $date;


    }






    function today() {


        $date = PHPRPC_Date::now();


        $date->hour = 0;


        $date->minute = 0;


        $date->second = 0;


        return $date;


    }






    function parse($dt) {


        if (is_a($dt, 'PHPRPC_Date')) {


            return $dt;


        }


        if (is_int($dt)) {


            return new PHPRPC_Date($dt);


        }


        $shortFormat = '(\d|\d{2}|\d{3}|\d{4})-([1-9]|0[1-9]|1[012])-([1-9]|0[1-9]|[12]\d|3[01])';


        if (preg_match("/^$shortFormat$/", $dt, $match)) {


            $year   = intval($match[1]);


            $month  = intval($match[2]);


            $day    = intval($match[3]);


            if (PHPRPC_Date::isValidDate($year, $month, $day)) {


                $date = new PHPRPC_Date(false);


                $date->year  = $year;


                $date->month = $month;


                $date->day   = $day;


                return $date;


            }


            else {


                return false;


            }


        }


        $longFormat = $shortFormat . ' (\d|0\d|1\d|2[0-3]):(\d|[0-5]\d):(\d|[0-5]\d)';


        if (preg_match("/^$longFormat$/", $dt, $match)) {


            $year   = intval($match[1]);


            $month  = intval($match[2]);


            $day    = intval($match[3]);


            if (PHPRPC_Date::isValidDate($year, $month, $day)) {


                $date = new PHPRPC_Date(false);


                $date->year  = $year;


                $date->month = $month;


                $date->day   = $day;


                $date->hour   = intval($match[4]);


                $date->minute = intval($match[5]);


                $date->second = intval($match[6]);


                return $date;


            }


            else {


                return false;


            }


        }


        $fullFormat = $longFormat . '\.(\d|\d{2}|\d{3})';


        if (preg_match("/^$fullFormat$/", $dt, $match)) {


            $year   = intval($match[1]);


            $month  = intval($match[2]);


            $day    = intval($match[3]);


            if (PHPRPC_Date::isValidDate($year, $month, $day)) {


                $date = new PHPRPC_Date(false);


                $date->year  = $year;


                $date->month = $month;


                $date->day   = $day;


                $date->hour        = intval($match[4]);


                $date->minute      = intval($match[5]);


                $date->second      = intval($match[6]);


                $date->millisecond = intval($match[7]);


                return $date;


            }


            else {


                return false;


            }


        }


        return false;


    }






    function isLeapYear($year) {


        return (($year % 4) == 0) ? (($year % 100) == 0) ? (($year % 400) == 0) : true : false;


    }






    function daysInMonth($year, $month) {


        if (($month < 1) || ($month > 12)) {


            return false;


        }


        return cal_days_in_month(CAL_GREGORIAN, $month, $year);


    }






    function isValidDate($year, $month, $day) {


        if (($year >= 1) && ($year <= 9999)) {


            return checkdate($month, $day, $year);


        }


        return false;


    }






    function isValidTime($hour, $minute, $second) {


        return !(($hour < 0) || ($hour > 23) ||


            ($minute < 0) || ($minute > 59) ||


            ($second < 0) || ($second > 59));


    }


}






if (!function_exists('file_get_contents')) {


    function file_get_contents($filename, $incpath = false, $resource_context = null) {


        if (false === $fh = fopen($filename, 'rb', $incpath)) {


            user_error('file_get_contents() failed to open stream: No such file or directory',


                E_USER_WARNING);


            return false;


        }


        clearstatcache();


        if ($fsize = @filesize($filename)) {


            $data = fread($fh, $fsize);


        }


        else {


            $data = '';


            while (!feof($fh)) {


                $data .= fread($fh, 8192);


            }


        }


        fclose($fh);


        return $data;


    }


}






if (!function_exists('ob_get_clean')) {


    function ob_get_clean() {


        $contents = ob_get_contents();


        if ($contents !== false) ob_end_clean();


        return $contents;


    }


}






function gzdecode($data) {


    $len = strlen($data);


    if ($len < 18 || strcmp(substr($data, 0, 2), "\x1f\x8b")) {


        return null;  // Not GZIP format (See RFC 1952)


    }


    $method = ord(substr($data, 2, 1));  // Compression method


    $flags  = ord(substr($data, 3, 1));  // Flags


    if ($flags & 31 != $flags) {


        // Reserved bits are set -- NOT ALLOWED by RFC 1952


        return null;


    }


    // NOTE: $mtime may be negative (PHP integer limitations)


    $mtime = unpack("V", substr($data, 4, 4));


    $mtime = $mtime[1];


    $xfl  = substr($data, 8, 1);


    $os    = substr($data, 8, 1);


    $headerlen = 10;


    $extralen  = 0;


    $extra    = "";


    if ($flags & 4) {


        // 2-byte length prefixed EXTRA data in header


        if ($len - $headerlen - 2 < 8) {


            return false;    // Invalid format


        }


        $extralen = unpack("v",substr($data, 8, 2));


        $extralen = $extralen[1];


        if ($len - $headerlen - 2 - $extralen < 8) {


            return false;    // Invalid format


        }


        $extra = substr($data, 10, $extralen);


        $headerlen += 2 + $extralen;


    }






    $filenamelen = 0;


    $filename = "";


    if ($flags & 8) {


        // C-style string file NAME data in header


        if ($len - $headerlen - 1 < 8) {


            return false;    // Invalid format


        }


        $filenamelen = strpos(substr($data, 8 + $extralen), chr(0));


        if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {


            return false;    // Invalid format


        }


        $filename = substr($data,$headerlen,$filenamelen);


        $headerlen += $filenamelen + 1;


    }






    $commentlen = 0;


    $comment = "";


    if ($flags & 16) {


        // C-style string COMMENT data in header


        if ($len - $headerlen - 1 < 8) {


            return false;    // Invalid format


        }


        $commentlen = strpos(substr($data, 8 + $extralen + $filenamelen), chr(0));


        if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {


            return false;    // Invalid header format


        }


        $comment = substr($data, $headerlen, $commentlen);


        $headerlen += $commentlen + 1;


    }






    $headercrc = "";


    if ($flags & 1) {


        // 2-bytes (lowest order) of CRC32 on header present


        if ($len - $headerlen - 2 < 8) {


            return false;    // Invalid format


        }


        $calccrc = crc32(substr($data, 0, $headerlen)) & 0xffff;


        $headercrc = unpack("v", substr($data, $headerlen, 2));


        $headercrc = $headercrc[1];


        if ($headercrc != $calccrc) {


            return false;    // Bad header CRC


        }


        $headerlen += 2;


    }






    // GZIP FOOTER - These be negative due to PHP's limitations


    $datacrc = unpack("V", substr($data, -8, 4));


    $datacrc = $datacrc[1];


    $isize = unpack("V", substr($data, -4));


    $isize = $isize[1];






    // Perform the decompression:


    $bodylen = $len - $headerlen - 8;


    if ($bodylen < 1) {


        // This should never happen - IMPLEMENTATION BUG!


        return null;


    }


    $body = substr($data, $headerlen, $bodylen);


    $data = "";


    if ($bodylen > 0) {


        switch ($method) {


            case 8:


                // Currently the only supported compression method:


                $data = gzinflate($body);


                break;


            default:


                // Unknown compression method


                return false;


        }


    }


    else {


        // I'm not sure if zero-byte body content is allowed.


        // Allow it for now...  Do nothing...


    }






    // Verifiy decompressed size and CRC32:


    // NOTE: This may fail with large data sizes depending on how


    //      PHP's integer limitations affect strlen() since $isize


    //      may be negative for large sizes.


    if ($isize != strlen($data) || crc32($data) != $datacrc) {


        // Bad format!  Length or CRC doesn't match!


        return false;


    }


    return $data;


}






if (version_compare(phpversion(), "5", "<")) {


    function serialize_fix($v) {


        return str_replace('O:11:"phprpc_date":7:{', 'O:11:"PHPRPC_Date":7:{', serialize($v));


    }


}


else {


    function serialize_fix($v) {


        return serialize($v);


    }


}






function declare_empty_class($classname) {


    static $callback = null;


    $classname = preg_replace('/[^a-zA-Z0-9\_]/', '', $classname);


    if ($callback===null) {


        $callback = $classname;


        return;


    }


    if ($callback) {


        call_user_func($callback, $classname);


    }


    if (!class_exists($classname)) {


        if (version_compare(phpversion(), "5", "<")) {


            eval('class ' . $classname . ' { }');


        }


        else {


            eval('


    class ' . $classname . ' {


        public function __get($name) {


            $vars = (array)$this;


            $protected_name = "\0*\0$name";


            $private_name = "\0'.$classname.'\0$name";


            if (array_key_exists($name, $vars)) {


                return $this->$name;


            }


            else if (array_key_exists($protected_name, $vars)) {


                return $vars[$protected_name];


            }


            else if (array_key_exists($private_name, $vars)) {


                return $vars[$private_name];


            }


            else {


                $keys = array_keys($vars);


                $keys = array_values(preg_grep("/^\\\\x00.*?\\\\x00".$name."$/", $keys));


                if (isset($keys[0])) {


                    return $vars[$keys[0]];


                }


                else {


                    return NULL;


                }


            }


        }


    }');


        }


    }


}


declare_empty_class(ini_get('unserialize_callback_func'));


ini_set('unserialize_callback_func', 'declare_empty_class');






if (extension_loaded('gmp')) {


    function bigint_dec2num($dec) {


        return gmp_init($dec);


    }


    function bigint_num2dec($num) {


        return gmp_strval($num);


    }


    function bigint_str2num($str) {


        return gmp_init("0x".bin2hex($str));


    }


    function bigint_num2str($num) {


        $str = gmp_strval($num, 16);


        $len = strlen($str);


        if ($len % 2 == 1) {


            $str = '0'.$str;


        }


        return pack("H*", $str);


    }


    function bigint_random($n, $s) {


        $result = gmp_init(0);


        for ($i = 0; $i < $n; $i++) {


            if (mt_rand(0, 1)) {


                gmp_setbit($result, $i);


            }


        }


        if ($s) {


            gmp_setbit($result, $n - 1);


        }


        return $result;


    }


    function bigint_powmod($x, $y, $m) {


        return gmp_powm($x, $y, $m);


    }


}


else if (extension_loaded('big_int')) {


    function bigint_dec2num($dec) {


        return bi_from_str($dec);


    }


    function bigint_num2dec($num) {


        return bi_to_str($num);


    }


    function bigint_str2num($str) {


        return bi_from_str(bin2hex($str), 16);


    }


    function bigint_num2str($num) {


        $str = bi_to_str($num, 16);


        $len = strlen($str);


        if ($len % 2 == 1) {


            $str = '0'.$str;


        }


        return pack("H*", $str);


    }


    function bigint_random($n, $s) {


        $result = bi_rand($n);


        if ($s) {


            $result = bi_set_bit($result, $n - 1);


        }


        return $result;


    }


    function bigint_powmod($x, $y, $m) {


        return bi_powmod($x, $y, $m);


    }


}


else if (extension_loaded('bcmath')) {


    function bigint_dec2num($dec) {


        return $dec;


    }


    function bigint_num2dec($num) {


        return $num;


    }


    function bigint_str2num($str) {


        bcscale(0);


        $len = strlen($str);


        $result = '0';


        $m = '1';


        for ($i = 0; $i < $len; $i++) {


            $result = bcadd(bcmul($m, ord($str{$len - $i - 1})), $result);


            $m = bcmul($m, '256');


        }


        return $result;


    }


    function bigint_num2str($num) {


        bcscale(0);


        $str = "";


        while (bccomp($num, '0') == 1) {


            $str = chr(bcmod($num, '256')) . $str;


            $num = bcdiv($num, '256');


        }


        return $str;


    }


    // author of bcmath bigint_random: mgccl <mgcclx@gmail.com>


    function bigint_pow($b, $e) {


        if ($b == 2) {


            $a[96] = '79228162514264337593543950336';


            $a[128] = '340282366920938463463374607431768211456';


            $a[160] = '1461501637330902918203684832716283019655932542976';


            $a[192] = '6277101735386680763835789423207666416102355444464034512896';


            $a[256] = '115792089237316195423570985008687907853269984665640564039457584007913129639936';


            $a[512] = '13407807929942597099574024998205846127479365820592393377723561443721764030073546976801874298166903427690031858186486050853753882811946569946433649006084096';


            $a[768] = '1552518092300708935148979488462502555256886017116696611139052038026050952686376886330878408828646477950487730697131073206171580044114814391444287275041181139204454976020849905550265285631598444825262999193716468750892846853816057856';


            $a[1024] = '179769313486231590772930519078902473361797697894230657273430081157732675805500963132708477322407536021120113879871393357658789768814416622492847430639474124377767893424865485276302219601246094119453082952085005768838150682342462881473913110540827237163350510684586298239947245938479716304835356329624224137216';


            $a[1356] = '1572802244866018108182967249994981337399178505432223228293716677435703277129801955281491139254988030713172834803458459525011536776047399098682525970017006610187370020027540826048617586909475175880278263391147764612823746132583281588112028234096933800670620569966257212339315820309710495898777306979706509398705741430192541287726011814541176060679505247297118998085067003005943214893171428950699778511718055936';


            $a[2048] = '32317006071311007300714876688669951960444102669715484032130345427524655138867890893197201411522913463688717960921898019494119559150490921095088152386448283120630877367300996091750197750389652106796057638384067568276792218642619756161838094338476170470581645852036305042887575891541065808607552399123930385521914333389668342420684974786564569494856176035326322058077805659331026192708460314150258592864177116725943603718461857357598351152301645904403697613233287231227125684710820209725157101726931323469678542580656697935045997268352998638215525166389437335543602135433229604645318478604952148193555853611059596230656';


            $a[3072] = '5809605995369958062859502533304574370686975176362895236661486152287203730997110225737336044533118407251326157754980517443990529594540047121662885672187032401032111639706440498844049850989051627200244765807041812394729680540024104827976584369381522292361208779044769892743225751738076979568811309579125511333093243519553784816306381580161860200247492568448150242515304449577187604136428738580990172551573934146255830366405915000869643732053218566832545291107903722831634138599586406690325959725187447169059540805012310209639011750748760017095360734234945757416272994856013308616958529958304677637019181594088528345061285863898271763457294883546638879554311615446446330199254382340016292057090751175533888161918987295591531536698701292267685465517437915790823154844634780260102891718032495396075041899485513811126977307478969074857043710716150121315922024556759241239013152919710956468406379442914941614357107914462567329693696';


            $a[4096] = '1044388881413152506691752710716624382579964249047383780384233483283953907971557456848826811934997558340890106714439262837987573438185793607263236087851365277945956976543709998340361590134383718314428070011855946226376318839397712745672334684344586617496807908705803704071284048740118609114467977783598029006686938976881787785946905630190260940599579453432823469303026696443059025015972399867714215541693835559885291486318237914434496734087811872639496475100189041349008417061675093668333850551032972088269550769983616369411933015213796825837188091833656751221318492846368125550225998300412344784862595674492194617023806505913245610825731835380087608622102834270197698202313169017678006675195485079921636419370285375124784014907159135459982790513399611551794271106831134090584272884279791554849782954323534517065223269061394905987693002122963395687782878948440616007412945674919823050571642377154816321380631045902916136926708342856440730447899971901781465763473223850267253059899795996090799469201774624817718449867455659250178329070473119433165550807568221846571746373296884912819520317457002440926616910874148385078411929804522981857338977648103126085903001302413467189726673216491511131602920781738033436090243804708340403154190336';


            $a[8192] = '1090748135619415929462984244733782862448264161996232692431832786189721331849119295216264234525201987223957291796157025273109870820177184063610979765077554799078906298842192989538609825228048205159696851613591638196771886542609324560121290553901886301017900252535799917200010079600026535836800905297805880952350501630195475653911005312364560014847426035293551245843928918752768696279344088055617515694349945406677825140814900616105920256438504578013326493565836047242407382442812245131517757519164899226365743722432277368075027627883045206501792761700945699168497257879683851737049996900961120515655050115561271491492515342105748966629547032786321505730828430221664970324396138635251626409516168005427623435996308921691446181187406395310665404885739434832877428167407495370993511868756359970390117021823616749458620969857006263612082706715408157066575137281027022310927564910276759160520878304632411049364568754920967322982459184763427383790272448438018526977764941072715611580434690827459339991961414242741410599117426060556483763756314527611362658628383368621157993638020878537675545336789915694234433955666315070087213535470255670312004130725495834508357439653828936077080978550578912967907352780054935621561090795845172954115972927479877527738560008204118558930004777748727761853813510493840581861598652211605960308356405941821189714037868726219481498727603653616298856174822413033485438785324024751419417183012281078209729303537372804574372095228703622776363945290869806258422355148507571039619387449629866808188769662815778153079393179093143648340761738581819563002994422790754955061288818308430079648693232179158765918035565216157115402992120276155607873107937477466841528362987708699450152031231862594203085693838944657061346236704234026821102958954951197087076546186622796294536451620756509351018906023773821539532776208676978589731966330308893304665169436185078350641568336944530051437491311298834367265238595404904273455928723949525227184617404367854754610474377019768025576605881038077270707717942221977090385438585844095492116099852538903974655703943973086090930596963360767529964938414598185705963754561497355827813623833288906309004288017321424808663962671333528009232758350873059614118723781422101460198615747386855096896089189180441339558524822867541113212638793675567650340362970031930023397828465318547238244232028015189689660418822976000815437610652254270163595650875433851147123214227266605403581781469090806576468950587661997186505665475715792896';


            return (isset($a[$e]) ? $a[$e] : bcpow(2, $e));


        }


        return bcpow($b, $e);


    }


    function bigint_random($n, $s) {


        bcscale(0);


        $t = bigint_pow(2, $n);


        if ($s == 1) {


            $m = bcdiv($t, 2);


            $t = bcsub($m, 1);


        }


        else {


            $m = 0;


            $t = bcsub($t, 1);


        }


        $l = strlen($t);


        $n = (int) ($l / 9) + 1;


        $r = '';


        while($n) {


            $r .= substr('000000000' . mt_rand(0, 999999999), -9);


            --$n;


        }


        $r = substr($r, 0, $l);


        while (bccomp($r, $t) == 1) $r = substr($r, 1, $l) . mt_rand(0, 9);


        return bcadd($r, $m);


    }


    if (!function_exists('bcpowmod')) {


        function bcpowmod($x, $y, $modulus, $scale = 0) {


            $t = '1';


            while (bccomp($y, '0')) {


                if (bccomp(bcmod($y, '2'), '0')) {


                    $t = bcmod(bcmul($t, $x), $modulus);


                    $y = bcsub($y, '1');


                }






                $x = bcmod(bcmul($x, $x), $modulus);


                $y = bcdiv($y, '2');


            }


            return $t;


        }


    }


    function bigint_powmod($x, $y, $m) {


        return bcpowmod($x, $y, $m);


    }


}


else {


    function bigint_mul($a, $b) {


        $n = count($a);


        $m = count($b);


        $nm = $n + $m;


        $c = array_fill(0, $nm, 0);


        for ($i = 0; $i < $n; $i++) {


            for ($j = 0; $j < $m; $j++) {


                $c[$i + $j] += $a[$i] * $b[$j];


                $c[$i + $j + 1] += ($c[$i + $j] >> 15) & 0x7fff;


                $c[$i + $j] &= 0x7fff;


            }


        }


        return $c;


    }


    function bigint_div($a, $b, $is_mod = 0) {


        $n = count($a);


        $m = count($b);


        $c = array();


        $d = floor(0x8000 / ($b[$m - 1] + 1));


        $a = bigint_mul($a, array($d));


        $b = bigint_mul($b, array($d));


        for ($j = $n - $m; $j >= 0; $j--) {


            $tmp = $a[$j + $m] * 0x8000 + $a[$j + $m - 1];


            $rr = $tmp % $b[$m - 1];


            $qq = round(($tmp - $rr) / $b[$m - 1]);


            if (($qq == 0x8000) || (($m > 1) && ($qq * $b[$m - 2] > 0x8000 * $rr + $a[$j + $m - 2]))) {


                $qq--;


                $rr += $b[$m - 1];


                if (($rr < 0x8000) && ($qq * $b[$m - 2] > 0x8000 * $rr + $a[$j + $m - 2])) $qq--;


            }


            for ($i = 0; $i < $m; $i++) {


                $tmp = $i + $j;


                $a[$tmp] -= $b[$i] * $qq;


                $a[$tmp + 1] += floor($a[$tmp] / 0x8000);


                $a[$tmp] &= 0x7fff;


            }


            $c[$j] = $qq;


            if ($a[$tmp + 1] < 0) {


                $c[$j]--;


                for ($i = 0; $i < $m; $i++) {


                    $tmp = $i + $j;


                    $a[$tmp] += $b[$i];


                    if ($a[$tmp] > 0x7fff) {


                        $a[$tmp + 1]++;


                        $a[$tmp] &= 0x7fff;


                    }


                }


            }


        }


        if (!$is_mod) return $c;


        $b = array();


        for ($i = 0; $i < $m; $i++) $b[$i] = $a[$i];


        return bigint_div($b, array($d));


    }


    function bigint_zerofill($str, $num) {


        return str_pad($str, $num, '0', STR_PAD_LEFT);


    }


    function bigint_dec2num($dec) {


        $n = strlen($dec);


        $a = array(0);


        $n += 4 - ($n % 4);


        $dec = bigint_zerofill($dec, $n);


        $n >>= 2;


        for ($i = 0; $i < $n; $i++) {


            $a = bigint_mul($a, array(10000));


            $a[0] += (int)substr($dec, 4 * $i, 4);


            $m = count($a);


            $j = 0;


            $a[$m] = 0;


            while ($j < $m && $a[$j] > 0x7fff) {


                $a[$j++] &= 0x7fff;


                $a[$j]++;


            }


            while ((count($a) > 1) && (!$a[count($a) - 1])) array_pop($a);


        }


        return $a;


    }


    function bigint_num2dec($num) {


        $n = count($num) << 1;


        $b = array();


        for ($i = 0; $i < $n; $i++) {


            $tmp = bigint_div($num, array(10000), 1);


            $b[$i] = bigint_zerofill($tmp[0], 4);


            $num = bigint_div($num, array(10000));


        }


        while ((count($b) > 1) && !(int)$b[count($b) - 1]) array_pop($b);


        $n = count($b) - 1;


        $b[$n] = (int)$b[$n];


        $b = join('', array_reverse($b));


        return $b;


    }


    function bigint_str2num($str) {


        $n = strlen($str);


        $n += 15 - ($n % 15);


        $str = str_pad($str, $n, chr(0), STR_PAD_LEFT);


        $j = 0;


        $result = array();


        for ($i = 0; $i < $n; $i++) {


            $result[$j++] = (ord($str{$i++}) << 7) | (ord($str{$i}) >> 1);


            $result[$j++] = ((ord($str{$i++}) & 0x01) << 14) | (ord($str{$i++}) << 6) | (ord($str{$i}) >> 2);


            $result[$j++] = ((ord($str{$i++}) & 0x03) << 13) | (ord($str{$i++}) << 5) | (ord($str{$i}) >> 3);


            $result[$j++] = ((ord($str{$i++}) & 0x07) << 12) | (ord($str{$i++}) << 4) | (ord($str{$i}) >> 4);


            $result[$j++] = ((ord($str{$i++}) & 0x0f) << 11) | (ord($str{$i++}) << 3) | (ord($str{$i}) >> 5);


            $result[$j++] = ((ord($str{$i++}) & 0x1f) << 10) | (ord($str{$i++}) << 2) | (ord($str{$i}) >> 6);


            $result[$j++] = ((ord($str{$i++}) & 0x3f) << 9) | (ord($str{$i++}) << 1) | (ord($str{$i}) >> 7);


            $result[$j++] = ((ord($str{$i++}) & 0x7f) << 8) | ord($str{$i});


        }


        $result = array_reverse($result);


        $i = count($result) - 1;


        while ($result[$i] == 0) {


            array_pop($result);


            $i--;


        }


        return $result;


    }


    function bigint_num2str($num) {


        ksort($num, SORT_NUMERIC);


        $n = count($num);


        $n += 8 - ($n % 8);


        $num = array_reverse(array_pad($num, $n, 0));


        $s = '';


        for ($i = 0; $i < $n; $i++) {


            $s .= chr($num[$i] >> 7);


            $s .= chr((($num[$i++] & 0x7f) << 1) | ($num[$i] >> 14));


            $s .= chr(($num[$i] >> 6) & 0xff);


            $s .= chr((($num[$i++] & 0x3f) << 2) | ($num[$i] >> 13));


            $s .= chr(($num[$i] >> 5) & 0xff);


            $s .= chr((($num[$i++] & 0x1f) << 3) | ($num[$i] >> 12));


            $s .= chr(($num[$i] >> 4) & 0xff);


            $s .= chr((($num[$i++] & 0x0f) << 4) | ($num[$i] >> 11));


            $s .= chr(($num[$i] >> 3) & 0xff);


            $s .= chr((($num[$i++] & 0x07) << 5) | ($num[$i] >> 10));


            $s .= chr(($num[$i] >> 2) & 0xff);


            $s .= chr((($num[$i++] & 0x03) << 6) | ($num[$i] >> 9));


            $s .= chr(($num[$i] >> 1) & 0xff);


            $s .= chr((($num[$i++] & 0x01) << 7) | ($num[$i] >> 8));


            $s .= chr($num[$i] & 0xff);


        }


        return ltrim($s, chr(0));


    }






    function bigint_random($n, $s) {


        $lowBitMasks = array(0x0000, 0x0001, 0x0003, 0x0007,


            0x000f, 0x001f, 0x003f, 0x007f,


            0x00ff, 0x01ff, 0x03ff, 0x07ff,


            0x0fff, 0x1fff, 0x3fff);


        $r = $n % 15;


        $q = floor($n / 15);


        $result = array();


        for ($i = 0; $i < $q; $i++) {


            $result[$i] = mt_rand(0, 0x7fff);


        }


        if ($r != 0) {


            $result[$q] = mt_rand(0, $lowBitMasks[$r]);


            if ($s) {


                $result[$q] |= 1 << ($r - 1);


            }


        }


        else if ($s) {


            $result[$q - 1] |= 0x4000;


        }


        return $result;


    }


    function bigint_powmod($x, $y, $m) {


        $n = count($y);


        $p = array(1);


        for ($i = 0; $i < $n - 1; $i++) {


            $tmp = $y[$i];


            for ($j = 0; $j < 0xf; $j++) {


                if ($tmp & 1) $p = bigint_div(bigint_mul($p, $x), $m, 1);


                $tmp >>= 1;


                $x = bigint_div(bigint_mul($x, $x), $m, 1);


            }


        }


        $tmp = $y[$i];


        while ($tmp) {


            if ($tmp & 1) $p = bigint_div(bigint_mul($p, $x), $m, 1);


            $tmp >>= 1;


            $x = bigint_div(bigint_mul($x, $x), $m, 1);


        }


        return $p;


    }


}










$_PHPRPC_COOKIES = array();


$_PHPRPC_COOKIE = '';


$_PHPRPC_SID = 0;






if (defined('KEEP_PHPRPC_COOKIE_IN_SESSION')) {


    if (isset($_SESSION['phprpc_cookies']) and isset($_SESSION['phprpc_cookie'])) {


        $_PHPRPC_COOKIES = $_SESSION['phprpc_cookies'];


        $_PHPRPC_COOKIE = $_SESSION['phprpc_cookie'];


    }


    function keep_phprpc_cookie_in_session() {


        global $_PHPRPC_COOKIES, $_PHPRPC_COOKIE;


        $_SESSION['phprpc_cookies'] = $_PHPRPC_COOKIES;


        $_SESSION['phprpc_cookie'] = $_PHPRPC_COOKIE;


    }


    register_shutdown_function('keep_phprpc_cookie_in_session');


}






class PHPRPC_Error {


    var $Number;


    var $Message;


    function PHPRPC_Error($errno, $errstr) {


        $this->Number = $errno;


        $this->Message = $errstr;


    }


    function toString() {


        return $this->Number . ":" . $this->Message;


    }


    function __toString() {


        return $this->toString();


    }


    function getNumber() {


        return $this->Number;


    }


    function getMessage() {


        return $this->Message;


    }


}






class _PHPRPC_Client {


    var $_server;


    var $_timeout;


    var $_output;


    var $_warning;


    var $_proxy;


    var $_key;


    var $_keylen;


    var $_encryptMode;


    var $_charset;


    var $_socket;


    var $_clientid;


    var $_http_version;


    var $_keep_alive;


    // Public Methods


    function _PHPRPC_Client($serverURL = '') {


        global $_PHPRPC_SID;


        register_shutdown_function(array(&$this, "_disconnect"));


        $this->_proxy = NULL;


        $this->_timeout = 30;


        $this->_clientid = 'php' . rand(1 << 30, 1 << 31) . time() . $_PHPRPC_SID;


        $_PHPRPC_SID++;


        $this->_socket = false;


        if ($serverURL != '') {


            $this->useService($serverURL);


        }


    }


    function useService($serverURL, $username = NULL, $password = NULL) {


        $this->_disconnect();


        $this->_http_version = "1.1";


        $this->_keep_alive = true;


        $this->_server = array();


        $this->_key = NULL;


        $this->_keylen = 128;


        $this->_encryptMode = 0;


        $this->_charset = 'utf-8';


        $urlparts = parse_url($serverURL);


        if (!isset($urlparts['host'])) {


            if (isset($_SERVER["HTTP_HOST"])) {


                $urlparts['host'] = $_SERVER["HTTP_HOST"];


            }


            else if (isset($_SERVER["SERVER_NAME"])) {


                $urlparts['host'] = $_SERVER["SERVER_NAME"];


            }


            else {


                $urlparts['host'] = "localhost";


            }


            if (!isset($_SERVER["HTTPS"]) ||


                $_SERVER["HTTPS"] == "off"  ||


                $_SERVER["HTTPS"] == "") {


                $urlparts['scheme'] = "http";


            }


            else {


                $urlparts['scheme'] = "https";


            }


            $urlparts['port'] = $_SERVER["SERVER_PORT"];


        }






        if (!isset($urlparts['port'])) {


            if ($urlparts['scheme'] == "https") {


                $urlparts['port'] = 443;


            }


            else {


                $urlparts['port'] = 80;


            }


        }






        if (!isset($urlparts['path'])) {


            $urlparts['path'] = "/";


        }


        else if (($urlparts['path']{0} != '/') && ($_SERVER["PHP_SELF"]{0} == '/')) {


            $urlparts['path'] = substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], '/') + 1) . $urlparts['path'];


        }






        if (isset($urlparts['query'])) {


            $urlparts['path'] .= '?' . $urlparts['query'];


        }






        if (!isset($urlparts['user']) || !is_null($username)) {


            $urlparts['user'] = $username;


        }






        if (!isset($urlparts['pass']) || !is_null($password)) {


            $urlparts['pass'] = $password;


        }






        $this->_server['scheme'] = $urlparts['scheme'];


        $this->_server['host'] = $urlparts['host'];


        $this->_server['port'] = $urlparts['port'];


        $this->_server['path'] = $urlparts['path'];


        $this->_server['user'] = $urlparts['user'];


        $this->_server['pass'] = $urlparts['pass'];


    }


    function setProxy($host, $port = NULL, $username = NULL, $password = NULL) {


        if (is_null($host)) {


            $this->_proxy = NULL;


        }


        else {


            if (is_null($port)) {


                $urlparts = parse_url($host);


                if (isset($urlparts['host'])) {


                    $host = $urlparts['host'];


                }


                if (isset($urlparts['port'])) {


                    $port = $urlparts['port'];


                }


                else {


                    $port = 80;


                }


                if (isset($urlparts['user']) && is_null($username)) {


                    $username = $urlparts['user'];


                }


                if (isset($urlparts['pass']) && is_null($password)) {


                    $password = $urlparts['pass'];


                }


            }


            $this->_proxy = array();


            $this->_proxy['host'] = $host;


            $this->_proxy['port'] = $port;


            $this->_proxy['user'] = $username;


            $this->_proxy['pass'] = $password;


        }


    }


    function setKeyLength($keylen) {


        if (!is_null($this->_key)) {


            return false;


        }


        else {


            $this->_keylen = $keylen;


            return true;


        }


    }


    function getKeyLength() {


        return $this->_keylen;


    }


    function setEncryptMode($encryptMode) {


        if (($encryptMode >= 0) && ($encryptMode <= 3)) {


            $this->_encryptMode = (int)($encryptMode);


            return true;


        }


        else {


            $this->_encryptMode = 0;


            return false;


        }


    }


    function getEncryptMode() {


        return $this->_encryptMode;


    }


    function setCharset($charset) {


        $this->_charset = $charset;


    }


    function getCharset() {


        return $this->_charset;


    }


    function setTimeout($timeout) {


        $this->_timeout = $timeout;


    }


    function getTimeout() {


        return $this->_timeout;


    }


    function invoke($funcname, &$args, $byRef = false) {


        $result = $this->_key_exchange();


        if (is_a($result, 'PHPRPC_Error')) {


            return $result;


        }


        $request = "phprpc_func=$funcname";


        if (count($args) > 0) {


            $request .= "&phprpc_args=" . base64_encode($this->_encrypt(serialize_fix($args), 1));


        }


        $request .= "&phprpc_encrypt={$this->_encryptMode}";


        if (!$byRef) {


            $request .= "&phprpc_ref=false";


        }


        $request = str_replace('+', '%2B', $request);


        $result = $this->_post($request);


        if (is_a($result, 'PHPRPC_Error')) {


            return $result;


        }


        $phprpc_errno = 0;


        $phprpc_errstr = NULL;


        if (isset($result['phprpc_errno'])) {


            $phprpc_errno = intval($result['phprpc_errno']);


        }


        if (isset($result['phprpc_errstr'])) {


            $phprpc_errstr = base64_decode($result['phprpc_errstr']);


        }


        $this->_warning = new PHPRPC_Error($phprpc_errno, $phprpc_errstr);


        if (array_key_exists('phprpc_output', $result)) {


            $this->_output = base64_decode($result['phprpc_output']);


            if ($this->_server['version'] >= 3) {


                $this->_output = $this->_decrypt($this->_output, 3);


            }


        }


        else {


            $this->_output = '';


        }


        if (array_key_exists('phprpc_result', $result)) {


            if (array_key_exists('phprpc_args', $result)) {


                $arguments = unserialize($this->_decrypt(base64_decode($result['phprpc_args']), 1));


                for ($i = 0; $i < count($arguments); $i++) {


                    $args[$i] = $arguments[$i];


                }


            }


            $result = unserialize($this->_decrypt(base64_decode($result['phprpc_result']), 2));


        }


        else {


            $result = $this->_warning;


        }


        return $result;


    }






    function getOutput() {


        return $this->_output;


    }






    function getWarning() {


        return $this->_warning;


    }






    function _connect() {


        if (is_null($this->_proxy)) {


            $host = (($this->_server['scheme'] == "https") ? "ssl://" : "") . $this->_server['host'];


            $this->_socket = @fsockopen($host, $this->_server['port'], $errno, $errstr, $this->_timeout);


        }


        else {


            $host = (($this->_server['scheme'] == "https") ? "ssl://" : "") . $this->_proxy['host'];


            $this->_socket = @fsockopen($host, $this->_proxy['port'], $errno, $errstr, $this->_timeout);


        }


        if ($this->_socket === false) {


            return new PHPRPC_Error($errno, $errstr);


        }


        stream_set_write_buffer($this->_socket, 0);


        socket_set_timeout($this->_socket, $this->_timeout);


        return true;


    }






    function _disconnect() {


        if ($this->_socket !== false) {


            fclose($this->_socket);


            $this->_socket = false;


        }


    }






    function _socket_read($size) {


        $content = "";


        while (!feof($this->_socket) && ($size > 0)) {


            $str = fread($this->_socket, $size);


            $content .= $str;


            $size -= strlen($str);


        }


        return $content;


    }


    function _post($request_body) {


        global $_PHPRPC_COOKIE;


        $request_body = 'phprpc_id=' . $this->_clientid . '&' . $request_body;


        if ($this->_socket === false) {


            $error = $this->_connect();


            if (is_a($error, 'PHPRPC_Error')) {


                return $error;


            }


        }


        if (is_null($this->_proxy)) {


            $url = $this->_server['path'];


            $connection = "Connection: " . ($this->_keep_alive ? 'keep-alive' : 'close') . "\r\n" .


                "Cache-Control: no-cache\r\n";


        }


        else {


            $url = "{$this->_server['scheme']}://{$this->_server['host']}:{$this->_server['port']}{$this->_server['path']}";


            $connection = "Proxy-Connection: " . ($this->_keep_alive ? 'keep-alive' : 'close') . "\r\n";


            if (!is_null($this->_proxy['user'])) {


                $connection .= "Proxy-Authorization: Basic " . base64_encode($this->_proxy['user'] . ":" . $this->_proxy['pass']) . "\r\n";


            }


        }


        $auth = '';


        if (!is_null($this->_server['user'])) {


            $auth = "Authorization: Basic " . base64_encode($this->_server['user'] . ":" . $this->_server['pass']) . "\r\n";


        }


        $cookie = '';


        if ($_PHPRPC_COOKIE) {


            $cookie = "Cookie: " . $_PHPRPC_COOKIE . "\r\n";


        }


        $request_id = '';


        if(!empty($_SERVER['HTTP_REQUEST_ID'])){


            $request_id = "Request-ID: " . $_SERVER['HTTP_REQUEST_ID'] . "\r\n";


        }


        $content_len = strlen($request_body);


        $request =


            "POST $url HTTP/{$this->_http_version}\r\n" .


                "Host: {$this->_server['host']}:{$this->_server['port']}\r\n" .


                "User-Agent: PHPRPC Client 3.0 for PHP\r\n" .


                $auth .


                $connection .


                $cookie .


                $request_id .


                "Accept: */*\r\n" .


                "Accept-Encoding: gzip,deflate\r\n" .


                "Content-Type: application/x-www-form-urlencoded; charset={$this->_charset}\r\n" .


                "Content-Length: {$content_len}\r\n" .


                "\r\n" .


                $request_body;


        fputs($this->_socket, $request, strlen($request));


        while (!feof($this->_socket)) {


            $line = fgets($this->_socket);


            if (preg_match('/HTTP\/(\d\.\d)\s+(\d+)([^(\r|\n)]*)(\r\n|$)/i', $line, $match)) {


                $this->_http_version = $match[1];


                $status = (int)$match[2];


                $status_message = trim($match[3]);


                if ($status != 100 && $status != 200) {


                    $this->_disconnect();


                    return new PHPRPC_Error($status, $status_message);


                }


            }


            else {


                $this->_disconnect();


                return new PHPRPC_Error(E_ERROR, "Illegal HTTP server.");


            }


            $header = array();


            while (!feof($this->_socket) && (($line = fgets($this->_socket)) != "\r\n")) {


                $line = explode(':', $line, 2);


                $header[strtolower($line[0])][] =trim($line[1]);


            }


            if ($status == 100) continue;


            $response_header = $this->_parseHeader($header);


            if (is_a($response_header, 'PHPRPC_Error')) {


                $this->_disconnect();


                return $response_header;


            }


            break;


        }


        $response_body = '';


        if (isset($response_header['transfer_encoding']) && (strtolower($response_header['transfer_encoding']) == 'chunked')) {


            $s = fgets($this->_socket);


            if ($s == "") {


                $this->_disconnect();


                return array();


            }


            $chunk_size = (int)hexdec($s);


            while ($chunk_size > 0) {


                $response_body .= $this->_socket_read($chunk_size);


                if (fgets($this->_socket) != "\r\n") {


                    $this->_disconnect();


                    return new PHPRPC_Error(1, "Response is incorrect.");


                }


                $chunk_size = (int)hexdec(fgets($this->_socket));


            }


            fgets($this->_socket);


        }


        elseif (isset($response_header['content_length']) && !is_null($response_header['content_length'])) {


            $response_body = $this->_socket_read($response_header['content_length']);


        }


        else {


            while (!feof($this->_socket)) {


                $response_body .= fread($this->_socket, 4096);


            }


            $this->_keep_alive = false;


            $this->_disconnect();


        }


        if (isset($response_header['content_encoding']) && (strtolower($response_header['content_encoding']) == 'gzip')) {


            $response_body = gzdecode($response_body);


        }


        if (!$this->_keep_alive) $this->_disconnect();


        if ($this->_keep_alive && strtolower($response_header['connection']) == 'close') {


            $this->_keep_alive = false;


            $this->_disconnect();


        }


        return $this->_parseBody($response_body);


    }


    function _parseHeader($header) {


        global $_PHPRPC_COOKIE, $_PHPRPC_COOKIES;


        if (preg_match('/PHPRPC Server\/([^,]*)(,|$)/i', implode(',', $header['x-powered-by']), $match)) {


            $this->_server['version'] = (float)$match[1];


        }


        else {


            return new PHPRPC_Error(E_ERROR, "Illegal PHPRPC server.");


        }


        if (preg_match('/text\/plain\; charset\=([^,;]*)([,;]|$)/i', $header['content-type'][0], $match)) {


            $this->_charset = $match[1];


        }


        if (isset($header['set-cookie'])) {


            foreach ($header['set-cookie'] as $cookie) {


                foreach (preg_split('/[;,]\s?/', $cookie) as $c) {


                    list($name, $value) = explode('=', $c, 2);


                    if (!in_array($name, array('domain', 'expires', 'path', 'secure'))) {


                        $_PHPRPC_COOKIES[$name] = $value;


                    }


                }


            }


            $cookies = array();


            foreach ($_PHPRPC_COOKIES as $name => $value) {


                $cookies[] = "$name=$value";


            }


            $_PHPRPC_COOKIE = join('; ', $cookies);


        }


        if (isset($header['content-length'])) {


            $content_length = (int)$header['content-length'][0];


        }


        else {


            $content_length = NULL;


        }


        $transfer_encoding = isset($header['transfer-encoding']) ? $header['transfer-encoding'][0] : '';


        $content_encoding = isset($header['content-encoding']) ? $header['content-encoding'][0] : '';


        $connection = isset($header['connection']) ? $header['connection'][0] : 'close';


        return array('transfer_encoding' => $transfer_encoding,


            'content_encoding' => $content_encoding,


            'content_length' => $content_length,


            'connection' => $connection);


    }


    function _parseBody($body) {


        $body = explode(";\r\n", $body);


        $result = array();


        $n = count($body);


        for ($i = 0; $i < $n; $i++) {


            $p = strpos($body[$i], '=');


            if ($p !== false) {


                $l = substr($body[$i], 0, $p);


                $r = substr($body[$i], $p + 1);


                $result[$l] = trim($r, '"');


            }


        }


        return $result;


    }


    function _key_exchange() {


        if (!is_null($this->_key) || ($this->_encryptMode == 0)) return true;


        $request = "phprpc_encrypt=true&phprpc_keylen={$this->_keylen}";


        $result = $this->_post($request);


        if (is_a($result, 'PHPRPC_Error')) {


            return $result;


        }


        if (array_key_exists('phprpc_keylen', $result)) {


            $this->_keylen = (int)$result['phprpc_keylen'];


        }


        else {


            $this->_keylen = 128;


        }


        if (array_key_exists('phprpc_encrypt', $result)) {


            $encrypt = unserialize(base64_decode($result['phprpc_encrypt']));


            $x = bigint_random($this->_keylen - 1, true);


            $key = bigint_powmod(bigint_dec2num($encrypt['y']), $x, bigint_dec2num($encrypt['p']));


            if ($this->_keylen == 128) {


                $key = bigint_num2str($key);


            }


            else {


                $key = pack('H*', md5(bigint_num2dec($key)));


            }


            $this->_key = str_pad($key, 16, "\0", STR_PAD_LEFT);


            $encrypt = bigint_num2dec(bigint_powmod(bigint_dec2num($encrypt['g']), $x, bigint_dec2num($encrypt['p'])));


            $request = "phprpc_encrypt=$encrypt";


            $result = $this->_post($request);


            if (is_a($result, 'PHPRPC_Error')) {


                return $result;


            }


        }


        else {


            $this->_key = NULL;


            $this->_encryptMode = 0;


        }


        return true;


    }


    function _encrypt($str, $level) {


        if (!is_null($this->_key) && ($this->_encryptMode >= $level)) {


            $str = xxtea_encrypt($str, $this->_key);


        }


        return $str;


    }


    function _decrypt($str, $level) {


        if (!is_null($this->_key) && ($this->_encryptMode >= $level)) {


            $str = xxtea_decrypt($str, $this->_key);


        }


        return $str;


    }


}






if (function_exists("overload") && version_compare(phpversion(), "5", "<")) {


    eval('


    class PHPRPC_Client extends _PHPRPC_Client {


        function __call($function, $arguments, &$return) {


            $return = $this->invoke($function, $arguments);


            return true;


        }


    }


    overload("phprpc_client");


    ');


}


else {


    class PHPRPC_Client extends _PHPRPC_Client {


        function __call($function, $arguments) {


            return $this->invoke($function, $arguments);


        }


    }


}






function getZhiboIDs()


{


    $input = new SortListInput();


    $input->cataId = 8;
    //$input->vt = '0,4';


    $input->pageSize = 1000;


    $input->areaCode = 12345;


    $input->coolUser = 1;


    $rpc = new PHPRPC_Client();


    $rpc->setKeyLength(0);


    $rpc->setEncryptMode(0);


    $rpc->setTimeout(3);


    $rpc->setCharset('utf-8');

    // 线上 http://client.list.idc.pplive.cn/ikan_id_list_rpc.jsp
    // 线下 http://client-play.pptv.com/ikan_id_list_rpc.jsp
    $rpc->useService('http://client.list.idc.pplive.cn/ikan_id_list_rpc.jsp');

    $data = $rpc->search($input);


    if (isset($data->channelIds)) {


        return $data->channelIds;


    }


    return array();


}

ini_set('display_errors', 1);

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
    $br = "\n";
} else {
    $br = '<br>';
}

echo $br . 'CHANNEL BEGIN' . $br;

$zhiboids = getZhiboIDs();

if (!empty($zhiboids)) {

    $time = date('Y-m-d H:i:s');

    //包含config配置文件
    $env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
    $realpath = dirname(__FILE__);
    $pos = strpos($realpath, 'run',1);
    $path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
    require($path);

    //包含mysql操作类
    require('database.php');
    $table = 'dp_horn_channel';
    $db = new Database($config['database']['default']);
    $rs = $db->fetch('select channel_key from `'.$table.'`');

    // 频道前缀
    $pre = $config['channelpre'];

    //获得channel key array
    $channel_key = array();
    foreach ($rs as $key=>$value) {
        $channel_key[] = $value->channel_key;
    }

    foreach ($zhiboids as $key=>$value ) {
        $ck = $pre.$value;
        if (!in_array($ck,$channel_key)) {
            $stat = $db->insert($table,array('channel_key'=>$ck,'create_time'=>$time));
            if ($stat) {
                echo "Add new channel [".$ck."] to ".$table." success!".$br;
            } else {
                echo "Add new channel [".$ck."] to ".$table." failure!".$br;
            }
        }
    }

} else {

    echo 'NO channel found';

}

echo $br."DONE".$br;

?>
