<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ShortUrlInput
{
    /**
     * @Assert\NotBlank(groups={"input"})
     * @Assert\Url(groups={"input"})
     *
     * @Groups({"input"})
     *
     * @var string
     */
    public string $url;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
