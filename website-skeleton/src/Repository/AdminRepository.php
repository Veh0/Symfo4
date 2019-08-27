<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AdminRepository {

    function toJoinDQL($manager, $table1, $table2, array $array, $having = NULL, $where = NULL, array $parameters) {

        $args = implode(",", $array);

        $query = $manager -> createQuery('SELECT a, '.$args.' FROM '.$table1.' a JOIN a.'.$table2.' b '.$where.' GROUP BY b.id '.$having.'');
        for ($i=0; $i < count($parameters); $i++) { 
            # code...
            $query -> setParameter($i,$parameters[$i]);
        }
        
        $result = $query->getResult();

        return $result;
    }

}