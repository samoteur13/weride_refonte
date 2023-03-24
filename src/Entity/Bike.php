<?php

namespace App\Entity;

use App\Repository\BikeRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['bike']],
    denormalizationContext: ['groups' => ['write','bike']],
)]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['write','bike','user'])]
    private ?int $id = null;

    #[Groups([ 'write','bike','user'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['write','bike','user'])]
    #[ORM\Column]
    private ?int $power = null;

    #[Groups(['write','bike','user'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_bike = null;

    #[Groups(['write','bike'])]
    #[ORM\ManyToOne(inversedBy: 'bikes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getImgBike(): ?string
    {
        return $this->img_bike;
    }

    public function setImgBike(?string $img_bike): self
    {
        $this->img_bike = $img_bike;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
