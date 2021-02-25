<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SSH\CommonBundle\Entity\AbstractEntity;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="idx_question", columns={"id"}), @ORM\Index(name="IDX_B6F7494E5582E9C0", columns={"bloc_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="question_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=false)
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=50, nullable=false)
     */
    private $question;

    /**
     * @var string|null
     *
     * @ORM\Column(name="text", type="string", length=5000, nullable=true)
     */
    private $text;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="string", length=5000, nullable=true)
     */
    private $video;

    /**
     * @var int
     *
     * @ORM\Column(name="type_choice", type="string", length=250, nullable=false)
     */
    private $typeChoice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="data_choices", type="string", nullable=true)
     */
    private $dataChoices;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \Bloc
     *
     * @ORM\ManyToOne(targetEntity="Bloc")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bloc_id", referencedColumnName="id")
     * })
     */
    private $bloc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getTypeChoice(): ?string
    {
        return $this->typeChoice;
    }

    public function setTypeChoice(string $typeChoice): self
    {
        $this->typeChoice = $typeChoice;

        return $this;
    }

    public function getDataChoices(): ?string
    {
        return $this->dataChoices;
    }

    public function setDataChoices(?Array $dataChoices): self
    {
        $this->dataChoices = "{ \"".implode(" \",\"",$dataChoices)."\"}" ;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBloc(): ?Bloc
    {
        return $this->bloc;
    }

    public function setBloc(?Bloc $bloc): self
    {
        $this->bloc = $bloc;

        return $this;
    }
    

}
