<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use App\Repository\IdeaRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends AbstractController
{
    /**
     * @Route("/{_locale}/idea-list", name="idea_list")
     */
    public function list(EntityManagerInterface $em)
    {


        $ideaRepo = $em->getRepository(Idea::class);
        $idea = $ideaRepo->findBy([],["dateCreated" => "DESC"]);
        dump($idea);
        return $this->render('idea/list.html.twig', [
            'controller_name' => 'IdeaController',
            'idea' => $idea
        ]);
    }

    /**
     * @Route("/{_locale}/idea-add", name="idea_add")
     */
    public function add(EntityManagerInterface  $em, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $idea = new Idea();
        $ideaForm = $this->createForm(IdeaType::class, $idea);

        $ideaForm->handleRequest($request);
        if($ideaForm->isSubmitted() && $ideaForm->isValid()){

            $em->persist($idea);
            $em->flush();
            $this->addFlash("success", "Idea successfully added!");
            return $this->redirectToRoute("idea_detail", ["id" => $idea->getId()]);
        }

        return $this->render('idea/add.html.twig', [
            'controller_name' => 'IdeaController',
            'ideaForm' => $ideaForm->createView()
        ]);
    }

    /**
     * @Route("/{_locale}/idea-detail/{id}", name="idea_detail")
     */
    public function detail($id, EntityManagerInterface  $em)
    {
        $ideaRepo = $em->getRepository(Idea::class);
        $idea = $ideaRepo->find($id);
        return $this->render('idea/detail.html.twig', [
            'controller_name' => 'IdeaController',
            'idea' => $idea
        ]);
    }
}
