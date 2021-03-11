<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ShortUrlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Dto\ShortUrlInput;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"output"}},
 *     validationGroups="input",
 *     collectionOperations={
 *         "get",
 *         "post"={
 *             "method"="POST",
 *             "input"=ShortUrlInput::class,
 *             "name"="ShortUrlInput"
 *         },
 *     },
 *     itemOperations={
 *         "get", "delete"
 *     },
 *
 * )
 * @ORM\Entity(repositoryClass=ShortUrlRepository::class)
 */
class ShortUrl
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"output"})
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"output"})
     */
    private ?string $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(groups={"input"})
     *
     * @Groups({"input", "output"})
     */
    private ?string $url;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $generatedAt;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity=Click::class, mappedBy="short_url", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $clicks;

    public function __construct()
    {
        $this->clicks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getGeneratedAt(): ?\DateTimeInterface
    {
        return $this->generatedAt;
    }

    public function setGeneratedAt(\DateTimeInterface $generatedAt): self
    {
        $this->generatedAt = $generatedAt;

        return $this;
    }

    /**
     * @return Collection|Click[]
     */
    public function getClicks(): Collection
    {
        return $this->clicks;
    }

    public function addClick(Click $click): self
    {
        if (!$this->clicks->contains($click)) {
            $this->clicks[] = $click;
            $click->setShortUrl($this);
        }

        return $this;
    }

    public function removeClick(Click $click): self
    {
        if ($this->clicks->removeElement($click)) {
            // set the owning side to null (unless already changed)
            if ($click->getShortUrl() === $this) {
                $click->setShortUrl(null);
            }
        }

        return $this;
    }
}
