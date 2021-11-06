<?php

namespace App\Form\Type;

use App\Entity\Target;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TargetType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('url', UrlType::class)
      ->add('targetGroup', TextType::class);

    /** @var \App\Entity\CustomField $customField */
    foreach ($options['customFields'] as $customField) {
      $builder->add(str_replace(' ', '-', $customField->getName()), TextType::class, [
        'mapped' => FALSE,
      ]);
    }

    $builder->add("submit", SubmitType::class);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Target::class,
      'customFields' => NULL,
      'allow_extra_fields' => TRUE,
    ]);
  }

}