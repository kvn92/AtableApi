<?php

namespace App\Controller;

use App\Entity\Difficulte;
use App\Repository\DifficulteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/difficulte', name: 'difficulte.')]

class DifficulteController extends AbstractController
{
    #[Route('', name: 'index',methods:['GET'])]
    public function index(DifficulteRepository $difficulteRepository): JsonResponse
    {
        $difficultes = $difficulteRepository->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'difficultes' => $difficultes,
        ]);
    }

    #[Route('/new', name: 'new',methods:['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator):JsonResponse
    {
        $data = $request->toArray();
        $difficulte = new Difficulte();

        $difficulte->setDifficultes($data['difficultes']??'normal');
        $difficulte->setStatutDifficultes($data['statutDifficultes']??true);

        $errors = $validator->validate($difficulte);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($difficulte);
        $entityManager->flush();


        return $this->json([
            'message' => 'Succes',
            'data' => [
                'id'=>$difficulte->getDifficultes(),
                'statut'=>$difficulte->isStatutDifficultes(),
            ],JsonResponse::HTTP_CREATED
        ]);
    }

    #[Route('/{id}', name: 'edit',methods:['PUT','PATCH'],requirements:['id'=>'\d+'])]
    public function edit(Request $request, EntityManagerInterface $entityManager,Difficulte $difficulte, ValidatorInterface $validator):JsonResponse
    {
        $data = $request->toArray();

        $difficulte->setDifficultes($data['difficultes']??'facile');
        $difficulte->setStatutDifficultes($data['statutDifficultes']??false);

        $errors = $validator->validate($difficulte);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();
        return $this->json(
            ['message'=>'Succes',
             'ID'=>$difficulte->getId(),
             'type'=>$difficulte->getDifficultes(),
             'Statut'=>$difficulte->isStatutDifficultes(),
        ],JsonResponse::HTTP_ACCEPTED);
        
    }



    #[Route('/{id}', name: 'remove',methods:['DELETE'],requirements:['id'=>'\d+'])]

    public function remove(EntityManagerInterface $entityManager, Difficulte $difficulte):JsonResponse
    {
        try{
              $entityManager->remove($difficulte);
        $entityManager->flush();
        return $this->json([
            'message' => 'Le type de repas a été supprimé avec succès.',
            'data' => [
                'id' => $difficulte->getId(),
                'difficulte' => $difficulte->getDifficultes()
            ]
        ], JsonResponse::HTTP_OK);
        }catch (\Exception $e) {
            return $this->json([
                'error' => 'Une erreur s\'est produite lors de la suppression.',
                'details' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
      

    }
}
}
