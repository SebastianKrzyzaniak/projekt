<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Restaurant", inversedBy="comments")
     */
    private $restaurant_id;

    public function __construct()
    {
        $this->restaurant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurantId(): Collection
    {
        return $this->restaurant_id;
    }

    public function addRestaurantId(Restaurant $restaurantId): self
    {
        if (!$this->restaurant_id->contains($restaurantId)) {
            $this->restaurant_id[] = $restaurantId;
        }

        return $this;
    }

    public function removeRestaurantId(Restaurant $restaurantId): self
    {
        if ($this->restaurant_id->contains($restaurantId)) {
            $this->restaurant_id->removeElement($restaurantId);
        }

        return $this;
    }
}
