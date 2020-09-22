<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/{_locale}", name="home", requirements={"_locale"="fr|en"})
     */
    public function home(Request $request)
    {
        return $this->render("default/home.html.twig");
    }

    /**
     * @Route("/{_locale}/aboutus", name="default_aboutus",requirements={"_locale"="fr|en"})
     */
    public function aboutus()
    {
        return $this->render("default/aboutus.html.twig");
    }

}