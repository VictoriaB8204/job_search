<?php

namespace App\Entity;

use App\Repository\ResponsesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponsesRepository::class)
 */
class Responses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="responses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resume_id;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="responses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vacancy_id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $worker_date;

    /**
     * @ORM\Column(type="binary", nullable=true)
     */
    private $worker_status;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $employer_date;

    /**
     * @ORM\Column(type="binary", nullable=true)
     */
    private $employer_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResumeId(): ?Resume
    {
        return $this->resume_id;
    }

    public function setResumeId(?Resume $resume_id): self
    {
        $this->resume_id = $resume_id;

        return $this;
    }

    public function getVacancyId(): ?Vacancy
    {
        return $this->vacancy_id;
    }

    public function setVacancyId(?Vacancy $vacancy_id): self
    {
        $this->vacancy_id = $vacancy_id;

        return $this;
    }

    public function getWorkerDate(): ?\DateTimeInterface
    {
        return $this->worker_date;
    }

    public function setWorkerDate(?\DateTimeInterface $worker_date): self
    {
        $this->worker_date = $worker_date;

        return $this;
    }

    public function getWorkerStatus()
    {
        return $this->worker_status;
    }

    public function setWorkerStatus($worker_status): self
    {
        $this->worker_status = $worker_status;

        return $this;
    }

    public function getEmployerDate(): ?\DateTimeInterface
    {
        return $this->employer_date;
    }

    public function setEmployerDate(?\DateTimeInterface $employer_date): self
    {
        $this->employer_date = $employer_date;

        return $this;
    }

    public function getEmployerStatus()
    {
        return $this->employer_status;
    }

    public function setEmployerStatus($employer_status): self
    {
        $this->employer_status = $employer_status;

        return $this;
    }
}
