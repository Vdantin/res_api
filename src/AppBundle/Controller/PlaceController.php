<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Place;

class PlaceController extends Controller
{

  /**
  * @Rest\View()
  * @Rest\Get("/places")
  */
    public function getPlacesAction(Request $request)
    {
        $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->findAll();
        /* @var $places Place[] */

        // $formatted = [];
        // foreach ($places as $place) {
        //     $formatted[] = [
        //        'id' => $place->getId(),
        //        'name' => $place->getName(),
        //        'address' => $place->getAddress(),
        //     ];
        //   }

          // Création d'une vue FOSRestBundle
      $view = View::create($places);
      $view->setFormat('json');

      return $view;

        }
        //return new JsonResponse($formatted);

    /**
    * @Rest\Get("/places/{id}")
    */
    public function getPlaceAction(Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->find($request->get('id')); // L'identifiant est utilisé directement
        /* @var $place Place */
        // ...

        if (empty($place)) {
        return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
       }

       $view = View::create($place);
       $view->setFormat('json');

       return $view;
    }
}
