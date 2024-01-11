<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Profiler\Profiler;

use App\Entity\Restaurant;

class MonRestaurantController extends AbstractController
{
    /**
     *
     * @Route("/mon-restaurant", name="mon-restaurant")
     */
    public function mon_restaurant(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurant = $repository->findOneBy(['user' => $this->getUser()->getId()]);
        if(!$restaurant)
        {
            $restaurant = new Restaurant();
        }

        if($request->getMethod() == 'POST')
        {
            $nom = $request->get('nom', '');
            $telephone = $request->get('telephone', '');
            $addresse = $request->get('addresse', '');

            $restaurant->setNom($nom);
            $restaurant->setTelephone($telephone);
            $restaurant->setAddresse($addresse);
            $restaurant->setUser($this->getUser());

            $em->persist($restaurant);
            $em->flush();
        }

        return $this->render('mon_restaurant.html.twig', ['restaurant' => $restaurant]);
    }

}
