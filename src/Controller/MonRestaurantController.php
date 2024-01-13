<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Profiler\Profiler;

use App\Entity\Restaurant;
use App\Entity\Repas;

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
        $repasRepository = $this->getDoctrine()->getRepository(Repas::class);

        $restaurant = $repository->findOneBy(['user' => $this->getUser()->getId()]);
        if(!$restaurant)
        {
            $restaurant = new Restaurant();
            $repas = [];
        } else {
            $repas = $repasRepository->findBy(['restaurant' => $restaurant]);
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

            return $this->redirectToRoute('mon-restaurant');
        }

        return $this->render('mon_restaurant.html.twig', ['restaurant' => $restaurant, 'repas' => $repas]);
    }

    /**
     *
     * @Route("/ajouter-repas", name="ajouter-repas")
     */
    public function ajouter_repas(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurant = $repository->findOneBy(['user' => $this->getUser()->getId()]);
        if(!$restaurant)
        {
            return $this->redirectToRoute('mon-restaurant');
        }

        $nom = $request->get('nom', '');
        $prix = $request->get('prix', '');

        $repas = new Repas();

        $repas->setNom($nom);
        $repas->setPrix($prix);
        $repas->setRestaurant($restaurant);

        $em->persist($repas);
        $em->flush();

        return $this->redirectToRoute('mon-restaurant');
    }

    /**
     *
     * @Route("/supprimer-repas/{id}", name="supprimer-repas")
     */
    public function supprimer_repas(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Repas::class);

        $repas = $repository->findOneBy(['id' => $id]);
        if($repas)
        {
            $em->remove($repas);
            $em->flush();
        }
        return $this->redirectToRoute('mon-restaurant');
    }

}
