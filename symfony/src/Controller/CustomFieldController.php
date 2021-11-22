<?php

namespace App\Controller;

use App\Entity\CustomField;
use App\Form\Type\CustomFieldType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomFieldController extends AbstractController {

  #[Route('/admin/custom-field/add', name: 'custom_field_add')]
  public function index(Request $request): Response {
    $customField = new CustomField();
    $form = $this->createForm(CustomFieldType::class, $customField);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $customField = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($customField);
      $entityManager->flush();

      return $this->redirectToRoute('custom_field_add');
    }

    return $this->renderForm('custom_field/new.html.twig', [
      'form' => $form,
    ]);
  }

}
