<?php

declare(strict_types=1);

namespace common\menu;

class BaseActionMenu implements ActionMenuInterface
{
    public array $items = [];

    public function __construct()
    {
        $this->items = [
            new UpdateItem(),
            new DeleteItem(),
        ];
    }

    public function setPartUrl(string $partUrl): void
    {
        foreach ($this->items as $item) {
            /**  @var BaseItem $item */
            $item->setPartUrl($partUrl);
        }
    }

    public function general(array $cfgUrl = []): array
    {
        $result = [];
        foreach ($this->items as $item) {
            /** @var BaseItem $item */
            $result[] = $item->general($cfgUrl);
        }

        return $result;
    }
}
