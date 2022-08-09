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
     * @Route("/post", name="app_post")
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

    /**
     * @Route("/addpost", name="addpost", methods="POST")
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function addpost(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        if (!isset($parameters['title']) || empty($parameters['title'])) {
            $res = array("message" => "Title required");
            return new Response(json_encode($res));
        }

        if (!isset($parameters['body']) || empty($parameters['body'])) {
            $res = array("message" => "Message required");
            return new Response(json_encode($res));
        }

        if (!isset($parameters['date']) || empty($parameters['date'])) {
            $res = array("message" => "Date required");
            return new Response(json_encode($res));
        }

        if (DateTime::createFromFormat('Y-m-d', $parameters['date']) || DateTime::createFromFormat('d-m-Y', $parameters['date']) || DateTime::createFromFormat('n-d-Y', $parameters['date'])) {

            $title = $parameters['title'];
            $body = $parameters['body'];
            $date = date("Y-m-d", strtotime($parameters['date']));
            if (!DateTime::createFromFormat('Y-m-d', $parameters['date'])) {
                $date = date("Y-m-d", strtotime($parameters['date']));
            } else {
                $date = $parameters['date'];
            }

            $post = new Posts();

            $post->setTitle($title);
            $post->setBody($body);
            $post->setPublishDate($date);

            $this->entityManager->persist($post);
            $this->entityManager->flush();

            return $this->json([
                'message' => 'Post created succesfully'
            ]);
        } else {
            $res = array("message" => "Wrong Date Format");
            return new Response(json_encode($res));
        }
    }
}
