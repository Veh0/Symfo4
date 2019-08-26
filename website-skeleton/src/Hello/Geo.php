<?php

namespace App\Hello;

use App\Entity\Event;

class Geo {

    private $address;
    public function __construct(string $url) {
        
        $this -> address = $url;
    }

    public function geolocalisation(Event $event)  {
        $city = str_replace(" ", "+",$event->getCity());
        $this->address .= $city; 
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->address);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_TIMEOUT, 4);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($c);
        $response = json_decode($response,true);
        curl_close($c);
        
        return $response;

    }


}