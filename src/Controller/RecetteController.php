<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Difficulte;
use App\Entity\Recette;
use App\Entity\TypeRepas;
use App\Repository\CategorieRepository;
use App\Repository\DifficulteRepository;
use App\Repository\RecetteRepository;
use App\Repository\TypeRepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/recette', name: 'recette.')]

class RecetteController extends AbstractController
{
    #[Route('', name: 'index',methods:['GET'])]
    public function index(RecetteRepository $recetteRepository,SerializerInterface $serializerInterface): JsonResponse
    {
        $recettes = $recetteRepository->findAll(); 
        return $this->json(
            $recettes,
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['recette:read']]
        );
    
    }



    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,CategorieRepository $categorie, DifficulteRepository $difficulte,TypeRepasRepository $repas,ValidatorInterface $validator): JsonResponse
    {
        $data = $request->toArray();
        $dateRecettes = new \DateTime(); // Par défaut, la date et l'heure actuelles

        $recette = new Recette();
    
        $recette->setTitreRecettes($data['titreRecettes'] ?? 'Bolognaised');
        $recette->setPreparations($data['preparations'] ?? 'Texte Bolognaise');
        $recette->setNbrLikes($data['nbrLikes'] ?? 0);
        $recette->setStatutRecettes($data['statutRecettes'] ?? true);
    
        // Vérifie si une catégorie a été fournie et récupère l'entité correspondante
          // Gestion des catégories
    $recette->setCategories($categorie->find(2));
    $recette->setDifficultes($difficulte->find(1));
    $recette->setRepas($repas->find(2));

       

        $recette->setDateRecettes($dateRecettes);
     $validator->validate($recette);
     $errors = $validator->validate($difficulte);
     if (count($errors) > 0) {
         $errorMessages = [];
         foreach ($errors as $error) {
             $errorMessages[] = $error->getMessage();
         }
 
         return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
     }
        $entityManager->persist($recette);
        $entityManager->flush();
    
        return $this->json([
            'message' => 'Success',
            'data' => ['titre' => $recette->getTitreRecettes()],
        ], JsonResponse::HTTP_CREATED);
    }
    
    #[Route('/{id}', name: 'edit', methods:['PUT','PATCH'],requirements:['id'=>'\d+'])]

    public function edit(Request $request,EntityManagerInterface $entityManager,Recette $recette,CategorieRepository $categorie,DifficulteRepository $difficulte,TypeRepasRepository $repas, ValidatorInterface $validator):JsonResponse
    {
        $data = $request->toArray();

        $recette->setTitreRecettes($data['titreRecettes'] ?? 'Modifi&');
        $recette->setPreparations($data['preparations'] ?? 'Texte Modi');
        $recette->setNbrLikes($data['nbrLikes'] ?? 1);
        $recette->setStatutRecettes($data['statutRecettes'] ?? false);
    
        // Vérifie si une catégorie a été fournie et récupère l'entité correspondante
          // Gestion des catégories
    $recette->setCategories($categorie->find(2));
    $recette->setDifficultes($difficulte->find(2));
    $recette->setRepas($repas->find(2));

       

     $validator->validate($recette);
     $errors = $validator->validate($difficulte);
     if (count($errors) > 0) {
         $errorMessages = [];
         foreach ($errors as $error) {
             $errorMessages[] = $error->getMessage();
         }
 
         return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
     }
        $entityManager->flush();
        return $this->json(['message'=>'Modifier'],JsonResponse::HTTP_ACCEPTED);
    }



    #[Route('/{id}', name: 'remove',methods:['DELETE'],requirements:['id'=>'\d+'])]
    public function remove(EntityManagerInterface $entityManager, Recette $recette):JsonResponse
    {
        try{
              $entityManager->remove($recette);
        $entityManager->flush();
        return $this->json([
            'message' => 'Le type de repas a été supprimé avec succès.',
            'data' => [
                'id' => $recette->getId(),
                'difficulte' => $recette->getId()
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
