<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 


class AppFixtures extends Fixture
{
    //private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder,ContainerInterface $container)
    {
        $this->passwordEncoder =$passwordEncoder;
        $this->container =$container;
    }

    public function load(ObjectManager $manager): void
    {
        $host = $this->container->getParameter('app.folder');
        $url = $host."getData.php?type=users";
        $getUserData = json_decode(file_get_contents($url));
        foreach($getUserData as $key){
           
         $post = new User();
            $post->setName($key->name);
            $post->setEmail($key->email);
            $post->setPassword($this->passwordEncoder->encodePassword($post,$key->password));
            $value = ["ROLE_USER"];
            $post->setRoles((array)$value);
         $manager->persist($post);
      
    }
    $manager->flush();
    }
}
