<?php

namespace ST\PlatformBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use ST\PlatformBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CreateTricksCommand extends ContainerAwareCommand{
    protected function configure()
    {
        $this
            ->setName('app:create-tricks')
            ->setDescription('Create new tricks.')
            ->setHelp("This command allows you to create tricks based on the yaml file put as argument")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repoGroup = $em->getRepository('STPlatformBundle:TrickGroup');
        $repoUser = $em->getRepository('STUserBundle:User');

        $data = Yaml::parse(file_get_contents(dirname(__FILE__).'/tricks.yml'));

        foreach($data as $var){
            $trick = new Trick();
            $trick->setName($var['name']);
            $trick->setDescription($var['description']);
            $trick->setTrickgroup(($repoGroup->getGoodGroup($var['trickgroup']))[0]);
            $trick->setUser(($repoUser->getGoodUser($var['username']))[0]);

            $em->persist($trick);
            $em->flush();
        }
    }
}