<?php

namespace App\Entity;

use App\Repository\VacancyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacancyRepository::class)
 */
class Vacancy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vacancies")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="vacancies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organization_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $moderation_status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $refuse_reason;

    /**
     * @ORM\ManyToOne(targetEntity=Position::class, inversedBy="vacancies")
     */
    private $position_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $work_place;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentForm::class, inversedBy="vacancies")
     */
    private $payment_form;

    /**
     * @ORM\ManyToOne(targetEntity=EmploymentType::class, inversedBy="vacancies")
     */
    private $employment_type;

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
    private $job_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $learning_opportunity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $info;

    /**
     * @ORM\OneToMany(targetEntity=Responses::class, mappedBy="vacancy_id", orphanRemoval=true)
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

    public function getOrganizationId(): ?Organization
    {
        return $this->organization_id;
    }

    public function setOrganizationId(?Organization $organization_id): self
    {
        $this->organization_id = $organization_id;

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

    public function getWorkPlace(): ?string
    {
        return $this->work_place;
    }

    public function setWorkPlace(?string $work_place): self
    {
        $this->work_place = $work_place;

        return $this;
    }

    public function getPaymentForm(): ?PaymentForm
    {
        return $this->payment_form;
    }

    public function setPaymentForm(?PaymentForm $payment_form): self
    {
        $this->payment_form = $payment_form;

        return $this;
    }

    public function getEmploymentType(): ?EmploymentType
    {
        return $this->employment_type;
    }

    public function setEmploymentType(?EmploymentType $employment_type): self
    {
        $this->employment_type = $employment_type;

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

    public function getJobDescription(): ?string
    {
        return $this->job_description;
    }

    public function setJobDescription(?string $job_description): self
    {
        $this->job_description = $job_description;

        return $this;
    }

    public function getLearningOpportunity()
    {
        return $this->learning_opportunity;
    }

    public function setLearningOpportunity($learning_opportunity): self
    {
        $this->learning_opportunity = $learning_opportunity;

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
            $response->setVacancyId($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getVacancyId() === $this) {
                $response->setVacancyId(null);
            }
        }

        return $this;
    }

}
