<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Artist;
use \App\Entity\Product;
use \App\Entity\Event;
use \App\Entity\Actu;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private static $eventType = [
        'Concert',
        'Festival'
    ];

    private static $musicStyle = [
        'Rap',
        'Rock',
        'Country',
        'Metal',
        'Grunge'
    ];

    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create();
        
        
        for ($i=0; $i < 10; $i++) { 
            $artist = new Artist();
            
            $artist -> setName($faker -> firstName." ".$faker -> lastName)
                    ->setCountry($faker -> country)
                    ->setStyle($faker -> randomElement(self::$musicStyle))
                    ->setDescription($faker -> sentence($nbWords = 15, $variableNbWords = true));
                     $manager->persist($artist); 
        }
        $manager -> flush();
        $a = $manager -> getRepository(Artist::class);
        $arrayArtist = $a -> findAll();
        
        foreach($arrayArtist as $key) {
            for ($y=0; $y < 15; $y++) { 
                
                $product = new Product();
                        
                $product    -> setTitle($faker -> sentence($nbWords = 2, $variableNbWords = true))
                            ->setArtistId($key)
                            ->setProductionDate($faker -> date($format = 'Y-m-d'))
                            ->setDescription($faker -> sentence($nbWords = 15, $variableNbWords = true));

                            $manager -> persist($product);
            }
            for ($y=0; $y < 5; $y++) { 
                
                $event = new Event();
                $unixTimestamp = '1629384670'; 
                $event    -> setType($faker -> randomElement(self::$eventType))
                            ->setArtistId($key)
                            
                            ->setEndDate($faker -> date($format=('d-m-Y H:i'), $max = $unixTimestamp))
                            ->setStartDate($faker -> date($format=('d-m-Y H:i'), $max = $event -> getEndDate() ))
                            ->setPlace($faker -> stateAbbr)
                            ->setCity($faker -> city)
                            ->setDescription($faker -> sentence($nbWords = 15, $variableNbWords = true))
                            ->setPrice($faker -> numberBetween($min= 45, $max= 225));

                            $manager -> persist($event);
            }

            

        }
            
        $manager -> flush();

        for ($z=0; $z < 13; $z++) { 
                $actu = new Actu();
                $actu -> setTitle($faker -> sentence($nbWords = 3, $variableNbWords = true))
                      -> setDescription($faker -> realText(500))
                      -> setImg($faker -> imageUrl($width = 1280, $height = 550));

                $manager -> persist($actu);
            }         
                
        
        
        /* for ($i=0; $i < count($arrayArtist) ; $i++) { 
            self::$arrayID[] = $arrayArtist[$i] -> getId();
        }
        foreach (self::$arrayID as $key) {
            for ($y=0; $y < 15; $y++) { 
                $product = new Product();
            
                $product -> setTitle($faker -> sentence($nbWords = 1, $variableNbWords = true))
                    ->setArtistId($key)
                    ->setProductionDate($faker -> date($format = 'Y-m-d'))
                    ->setDescription($faker -> sentence($nbWords = 15, $variableNbWords = true));
                $manager->persist($product);  
            }
        } */

        $manager->flush();   
    }


}
