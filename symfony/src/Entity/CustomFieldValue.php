<?php

namespace App\Entity;

use App\Repository\CustomFieldValueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Uid\Ulid;

/**
 * @ORM\Entity(repositoryClass=CustomFieldValueRepository::class)
 */
class CustomFieldValue {

  /**
   * @ORM\Id
   * @ORM\Column(type="ulid", unique=true)
   * @ORM\GeneratedValue(strategy="CUSTOM")
   * @ORM\CustomIdGenerator(class=UlidGenerator::class)
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity=CustomField::class)
   * @ORM\JoinColumn(nullable=false)
   */
  private $customField;

  /**
   * @ORM\ManyToOne(targetEntity=Target::class, inversedBy="customFieldValues")
   * @ORM\JoinColumn(nullable=false)
   */
  private $target;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $value;


  public function getId(): ?Ulid {
    return $this->id;
  }

  public function getCustomField(): ?CustomField {
    return $this->customField;
  }

  public function setCustomField(?CustomField $customField): self {
    $this->customField = $customField;

    return $this;
  }

  public function getTarget(): ?Target {
    return $this->target;
  }

  public function setTarget(?Target $target): self {
    $this->target = $target;

    return $this;
  }

  public function getValue(): ?string
  {
      return $this->value;
  }

  public function setValue(string $value): self
  {
      $this->value = $value;

      return $this;
  }

}
