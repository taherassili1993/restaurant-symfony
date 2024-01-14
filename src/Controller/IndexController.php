<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Profiler\Profiler;

use App\Entity\Restaurant;

class IndexController extends AbstractController
{
    /**
     *
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        return $this->render('index.html.twig', ['name' => 'hello world !!!']);
    }

    /**
     *
     * @Route("/recherche", name="recherche")
     */
    public function restaurants(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);

        $q = $request->query->get('q', '');

        $restaurants = $repository->search(0, 12, $q);

        return $this->render('restaurants.html.twig', ['restaurants' => $restaurants]);
    }

}
