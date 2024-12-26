<?php

namespace App\Controller;

use App\Entity\Test;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/test', name: 'test.')]

class TestController extends AbstractController
{
    #[Route('', name: 'index',methods:['GET'])]
    public function index(TestRepository $testRepository): JsonResponse
    {

        $test = $testRepository->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
            'test'=>$test
        ]);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Décoder le contenu JSON directement
        $data = json_decode($request->getContent(), true);
    
        // Créer l'entité et définir les propriétés
        $test = new Test();
        $test->setNom($data['nom'] ?? 'kevin'); // Utiliser une valeur par défaut si 'nom' est absent
    
        // Sauvegarder l'entité
        $entityManager->persist($test);
        $entityManager->flush();
    
        // Retourner une réponse simple
        return new JsonResponse([
            'message' => 'Création réussie',
            'id' => $test->getId()
        ], 201);
    }
    
    
}
