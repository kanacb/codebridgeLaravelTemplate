<?php

namespace App\Utils;

class StringHandling {

    public function abbreviate($string){
        $abbreviation = "";
        $string = ucwords($string);
        $words = explode(" ", $string);
        foreach($words as $word){
            if(isset($word[0]))
                $abbreviation .= $word[0];
        }
        return $abbreviation;
    }

    public function get_operating_system() {
        $u_agent = php_uname();
        $operating_system = 'Unknown Operating System';
        // print($u_agent);

        //Get the operating_system name
        if (preg_match('/linux/i', $u_agent)) {
            $operating_system = 'Linux';
        } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
            $operating_system = 'Mac';
        } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
            $operating_system = 'Windows';
        } elseif (preg_match('/ubuntu/i', $u_agent)) {
            $operating_system = 'Ubuntu';
        }
        return $operating_system;
    }

}