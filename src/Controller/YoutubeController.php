<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $youtube = new Youtube();

        $form = $this->createForm(YoutubeType::class, $youtube);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ) {
            $youtube = $form->getData();

            $em->persist($youtube);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        
        return $this->render('youtube/index.html.twig', [
            'controller_name'   => 'YoutubeController',
            'form'              => $form->createView(),
        ]);
    }
}
