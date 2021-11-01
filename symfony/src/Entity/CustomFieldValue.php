<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomFieldValueRepository::class)
 */
class CustomFieldValue {

  /**
   * @ORM\Id
   * @ORM\Column(type="uuid")
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

  public function __construct() {
    $this->id = Uuid::v4();
  }


  public function getId(): ?Uuid {
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

}
