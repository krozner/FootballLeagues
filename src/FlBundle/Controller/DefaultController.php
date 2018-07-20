<?php

declare(strict_types=1);

namespace FlBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * for test only
     *
     * @Route("/token")
     */
    public function tokenAction()
    {
        $user = $this->getDoctrine()
            ->getRepository('FlBundle:User')
            ->findOneBy([]);

        return $this->get('api_response')->create([
            'token' => $this->get('lexik_jwt_authentication.jwt_manager')->create($user),
        ]);
    }
}
