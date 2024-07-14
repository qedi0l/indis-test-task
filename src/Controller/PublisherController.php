<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Service\PublisherService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PublisherController extends AbstractController
{
    #[Route('/publisher/create',name:"publisher_create", methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request, PublisherService $publisherService): JsonResponse
    {
        $response = $publisherService->createPublisher($entityManager,$request);
        return $this->json($response);
    }
    
    #[Route('/publisher/update',name:"publisher_update", methods: ['POST'])]
    public function update(EntityManagerInterface $entityManager, Request $request, PublisherService $publisherService): JsonResponse
    {
        $response = $publisherService->updatePublisher($entityManager,$request);
        return $this->json($response);
    }

    #[Route('/publisher/delete',name:"publisher_delete", methods: ['POST'])]
    public function delete(EntityManagerInterface $entityManager,Request $request, PublisherService $publisherService): JsonResponse
    {
        $response = $publisherService->deletePublisher($entityManager,$request);
        return $this->json($response);
    }
}
