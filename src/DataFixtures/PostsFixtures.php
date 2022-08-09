<?php

namespace App\DataFixtures;


use App\Entity\Posts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerInterface; 

class PostsFixtures extends Fixture
{
    public function __construct( ContainerInterface $container)
    {
        $this->container =$container;
    }

    public function load(ObjectManager $manager): void
    {
        $host = $this->container->getParameter('app.folder');
        $url = $host."getData.php?type=posts";
        $getUserData = json_decode(file_get_contents($url));
        foreach($getUserData as $key){
           
         $post = new Posts();
            $post->setTitle($key->title);
            $post->setBody($key->body);
            $post->setPublishDate($key->publish_date);
         $manager->persist($post);

        $manager->flush();
    }
    }
}
