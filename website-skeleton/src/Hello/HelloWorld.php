<?php 

namespace App\Hello;

class HelloWorld {

    private $prenom;
    private $magnifier;

    public function __construct(string $p, Magnifier $m) {
        $this -> prenom = $p;
        $this -> magnifier = $m;
    }

    function yoUpper() {
        return $this -> magnifier -> upper($this -> yo());
    }

    function yo() {
        return "Yo ".$this -> prenom."!";
    }

}