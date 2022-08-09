<?php

namespace App\Controller;

use DateTime;
use App\Entity\Posts;

use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class PostController extends AbstractController
{
    private $postsRepository;
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(PostsRepository $postsRepository, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->postsRepository = $postsRepository;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/posts", name="app_post")
     */
    public function index(PostsRepository $postsRepository): Response
    {
        //$cache = new FilesystemAdapter();
        // $stock = $cache->get(function (ItemInterface $item) use ($entityManager){

        //     $repo = $entityManager->getRepository(Posts::class);
        // });

        $data = $postsRepository->findAll();
        if (count($data) > 0) {

            return $this->json([
                'message' => 'Post list',
                'list' => $data,
            ]);
        } else {
            return $this->json([
                'message' => 'No record found',
                'list' => array(),
            ]);
        }
    }

}
