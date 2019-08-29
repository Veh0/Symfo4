<?php 

namespace App\Tests;

use App\Entity\Artist;
use PHPUnit\Framework\TestCase;

class ArtistRepository extends TestCase {

    private $entityManager;

    public function setUp() {

        $kernel = self::bootKernel();

    }

}