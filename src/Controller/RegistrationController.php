<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("api", name="api_")
 */
class RegistrationController extends AbstractFOSRestController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function index(Request $request)
    {
        if(!isset($_REQUEST['email']) || empty($_REQUEST['email'])){
            $res = array("message"=>"Email required");
            return new Response(json_encode($res));

        }
        if(!isset($_REQUEST['password']) || empty($_REQUEST['password'])){
            $res = array("message"=>"Password required");
            return new Response(json_encode($res));

        }
        if(!isset($_REQUEST['name']) || empty($_REQUEST['name'])){
            $res = array("message"=>"Name required");
            return new Response(json_encode($res));

        }
        $email = $request->get('email');
        $password = $request->get('password');
        $name = $request->get('name');

        $user = $this->userRepository->findOneBy([
            'email' => $email,
        ]);

        if (!is_null($user)) {
            $res = array("message"=>"User already exists");
            return new Response(json_encode($res));
        }

        $user = new User();

        $user->setEmail($email);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $password)
        );
        $user->setName($name);
        $value = ["ROLE_USER"];
        //$roles = json_encode($value,true);
        $user->setRoles((array)$value);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $res = array("message"=>"Register successful");
        return new Response(json_encode($res));
        //return $this->view($user, Response::HTTP_CREATED)->setContext((new Context())->setGroups(['public']));
    }
}