<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;

class UserController extends Controller
{
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->findAll();

        $formatted = [];
        foreach ($users as $user) {
            $formatted[] = [
               'id' => $user->getId(),
               'firstname' => $user->getFirstname(),
               'lastname' => $user->getLastname(),
               'email' => $user->getEmail(),
            ];
        }

        return new JsonResponse($formatted);
    }


public function getUserAction($id, Request $request)
{
    $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($id); // L'identifiant est utilisé directement
                    /* @var $place Place */
                    // ...
                 if (empty($user)) {
               return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
           }

           $formatted = [
              'id' => $user->getId(),
              'firstname' => $user->getFirstname(),
              'lastname' => $user->getLastname(),
              'email' => $user->getEmail(),
           ];

    return new JsonResponse($formatted);
}


}
