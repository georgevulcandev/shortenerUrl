<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ClickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *    collectionOperations={},
 *    itemOperations={}
 * )
 *
 * @ORM\Entity(repositoryClass=ClickRepository::class)
 */
class Click
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $clickedAt;

    /**
     * @ORM\ManyToOne(targetEntity=ShortUrl::class, inversedBy="clicks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $short_url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClickedAt(): ?\DateTimeInterface
    {
        return $this->clickedAt;
    }

    public function setClickedAt(\DateTimeInterface $clickedAt): self
    {
        $this->clickedAt = $clickedAt;

        return $this;
    }

    public function getShortUrl(): ?ShortUrl
    {
        return $this->short_url;
    }

    public function setShortUrl(?ShortUrl $short_url): self
    {
        $this->short_url = $short_url;

        return $this;
    }
}
