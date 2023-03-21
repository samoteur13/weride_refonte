<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'trip', targetEntity: TripSteps::class)]
    private Collection $tripSteps;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rider')]
    private Collection $rider;

    // #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'post')]
    // private Collection $post;

    public function __construct()
    {
        $this->tripSteps = new ArrayCollection();
        $this->rider = new ArrayCollection();
        // $this->post = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, TripSteps>
     */
    public function getTripSteps(): Collection
    {
        return $this->tripSteps;
    }

    public function addTripStep(TripSteps $tripStep): self
    {
        if (!$this->tripSteps->contains($tripStep)) {
            $this->tripSteps->add($tripStep);
            $tripStep->setTrip($this);
        }

        return $this;
    }

    public function removeTripStep(TripSteps $tripStep): self
    {
        if ($this->tripSteps->removeElement($tripStep)) {
            // set the owning side to null (unless already changed)
            if ($tripStep->getTrip() === $this) {
                $tripStep->setTrip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRider(): Collection
    {
        return $this->rider;
    }

    public function addRider(User $rider): self
    {
        if (!$this->rider->contains($rider)) {
            $this->rider->add($rider);
        }

        return $this;
    }

    public function removeRider(User $rider): self
    {
        $this->rider->removeElement($rider);

        return $this;
    }

    // /**
    //  * @return Collection<int, User>
    //  */
    // public function getPost(): Collection
    // {
    //     return $this->post;
    // }

    // public function addPost(User $post): self
    // {
    //     if (!$this->post->contains($post)) {
    //         $this->post->add($post);
    //     }

    //     return $this;
    // }

    // public function removePost(User $post): self
    // {
    //     $this->post->removeElement($post);

    //     return $this;
    // }
}
