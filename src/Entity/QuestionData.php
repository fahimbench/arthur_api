<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(normalizationContext={"groups"={"question"}})
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "question": "partial", "answers": "partial", "resultText": "partial", "questionTheme": "exact", "questionLadders": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\QuestionDataRepository")
 */
class QuestionData
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
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("question")
     */
    private $answers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("question")
     */
    private $resultText;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionTheme", inversedBy="questionData")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Groups("question")
     */
    private $questionTheme;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionLadder", mappedBy="questionData", orphanRemoval=true)
     */
    private $questionLadders;

    public function __construct()
    {
        $this->questionLadders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswers(): ?string
    {
        return $this->answers;
    }

    public function setAnswers(string $answers): self
    {
        $this->answers = $answers;

        return $this;
    }

    public function getResultText(): ?string
    {
        return $this->resultText;
    }

    public function setResultText(?string $resultText): self
    {
        $this->resultText = $resultText;

        return $this;
    }

    public function getQuestionTheme(): ?QuestionTheme
    {
        return $this->questionTheme;
    }

    public function setQuestionTheme(?QuestionTheme $questionTheme): self
    {
        $this->questionTheme = $questionTheme;

        return $this;
    }

    /**
     * @return Collection|QuestionLadder[]
     */
    public function getQuestionLadders(): Collection
    {
        return $this->questionLadders;
    }

    public function addQuestionLadder(QuestionLadder $questionLadder): self
    {
        if (!$this->questionLadders->contains($questionLadder)) {
            $this->questionLadders[] = $questionLadder;
            $questionLadder->setQuestionData($this);
        }

        return $this;
    }

    public function removeQuestionLadder(QuestionLadder $questionLadder): self
    {
        if ($this->questionLadders->contains($questionLadder)) {
            $this->questionLadders->removeElement($questionLadder);
            // set the owning side to null (unless already changed)
            if ($questionLadder->getQuestionData() === $this) {
                $questionLadder->setQuestionData(null);
            }
        }

        return $this;
    }

}
