<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "name": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\QuestionThemeRepository")
 */
class QuestionTheme
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("question")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("question")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionData", mappedBy="questionTheme", orphanRemoval=true)
     */
    private $questionData;

    public function __construct()
    {
        $this->questionData = new ArrayCollection();
    }

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

    /**
     * @return Collection|QuestionData[]
     */
    public function getQuestionData(): Collection
    {
        return $this->questionData;
    }

    public function addQuestionData(QuestionData $questionData): self
    {
        if (!$this->questionData->contains($questionData)) {
            $this->questionData[] = $questionData;
            $questionData->setQuestionTheme($this);
        }

        return $this;
    }

    public function removeQuestionData(QuestionData $questionData): self
    {
        if ($this->questionData->contains($questionData)) {
            $this->questionData->removeElement($questionData);
            // set the owning side to null (unless already changed)
            if ($questionData->getQuestionTheme() === $this) {
                $questionData->setQuestionTheme(null);
            }
        }

        return $this;
    }
}
