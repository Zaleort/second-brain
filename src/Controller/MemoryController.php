<?php
declare(strict_types=1);
namespace App\Controller;

use App\Categories\Infrastructure\CategoryRepository;
use App\Entity\Memory;
use App\Repository\MemoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MemoryController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ManagerRegistry     $managerRegistry,
        private readonly MemoryRepository    $memoryRepository,
        private readonly CategoryRepository  $categoryRepository,
    ) {}

    #[Route('/memories', methods: ['GET'])]
    public function getMemory(): Response
    {
        $memories = $this->memoryRepository->findAll();
        return JsonResponse::fromJsonString($this->serializer->serialize(
            $memories,
            'json',
            ['groups' => ['category', 'memory']]
        ));
    }

    #[Route('/memories/{id}', methods: ['GET'])]
    public function getMemories(int $id): Response
    {
        $memory = $this->memoryRepository->find($id);
        if (!$memory)
        {
            throw $this->createNotFoundException('Memory not found with id '.$id);
        }

        return JsonResponse::fromJsonString($this->serializer->serialize(
            $memory,
            'json',
            ['groups' => ['category', 'memory']]
        ));
    }

    /**
     * @throws \Exception
     */
    #[Route('/memories', methods: ['POST'])]
    public  function  createMemory(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $memory = new Memory();
        $memory->setContent($data['content']);
        $memory->setName($data['name']);
        $memory->setType($data['type']);
        $memory->setCreatedAt(new \DateTimeImmutable());

        foreach ($data['categories'] as $categoryId) {
            $category = $this->categoryRepository->find($categoryId);
            if ($category != null) $memory->addCategory($category);
        }

        $manager = $this->managerRegistry->getManager();
        $manager->persist($memory);
        $manager->flush();
        return new Response('', Response::HTTP_CREATED);
    }

    #[Route('/memories/{id}', methods: ['PUT', 'PATCH'])]
    public function updateMemory(
        Request $request,
        int $id,
    ): Response
    {
        $entityManager = $this->managerRegistry->getManager();
        $memory = $entityManager->getRepository(Memory::class)->find($id);

        if (!$memory) {
            throw $this->createNotFoundException('Memory not found for id '.$id);
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $memory->setContent($data['content']);
        $memory->setName($data['name']);
        $memory->setType($data['type']);
        $memory->setModifiedAt(new \DateTimeImmutable());

        foreach ($data['categories'] as $categoryId) {
            $category = $this->categoryRepository->find($categoryId);
            if ($category != null) $memory->addCategory($category);
        }

        $entityManager->flush();
        return new Response('', Response::HTTP_OK);
    }

    #[Route('memories/{id}', methods: ['DELETE'])]
    public function deleteMemory(int $id): Response
    {
        $entityManager = $this->managerRegistry->getManager();
        $memory = $entityManager->getRepository(Memory::class)->find($id);

        if (!$memory) {
            throw $this->createNotFoundException('Memory not found for id '.$id);
        }

        $entityManager->remove($memory);
        $entityManager->flush();

        return new Response('', Response::HTTP_OK);
    }
}
