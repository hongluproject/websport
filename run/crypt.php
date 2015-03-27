<?php

class Crypt
{
    private static $_keys = array(
        'cookie'   => 'DAEFE3161F3578E0DFDFABD28C9E2F567A27EE5F2F8A2C9B',
        'passport' => array(
            '15B9FDAEDA40F86BF71C73292516924A294FC8BA31B6E9EA',
            '29028A7698EF4C6D3D252F02F4F79D5815389DF18525D326',
            'D046E6B6A4A85EB6C44C73372A0D5DF1AE76405173B3D5EC',
            '435229C8F79831131923F18C5DE32F253E2AF2AD348C4615',
            '9B2915A72F8329A2FE6B681C8AAE1F97ABA8D9D58576AB20',
            'B3B0CD830D92CB3720A13EF4D93B1A133DA4497667F75191',
            'AD327AFB5E19D023150E382F6D3B3EB5B6319120649D31F8',
            'C42F31B008BF257067ABF115E0346E292313C746B3581FB0',
            '529B75BAE0CE2038466704A86D985E1C2557230DDF311ABC',
            '8A529D5DCE91FEE39E9EE9545DF42C3D9DEC2F767C89CEAB'
        )
    );

    private static $_vectors = array(
        'passport' => '70706C6976656F6B',
        'cookie'   => '0102030405060708',
    );

    public static function encrypt($type, $input, $index = 1){
        $key = self::getKey($type, $index);
        $iv = self::getVector($type);
        return self::tripleDesEncrypt($input, $key, $iv);
    }

    public static function decrypt($type, $input, $index = null)
    {
        $key = self::getKey($type, $index);
        $iv = self::getVector($type);
        return self::tripleDesDecrypt($input, $key, $iv);
    }

    public static function getKey($name, $index = null)
    {
        $keys = self::$_keys[$name];

        if (!is_array($keys)) return $keys;

        if (!$index) $index = 1;
        return $keys[$index - 1];
    }

    public static function getVector($name)
    {
        return self::$_vectors[$name];
    }

    public static function tripleDesEncrypt($input, $key, $iv)
    {
        $key = pack('H48', $key);
        $iv = pack('H16', $iv);

        //PaddingPKCS7补位
        $srcdata = $input;
        $block_size = mcrypt_get_block_size('tripledes', 'ecb');
        $padding_char = $block_size - (strlen($input) % $block_size);
        $srcdata .= str_repeat(chr($padding_char), $padding_char);
        return base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $srcdata, MCRYPT_MODE_CBC, $iv));
    }

    public static function tripleDesDecrypt($input, $key, $iv)
    {
        $input = base64_decode($input);
        $key = pack('H48', $key);
        $iv = pack('H16', $iv);
        $result = mcrypt_decrypt(MCRYPT_3DES, $key, $input, MCRYPT_MODE_CBC, $iv);
        $end = ord(substr($result, -1));
        $out = substr($result, 0, -$end);
        return $out;
    }
}
