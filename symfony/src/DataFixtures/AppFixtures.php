<?php

namespace App\DataFixtures;

use App\Entity\CustomField;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

  private UserPasswordHasherInterface $encoder;

  public function __construct(UserPasswordHasherInterface $encoder) {
    $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager): void {
    $user = new User();
    $user->setUsername('admin');

    $user->setRoles(['ROLE_ADMIN']);
    $password = $this->encoder->hashPassword($user, 'Passw0rd');
    $user->setPassword($password);

    $manager->persist($user);

    $customFields = [
      'Client name',
      'Client id',
    ];

    foreach ($customFields as $customField) {
      $field = new CustomField();
      $field->setName($customField);
      $manager->persist($field);
    }

    $manager->flush();
  }

}
