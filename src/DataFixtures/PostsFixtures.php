<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $post = new Posts();
            $post->setTitle("Hello");
            $post->setBody("Okkkk");
            $post->setPublishDate("2020-08-07");
         $manager->persist($post);

        $manager->flush();
    }
}
