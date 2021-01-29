<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserCourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *      attributes={"security"="is_granted('ROLE_USER')"},
 *     collectionOperations={"get"={"security"="is_granted('ROLE_USER')"},
 *       "post"={"security"="is_granted('ROLE_USER')"}
 *      },
 *     itemOperations={"get",
 *     "put"={"security"="is_granted('ROLE_ADMIN') or object.getUser() == user"},
 *    "delete"={"security"="is_granted('ROLE_ADMIN') or object.getUser() == user"},
 *      },
 *      normalizationContext={"groups"={"usersCourses:read"}},
 *      denormalizationContext={"groups"={"usersCourses:write"}},
 * )
 * @ApiFilter(SearchFilter::class, properties={"user.email": "exact","course.id": "exact"})
 * @ApiFilter(BooleanFilter::class, properties={"isPayed","isPending"})
 * @ORM\Entity(repositoryClass=UserCourseRepository::class)
 */
class UserCourse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"usersCourses:read"})
     */
    private $id;



    /**
     * @ORM\Column(type="boolean")
     * @Groups({"usersCourses:write"})
     */
    private $isAdded;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"usersCourses:write"})
     */
    private $isPayed;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userCourses")
     * @Groups({"usersCourses:write","usersCourses:read", "courses:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="userCourses")
     * @Groups({"usersCourses:write","usersCourses:read", "courses:read"})
     */
    private $course;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPending;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="usersCourses")
     */
    private $orders;



    public function __construct()
    {
        $this->isAdded = false;
        $this->isPayed= false;
        $this->isPending= false;
        $this->orders = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }





    public function getIsAdded(): ?bool
    {
        return $this->isAdded;
    }

    public function setIsAdded(bool $isAdded): self
    {
        $this->isAdded = $isAdded;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getIsPending(): ?bool
    {
        return $this->isPending;
    }

    public function setIsPending(?bool $isPending): self
    {
        $this->isPending = $isPending;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addUsersCourse($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removeUsersCourse($this);
        }

        return $this;
    }

    public function __toString()
    {
       return $this->getCourse()->getTitle();
    }


}
