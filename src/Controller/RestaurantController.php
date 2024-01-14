<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Profiler\Profiler;

use App\Entity\Restaurant;

class RestaurantController extends AbstractController
{
    /**
     *
     * @Route("/restaurants", name="restaurants")
     */
    public function restaurants(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repository->findAll();

        return $this->render('restaurants.html.twig', ['restaurants' => $restaurants]);
    }

}
