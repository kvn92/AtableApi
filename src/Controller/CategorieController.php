<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/categorie', name: 'categorie')]

class CategorieController extends AbstractController
{

    #[Route('', name: 'index')]
    public function index(CategorieRepository $categorieRepository): JsonResponse
    {
        $categories = $categorieRepository->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CategorieController.php',
            'id'=>$categories
        ]);
    }


    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->toArray();
    
        // Valider la présence des données nécessaires

    
        // Créer une nouvelle instance de Categorie
        $categorie = new Categorie();
        $categorie->setCategories($data['categories']??'Fali');
        $categorie->setStatutCaterogies($data['statutCategories'] ?? true);
    
        // Valider l'entité avec le validateur Symfony
        $errors = $validator->validate($categorie);
    
        // Vérifier s'il y a des erreurs de validation
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Persister l'entité dans la base de données
        $entityManager->persist($categorie);
        $entityManager->flush();
    
        // Retourner une réponse JSON de succès
        return $this->json([
            'message' => 'Catégorie ajoutée avec succès.',
            'categorie' => [
                'id' => $categorie->getId(),
                'categories' => $categorie->getCategories(),
            ]
        ], JsonResponse::HTTP_CREATED);
    }
    

    

    #[Route('/{id}', name: 'edit', methods: ['PUT', 'PATCH'], requirements: ['id' => '\d+'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        Categorie $categorie,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = $request->toArray();
    
        // Mettre à jour les propriétés si elles sont présentes
            $categorie->setCategories($data['categories']??'kevib');
        
    
            $categorie->setStatutCaterogies($data['statutCategories']??false);
    
        // Valider l'entité avec le validateur Symfony
        $error = $validator->validate($categorie);
    
        // Vérifier s'il y a des erreurs de validation
        if (count($error) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

    
        // Sauvegarder les modifications
        $entityManager->flush();
    
        // Retourner une réponse de succès avec les données mises à jour
        return $this->json([
            'message' => 'Catégorie modifiée avec succès.',
            'data' => [
                'id' => $categorie->getId(),
                'categories' => $categorie->getCategories(),
                'statutCategories' => $categorie->isStatutCaterogies(),
            ]
        ], JsonResponse::HTTP_ACCEPTED);
    }
    

    #[Route('/{id}',name:'remove',methods:['DELETE'],requirements:['id'=>'\d+'])]

    public function remove(Categorie $categorie, EntityManagerInterface $entityManager):JsonResponse
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->json(['message'=>'effaceer'],JsonResponse::HTTP_OK);
    }

}
