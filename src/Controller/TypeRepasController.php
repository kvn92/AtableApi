<?php

namespace App\Controller;

use App\Entity\TypeRepas;
use App\Repository\TypeRepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/type', name: 'type.')]

class TypeRepasController extends AbstractController
{
    #[Route('', name: 'index',methods:['GET'])]

    public function index(TypeRepasRepository $typeRepasRepository): JsonResponse
    {
        $type = $typeRepasRepository->findAll();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'data' =>$type],JsonResponse::HTTP_OK
        );
    }

    #[Route('/new', name: 'new',methods:['POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator):JsonResponse
    {

        $data = $request->toArray();

        $type = new TypeRepas(); 

        $type->setTypeRepas($data['typeRepas']??'Dejeuner');
        $type->setStatutTypeRepas($data['statutTypeRepas']??true);

        $errors = $validator->validate($type);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($type);
        $entityManager->flush();
        return $this->json([
            'message' => 'Catégorie ajoutée avec succès.',
            'type' => [
                'id' => $type->getId(),
                'type'=>$type->getTypeRepas(),
                'statut' => $type->isStatutTypeRepas(),
            ]
        ], JsonResponse::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'edit',methods:['PUT','PATCH'],requirements:['id'=>'\d+'])]

    public function edit(Request $request, EntityManagerInterface $entityManager,TypeRepas $type, ValidatorInterface $validator):JsonResponse
    {
        $data = $request->toArray();

        $type->setTypeRepas($data['typeRepas']??'Diner');
        $type->setStatutTypeRepas($data['statutTypeRepas']??false);

        $errors = $validator->validate($type);

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
             'ID'=>$type->getId(),
             'type'=>$type->getTypeRepas(),
             'Statut'=>$type->isStatutTypeRepas(),
        ],JsonResponse::HTTP_ACCEPTED);
        
    }



    #[Route('/{id}', name: 'remove',methods:['DELETE'],requirements:['id'=>'\d+'])]

    public function remove(EntityManagerInterface $entityManager, TypeRepas $type):JsonResponse
    {
        try{
              $entityManager->remove($type);
        $entityManager->flush();
        return $this->json([
            'message' => 'Le type de repas a été supprimé avec succès.',
            'data' => [
                'id' => $type->getId(),
                'typeRepas' => $type->getTypeRepas()
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
