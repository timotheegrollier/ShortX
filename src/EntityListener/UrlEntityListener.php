<?php

namespace App\EntityListener;

use App\Utils\Str;
use App\Entity\Url;
use App\Repository\UrlRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UrlEntityListener
{
    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function prePersist(Url $url, LifecycleEventArgs $event)
    {
        if (!$url->getShortened()) {
            $url->setShortened($this->getUniqueShortenedString());
        }
    }

    private function getUniqueShortenedString(): string
    {
        $shortened = Str::random(6);

        if ($this->urlRepository->findOneBy(['shortened' => $shortened])) {
            return $this->getUniqueShortenedString();
        }

        return $shortened;
    }
}
