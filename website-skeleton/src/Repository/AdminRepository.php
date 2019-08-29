<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AdminRepository {

    function toJoinDQL($manager, $table1, $table2, array $array, $groupBy) {

        $args = implode(",", $array);

        $query = $manager -> createQuery('SELECT '.$args.' FROM '.$table1.' a JOIN a.'.$table2.' b GROUP BY '.$groupBy);
        
        $result = $query->getResult();

        return $result;
    }

    function toDQL($manager, $table1, array $array, $groupBy) {

        $args = implode(",", $array);

        $query = $manager -> createQuery('SELECT '.$args.' FROM '.$table1.' a GROUP BY '.$groupBy);
        
        $result = $query->getResult();

        return $result;
    }

}