<?php

namespace Zakjakub\OswisCoreBundle\Interfaces;

interface NameInterface
{
    public function getName(): string;

    public function setName(?string $name): void;
}
