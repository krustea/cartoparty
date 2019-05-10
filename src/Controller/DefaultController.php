<?php


namespace App\Controller;
use App\Entity\Category;
use App\Entity\Party;
use App\Entity\Travel;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends BaseController
{
     /**
      * @Route("/", name="homepage")
      */
    public function homepage()
    {

       $aller= $this->getDoctrine()->getRepository(Category::class)->findOneBy(['label'=>Category::ALLER]);
       $retour= $this->getDoctrine()->getRepository(Category::class)->findOneBy(['label'=>Category::RETOUR]);
       $allertravels = $this->getDoctrine()->getRepository(Travel::class)->findByCategory(null, $aller,6);
       $retourtravels = $this->getDoctrine()->getRepository(Travel::class)->findByCategory(null, $retour,6);
       $parties = $this->getDoctrine()->getRepository(Party::class)->findBy([],['createdAt'=> 'DESC'], 3);



        return $this->render('default/homepage.html.twig',[
            "allers"=>$allertravels,
            "retours"=>$retourtravels,
            "parties"=>$parties,
        ]);
    }

}