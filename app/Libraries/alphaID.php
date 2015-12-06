<?php
/*
|--------------------------------------------------------------------------
| alphaID()
|--------------------------------------------------------------------------
|  
| Converts number to slug. 
|
|
| http://stackoverflow.com/questions/5422065/php-random-url-names-short-url
*/
namespace App\Library;

function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{
    //$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $index = "6XyhVzCFA3xTgUjBRnJPmZHw2DesOrviEaGIoLklQ4dSN7bcqY015fuMKpWt98";
    //$index = "7MXZIsTD3Gg1xAbOhQuSrWV6tJdmiERj0lkwn5yfBpHNFYe2z8UCKqcPLva4o9";
    //$index = "R5zvjXYplUMSQwiaFq3Vn4NZEW7cxLG1KyfsbPeJdBt986DO2kACrgH0uTohIm";
    //$index = "5EwPugpAWckVRF1diZ9Dx4efaQLB8lHY30UyvOrMC2t6hsnbmKTjGJo7SXNzIq";

    if ($passKey !== null)
    {
        /* Although this function's purpose is to just make the
        * ID short - and not so much secure,
        * with this patch by Simon Franz (http://blog.snaky.org/)
        * you can optionally supply a password to make it harder
        * to calculate the corresponding numeric ID */

        for ($n = 0; $n<strlen($index); $n++)
        {
            $i[] = substr( $index,$n ,1);
        }

        $passhash = hash('sha256',$passKey);

        $passhash = (strlen($passhash) < strlen($index)) ? hash('sha512',$passKey) : $passhash;

        for ($n=0; $n < strlen($index); $n++)
        {
            $p[] =  substr($passhash, $n ,1);
        }

        array_multisort($p,  SORT_DESC, $i);
        $index = implode($i);
    }

    $base  = strlen($index);

    if ($to_num)
    {
        // Digital number  <<--  alphabet letter code
        $in  = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;

        for ($t = 0; $t <= $len; $t++)
        {
            $bcpow = bcpow($base, $len - $t);
            $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }

        if (is_numeric($pad_up))
        {
            $pad_up--;
            if ($pad_up > 0)
            {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    }
    else
    {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up))
        {
            $pad_up--;
            if ($pad_up > 0)
            {
                $in += pow($base, $pad_up);
            }
        }

        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--)
        {
            $bcp = bcpow($base, $t);
            $a   = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in  = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }
    return $out;
}