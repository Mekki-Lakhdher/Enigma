<?php
/**
 * Created by PhpStorm.
 * User: Mekki
 * Date: 09/04/2020
 * Time: 15:39
 */

namespace App\Controller;

use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use DateTime;

class HomeController extends AbstractController
{

    public function index() {
        $user = $this->getUser();

        if ($user) {
            return $this->render("home/home.html.twig",array(
                'user'=>$user,
            ));
        }
        else {
            return $this->render("base.html.twig");
        }

    }

    /**
     * @Route("/start_time/{id}", name="start_time")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveEnigmaTimeStart(Request $request)
    {
        // Set user's enigma_time_start
        $enigma_date_start = new DateTime();
        $id=$request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setEnigmaTimeStart($enigma_date_start);
        $entityManager->persist($user);
        $entityManager->flush();

        $resp = [
            //'date' => ($enigma_date_start),
        ];

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($resp));

        return $response;
    }

    /**
     * @Route("/check_enigma_time/{id}", name="check_enigma_time")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getEnigmaStartTime(Request $request)
    {
        // Set user's enigma_time_start
        $id=$request->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if ($user->getEnigmaTimeStart()) {
            $starting_date=$user->getEnigmaTimeStart();
        }
        else {$starting_date='NULL';}

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($starting_date));

        return $response;
    }

}