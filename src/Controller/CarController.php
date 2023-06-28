<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarCategory;
use App\Form\CarType;
use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/car')]
class CarController extends AbstractController
{
    #[Route('/', name: 'app_car_index', methods: ['GET'])]
    public function index(Request $request, CarRepository $carRepository): Response
    {
        if($request->query->has('search') && $request->query->get('search')){
            $search = $request->query->get('search');
            $sortOrder = 'ASC';
            if($request->query->has('sortByCarCategory') && $request->query->get('sortByCarCategory')){
                $sortOrder = $request->query->get('sortByCarCategory');
            }
            $cars = $carRepository->findByName($request, $search, $sortOrder);
        }else{
            $sortOrder = 'ASC';
            if($request->query->has('sortByCarCategory') && $request->query->get('sortByCarCategory')){
                $sortOrder = $request->query->get('sortByCarCategory');
            }
            $cars = $carRepository->getAll($request, $sortOrder);
            $search = '';
        }
        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'search' => $search,
            'sortOrder' => $sortOrder,
        ]);
    }

    #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarRepository $carRepository, CarCategoryRepository $carCategoryRepository): Response
    {
        $car = new Car();
        $categories = $carCategoryRepository->findAll();
        $choices = array_map(function (CarCategory $carCategory){
            return ['label' => $carCategory->getName(), 'value' => $carCategory->getId()];
        }, $categories);

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/new.html.twig', [
            'car' => $car,
            'form' => $form,
            'choices' => $choices,
        ]);
    }

    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, CarRepository $carRepository): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car, true);
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
