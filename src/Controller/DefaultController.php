<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render("default/home.html.twig");
    }

    /**
     * @Route("/aboutus", name="default_aboutus")
     */
    public function aboutus()
    {
        return $this->render("default/aboutus.html.twig");
    }
}