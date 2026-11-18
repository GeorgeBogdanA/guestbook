<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final class ConferenceController extends AbstractController
{
    //#[Route('/conference', name: 'app_conference')]
    #[Route('/', name: 'homepage')]
    //public function index(): Response
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
////        return $this->render('conference/index.html.twig', [
////            'controller_name' => 'ConferenceController',
////        ]);
//        return new Response(<<<EOF
//            <html>
//                <body>
//                    <img src="/images/under-construction.gif" />
//                </body>
//            </html>
//            EOF
//        );
        return new Response($twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
        ]));
    }
}
