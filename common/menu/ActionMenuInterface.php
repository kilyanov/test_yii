<?php

declare(strict_types=1);

namespace common\menu;

interface ActionMenuInterface
{
    public function setPartUrl(string $partUrl): void;
    public function general(array $cfgUrl = []): array;
}
