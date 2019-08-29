<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Event;

class EventTest extends TestCase {

    // verifier sir l'event est passé
    // test 4 dates 

    public function testIsPast(Event $e) : bool {

        $eventDate = new \DateTime($e -> getStartDAte());
        $now = new \DateTime();

        if ($eventDate > $now) {
            return false;
        } else {
            return true;
        }

    }

}