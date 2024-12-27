<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/commentaire', name: 'commentaire.')]

class CommentaireController extends AbstractController
{
    #[Route('', name: 'index',methods:['GET'])]
    public function index(Request $request, CommentaireRepository $commentaireRepository): JsonResponse
    {

        $data = $request->toArray();

        $commentaire = $commentaireRepository->findAll();




        return $this->json([
            'message' => 'Welcome to your new controller!',
            'data' => [
                'id'=>$commentaire
            ],
        ]);


    }


    #[Route('/new', name: 'new',methods:['POST'])]
       public function new (Request $request, EntityManagerInterface $entityManager, RecetteRepository $recette ,ValidatorInterface $validator
       ):JsonResponse{
        $data = $request->toArray();
        $dateCommentaire = new \DateTime(); // Par défaut, la date et l'heure actuelles

        $commentaire = new Commentaire();
        $entityRecette = $recette->find(4);
        if(!$entityRecette){
            return $this->json(['errors' => ['Recette introuvable']], JsonResponse::HTTP_BAD_REQUEST);
        }
        $commentaire->setRecettes($entityRecette);
        $commentaire->setCommentaires($data['commentaires']??'teddst Commentaire');
        $commentaire->setDateCommentaires($dateCommentaire);

        $errors = $validator->validate($commentaire);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($commentaire);
        $entityManager->flush();
        return $this->json(['message'=>'ajouter'],JsonResponse::HTTP_CREATED);
       }
}
