<?php

namespace App\Controller;

use App\Entity\CustomField;
use App\Entity\CustomFieldValue;
use App\Entity\Target;
use App\Form\Type\TargetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TargetController extends AbstractController {

  #[Route('/target/add', name: 'target_add')]
  public function index(Request $request): Response {
    $target = new Target();
    $entityManager = $this->getDoctrine()->getManager();
    $customFields = $entityManager->getRepository(CustomField::class)
      ->findAll();
    $form = $this->createForm(TargetType::class, $target, [
      'customFields' => $customFields,
    ]);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $target = $form->getData();
      $entityManager = $this->getDoctrine()->getManager();

      $entityManager->persist($target);

      foreach ($customFields as $customField) {
        $customFieldValue = new CustomFieldValue();
        $customFieldValue->setCustomField($customField);
        $customFieldValue->setTarget($target);
        $value = $form->get(str_replace(' ', '-', $customField->getName()))
          ->getData();

        if (!empty($value)) {
          $customFieldValue->setValue($value);
          $entityManager->persist($customFieldValue);
        }
      }

      $entityManager->flush();

      return $this->redirectToRoute('target_add');
    }

    return $this->renderForm('target/new.html.twig', [
      'form' => $form,
    ]);
  }

}
