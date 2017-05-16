<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\User;

class UserController extends Controller
{

  /**
  * @Rest\View()
  * @Rest\get("/users")
  */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->findAll();

// Much code wihtout the fosrest Bundle

        // $formatted = [];
        // foreach ($users as $user) {
        //     $formatted[] = [
        //        'id' => $user->getId(),
        //        'firstname' => $user->getFirstname(),
        //        'lastname' => $user->getLastname(),
        //        'email' => $user->getEmail(),
        //     ];
        //
        // }


    // Much less code with the fosrest Bundle

        $view = View::create($users);
        $view->setFormat('json');

        return $view;

        //return new JsonResponse($formatted);
    }

    /**
    * @Rest\Get("/users/{id}")
    */
public function getUserAction(Request $request)
{
    $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($request->get('id')); // L'identifiant est utilisé directement
                    /* @var $place Place */
                    // ...
                 if (empty($user)) {
               return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
           }

    //        $formatted = [
    //           'id' => $user->getId(),
    //           'firstname' => $user->getFirstname(),
    //           'lastname' => $user->getLastname(),
    //           'email' => $user->getEmail(),
    //        ];
    //
    // return new JsonResponse($formatted);

    $view = View::create($user);
    $view->setFormat('json');

    return $view;
}


}
