<?php


namespace App\Controller;
use App\Entity\Travel;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends BaseController
{
     /**
      * @Route("/", name="homepage")
      */
    public function homepage()
    {
//        $travel->getDoctrine()->getRepository(Travel::class)->findOneBy()

        return $this->render('default/homepage.html.twig');
    }
}