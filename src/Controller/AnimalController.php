<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Country;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/animal')]
class AnimalController extends AbstractController
{
    #[Route('/', name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();

        return $this->json($animals);
    }

    #[Route('/new', name: 'app_animal_new', methods: ['POST'])]
    public function new(Request $request, AnimalRepository $animalRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->submit($data);
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $animalRepository->save($animal, true);
    
                return $this->json($animal);
            } else {
                $errors = [];
                foreach ($form as $fieldName => $formField) {
                    foreach ($formField->getErrors(true) as $error) {
                        $errors[$fieldName] = $error->getMessage();
                    }
                }
                return $this->json(['message' => 'Invalid data', 'errors' => $errors], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->json(['message' => 'Form not submitted', 'data' => $data], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        return $this->json($animal);
    }

    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['PUT'])]
    public function edit(Request $request, Animal $animal, AnimalRepository $animalRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(AnimalType::class, $animal);
        $form->submit($data);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager->persist($animal);
                $entityManager->flush();

                return $this->json($animal);
            } else {
                $errors = [];
                foreach ($form as $fieldName => $formField) {
                    foreach ($formField->getErrors(true) as $error) {
                        $errors[$fieldName] = $error->getMessage();
                    }
                }
                return $this->json(['message' => 'Invalid data', 'errors' => $errors, 'data' => $data, 'form' => $form], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->json(['message' => 'Form not submitted', 'data' => $data], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}', name: 'app_animal_delete', methods: ['DELETE'])]
    public function delete(Animal $animal, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($animal);
        $entityManager->flush();

        return $this->json(['message' => 'Animal deleted']);
    }

    #[Route('/country/{id}', name: 'app_animal_by_country', methods: ['GET'])]
    public function getByCountry(int $id, AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findBy(['country' => $id]);

        return $this->json($animals);
    }

    #[Route('/{id}/country/{countryId}', name: 'app_animal_update_country', methods: ['PUT'])]
    public function updateCountry(int $id, int $countryId, AnimalRepository $animalRepository, CountryRepository $countryRepository): Response
    {
        $animal = $animalRepository->find($id);
        $country = $countryRepository->find($countryId);
        
        if (!$animal || !$country) {
            return $this->json(['message' => 'Animal or Country not found'], Response::HTTP_NOT_FOUND);
        }

        $animal->setCountry($country);
        $animalRepository->save($animal, true);

        return $this->json($animal);
    }

    public static function circularReferenceHandler($object)
    {
        return $object->getId();
    }
}