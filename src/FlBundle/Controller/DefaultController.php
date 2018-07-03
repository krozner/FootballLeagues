<?php

namespace FlBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function homeAction()
    {
        return $this->json([]);
    }

    /**
     * @Route("/token")
     */
    public function tokenAction()
    {
        $user = $this->getDoctrine()
            ->getRepository("FlBundle:User")
            ->findOneBy([]);

        return $this->json([
            'token' => $this->get('lexik_jwt_authentication.jwt_manager')->create($user)
        ]);
    }

    /**
     * @Route("/api/test", methods={"GET"})
     */
    public function testAction()
    {
        return $this->json([]);
    }
}
