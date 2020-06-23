<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResumeRepository::class)
 */
class Resume
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="resumes")
     */
    private $user_id;

    /**
     * @ORM\Column(type="binary", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="binary", nullable=true)
     */
    private $moderation_status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $refuse_reason;

    /**
     * @ORM\ManyToOne(targetEntity=Position::class, inversedBy="resumes")
     */
    private $position_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $work_experience;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $education;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salary;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $personal_quality;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $info;

    /**
     * @ORM\OneToMany(targetEntity=Responses::class, mappedBy="resume_id", orphanRemoval=true)
     */
    private $responses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getModerationStatus()
    {
        return $this->moderation_status;
    }

    public function setModerationStatus($moderation_status): self
    {
        $this->moderation_status = $moderation_status;

        return $this;
    }

    public function getRefuseReason(): ?string
    {
        return $this->refuse_reason;
    }

    public function setRefuseReason(?string $refuse_reason): self
    {
        $this->refuse_reason = $refuse_reason;

        return $this;
    }

    public function getPositionId(): ?Position
    {
        return $this->position_id;
    }

    public function setPositionId(?Position $position_id): self
    {
        $this->position_id = $position_id;

        return $this;
    }

    public function getWorkExperience(): ?string
    {
        return $this->work_experience;
    }

    public function setWorkExperience(?string $work_experience): self
    {
        $this->work_experience = $work_experience;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(?int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPersonalQuality(): ?string
    {
        return $this->personal_quality;
    }

    public function setPersonalQuality(string $personal_quality): self
    {
        $this->personal_quality = $personal_quality;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return Collection|Responses[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Responses $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setResumeId($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getResumeId() === $this) {
                $response->setResumeId(null);
            }
        }

        return $this;
    }
}
