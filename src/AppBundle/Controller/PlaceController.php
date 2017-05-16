<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get; // N'oublons pas d'inclure Get
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Place;

class PlaceController extends Controller
{

  /**
  * @Get("/places")
  */
    public function getPlacesAction(Request $request)
    {
        $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->findAll();
        /* @var $places Place[] */

        $formatted = [];
        foreach ($places as $place) {
            $formatted[] = [
               'id' => $place->getId(),
               'name' => $place->getName(),
               'address' => $place->getAddress(),
            ];
        }

        return new JsonResponse($formatted);
    }

    /**
    * @Get("/places/{id}")
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

        $formatted[] = [
           'id' => $place->getId(),
           'name' => $place->getName(),
           'address' => $place->getAddress(),
        ];

        return new JsonResponse($formatted);
    }
}
