<?php

namespace App\Controller;

use App\Entity\Click;
use App\Repository\ClickRepository;
use App\Repository\ShortUrlRepository;
use EasyRdf\Literal\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    /**
     * @var ShortUrlRepository
     */
    private ShortUrlRepository $shortUrlRepository;

    public function __construct(ShortUrlRepository $shortUrlRepository)
    {
        $this->shortUrlRepository = $shortUrlRepository;
    }

    #[Route('/redirect/{code}', name: 'redirect')]
    public function index($code): Response
    {
        //get url from db
        $shortUrl = $this->shortUrlRepository->findOneByShortcode($code);
        if (null === $shortUrl) {
            return new Response("Invalid url");
        }

        //update clicks
        $click = new Click();
        $click->setClickedAt(new \DateTime());

        $shortUrl->addClick($click);

        $this->shortUrlRepository->save($shortUrl);

        //redirect
        return $this->redirect($shortUrl->getUrl());
    }
}
