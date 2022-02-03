<?php

namespace App\Entity;

use App\Repository\ShortcutRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ShortcutRepository::class)
 * @UniqueEntity("code", message="Такой код уже есть, попробуй еще раз.")
 * @UniqueEntity("alias", message="Такое сокращение уже занято.")
 */
class Shortcut
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     *    protocols = {"http", "https"}
     * )
     * @ORM\Column(type="string", length=2048)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @Assert\Type("string")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alias;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function increaseViewCount(): void
    {
        $this->viewCount++;
    }
}
