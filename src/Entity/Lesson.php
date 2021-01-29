<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      attributes={"security"="is_granted('ROLE_USER')"},
 *     collectionOperations={"get",
 *
 *      },
 *     itemOperations={"get"={"security"="is_granted('LESSON_VIEW',object)",
 *     },
 *
 *      },
 *     normalizationContext={"groups"={"lesson:read"}},
 *     denormalizationContext={"groups"={"lesson:write"}},
 * )
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 * @Vich\Uploadable
 */
class Lesson
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"courses:read,lesson:read"})
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"users:read","courses:read","lesson:read","lesson:write"})
     *
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $imgUrl;
    /**
     * @Vich\UploadableField(mapping="lessons_img", fileNameProperty="imgUrl")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="lessons")
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $course;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $videoUrl;

    /**
     * @Vich\UploadableField(mapping="lessons_video", fileNameProperty="videoUrl")
     * @var File
     */
    private $videoFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $embedCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $videoPassword;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="lesson", cascade={"persist", "remove"})
     * @Groups({"courses:read","lesson:read","lesson:write"})
     */
    private $attachments;




 public function __construct()
                                            {
                                                $this->createdAt = new \DateTimeImmutable();
                                                $this->attachments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

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

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }
    public function __toString()
    {
      return $this->getTitle();
    }
    public function setVideoFile(File $videoUrl = null)
    {
        $this->videoFile = $videoUrl;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($videoUrl) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }
    public function getVideoFile()
    {
        return $this->videoFile;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEmbedCode(): ?string
    {
        return $this->embedCode;
    }

    public function setEmbedCode(?string $embedCode): self
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    public function getVideoPassword(): ?string
    {
        return $this->videoPassword;
    }

    public function setVideoPassword(string $videoPassword): self
    {
        $this->videoPassword = $videoPassword;

        return $this;
    }

    /**
     * @return Collection|Attachment[]
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setLesson($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->removeElement($attachment);
            // set the owning side to null (unless already changed)
            if ($attachment->getLesson() === $this) {
                $attachment->setLesson(null);
            }
        }

        return $this;
    }





}
