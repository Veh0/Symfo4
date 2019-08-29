<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\DateMatching;

class DataMatchingTest extends TestCase {

    // verifier sir l'event est passé
    // test 4 dates 
    protected $dm;

    public function dateProvider() {
        return [
            'date1' => [new \DateTime('1997-06-04'), true],
            'date2' => [new \DateTime('2007-06-04'), true],
            'date3' => [new \DateTime('2027-06-04'), false],
        ];
    }
    /**
     * @dataProvider dateProvider
     */
    public function testIsPast($d, $truth)  {
        $result = $this -> dm -> isPast($d);
        $this -> assertEquals($truth, $result);
    }

    public function lapProvider() {
        return [
            'date1' => [new \DateTime('1997-06-04'), new \DateTime('1997-06-10'),new \DateTime('1997-06-08'),new \DateTime('1997-06-12'), true],
            'date2' => [new \DateTime('2007-06-04'), new \DateTime('2007-06-10'),new \DateTime('2007-06-11'),new \DateTime('2007-06-12'), false],
            'date3' => [new \DateTime('2007-06-04'), new \DateTime('2007-06-10'),new \DateTime('2007-05-31'),new \DateTime('2007-06-03'), false],
        ];
    }
    /**
     * @dataProvider lapProvider
     */
    public function testIsOverlapping($d1,$d2,$d3,$d4,$truth) {
        $result = $this -> dm -> isOverlapping($d1,$d2,$d3,$d4); 
        $this -> assertEquals($truth, $result);
    }


    public function setUp() {
        $this -> dm = new DateMatching;
    }

}