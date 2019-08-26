<?php

namespace App\Hello;

use App\Entity\Artist;

class WikiArtist {

    private $address;
    private $format;

    public function __construct($url, $f) {
        $this -> address = $url;
        $this -> format = $f;
    }

    public function getWiki(Artist $artist) {
        
        $a = str_replace(" ", "_", $artist -> getName());

        $this -> address .= $a.$this -> format;
        
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->address);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_TIMEOUT, 4);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($c);
        $response = json_decode($response,true);
        curl_close($c);
        return $response[3][0];
    }

}