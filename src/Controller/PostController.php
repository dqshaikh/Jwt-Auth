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



class PostController extends AbstractController
{
    private $postsRepository;
    private $entityManager;

    public function __construct(PostsRepository $postsRepository, EntityManagerInterface $entityManager)
    {
        $this->postsRepository = $postsRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/posts", name="app_post")
     */
    public function index(PostsRepository $postsRepository): Response
    {
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
