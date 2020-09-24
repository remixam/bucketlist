<?php

namespace App\Controller;


use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class APIController extends AbstractController
{
    /**
     * @Route("/idea", name="create_idea", methods={"POST"})
     */
    public function create(Request $request, \Symfony\Component\Serializer\SerializerInterface $sSeria,
    EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $idea = $sSeria->deserialize($request->getContent(), Idea::class, 'json');
        $error = $validator->validate($idea);
        if(count($error)){
            return JsonResponse::create($error, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($idea);
        $em->flush();

        return JsonResponse::create(null,
            Response::HTTP_CREATED,
            ["Location" => "/fr/idea-list/".$idea->getId()]);

    }

    /**
     * @Route("/idea/{id}", name="show_idea", methods={"GET"})
     */
    public function show(Request $request, \Symfony\Component\Serializer\SerializerInterface $sSeria,
                           EntityManagerInterface $em, IdeaRepository $ideaRepository, $id)
    {
        $idea = $ideaRepository->findBy(["id"=>$id]);

        $response = new JsonResponse();

        return $response->setContent(
            $sSeria->serialize(
                $idea, 'json'
            )
        );

    }
}
