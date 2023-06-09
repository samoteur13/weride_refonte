<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: TripRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['trip']],
    denormalizationContext: ['groups' => ['write']],
)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['write','trip','user'])]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Groups(['write','trip','user'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd-m-Y'],[DateTimeNormalizer::TIMEZONE_KEY => 'h'])]
    #[Groups(['write','trip','user'])]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd-m-Y'],[DateTimeNormalizer::TIMEZONE_KEY => 'h'])]
    #[Groups(['write','trip','user'])]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['write','trip','user'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['write','trip','user'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[Groups(['write','trip'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'trip', targetEntity: TripSteps::class)]
    private Collection $tripSteps;

    #[Groups(['write','trip'])]
    #[ORM\OneToMany(mappedBy: 'trip', targetEntity: Post::class)]
    private Collection $posts;

    #[Groups(['write','trip'])]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rider_trips')]
    private Collection $rider_join;

    public function __construct()
    {
        $this->tripSteps = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->rider_join = new ArrayCollection();
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
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setTrip($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getTrip() === $this) {
                $post->setTrip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRiderJoin(): Collection
    {
        return $this->rider_join;
    }

    public function addRiderJoin(User $riderJoin): self
    {
        if (!$this->rider_join->contains($riderJoin)) {
            $this->rider_join->add($riderJoin);
        }

        return $this;
    }

    public function removeRiderJoin(User $riderJoin): self
    {
        $this->rider_join->removeElement($riderJoin);

        return $this;
    }

}
