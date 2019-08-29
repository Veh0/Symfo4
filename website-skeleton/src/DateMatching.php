<?php

namespace App;

class DateMatching {

    public function isInDateInterval($d1,$d2,$d3) {

    }

    public function isPast($d1) {

        $now = new \DateTime();

        if ($d1 > $now) {
            return false;
        } else {
            return true;
        }
    }

    public function isOverlapping($d1,$d2,$d3,$d4) {

        if ($d2 <= $d3 || $d1 >= $d4) {
            return false;
        } else {
            return true;
        }

    }

}