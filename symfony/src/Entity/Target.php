<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=TargetRepository::class)
 */
class Target {

  /**
   * @ORM\Id
   * @ORM\Column(type="uuid")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $url;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $targetGroup;

  /**
   * @ORM\OneToMany(targetEntity=CustomFieldValue::class, mappedBy="target", orphanRemoval=true)
   */
  private $customFieldValues;

  public function __construct() {
    $this->id = Uuid::v4();
    $this->customFieldValues = new ArrayCollection();
  }

  public function getId(): ?Uuid {
    return $this->id;
  }

  public function getUrl(): ?string {
    return $this->url;
  }

  public function setUrl(string $url): self {
    $this->url = $url;

    return $this;
  }

  public function getTargetGroup(): ?string {
    return $this->targetGroup;
  }

  public function setTargetGroup(string $targetGroup): self {
    $this->targetGroup = $targetGroup;

    return $this;
  }

  /**
   * @return Collection|CustomFieldValue[]
   */
  public function getCustomFieldValues(): Collection
  {
      return $this->customFieldValues;
  }

  public function addCustomFieldValue(CustomFieldValue $customFieldValue): self
  {
      if (!$this->customFieldValues->contains($customFieldValue)) {
          $this->customFieldValues[] = $customFieldValue;
          $customFieldValue->setTarget($this);
      }

      return $this;
  }

  public function removeCustomFieldValue(CustomFieldValue $customFieldValue): self
  {
      if ($this->customFieldValues->removeElement($customFieldValue)) {
          // set the owning side to null (unless already changed)
          if ($customFieldValue->getTarget() === $this) {
              $customFieldValue->setTarget(null);
          }
      }

      return $this;
  }

}
