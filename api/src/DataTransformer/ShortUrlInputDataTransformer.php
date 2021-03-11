<?php
declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\ShortUrl;
use Ramsey\Uuid\Uuid;
use PascalDeVink\ShortUuid\ShortUuid;

final class ShortUrlInputDataTransformer implements DataTransformerInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        $this->validator->validate($object, $context);

        $shortUrl = new ShortUrl();
        $shortUrl->setCode((new ShortUuid())->encode(Uuid::uuid4()));
        $shortUrl->setUrl($object->getUrl());
        $shortUrl->setGeneratedAt(new \DateTime());

        return $shortUrl;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof ShortUrl) {
            return false;
        }

        return ShortUrl::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
