<?php

namespace ST\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ST\PlatformBundle\Entity\TrickGroup;

class LoadTrickGroup implements FixtureInterface
{
    public function load(ObjectManager $manager){
        $names = array(
            'Grab',
            'Rotation',
            'Flip',
            'Slide',
            'Old School'
        );

        foreach($names as $name){
            $trickgroup = new TrickGroup();
            $trickgroup->setName($name);

            $manager->persist($trickgroup);
        }

        $manager->flush();
    }
}