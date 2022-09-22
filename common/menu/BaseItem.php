<?php

declare(strict_types=1);

namespace common\menu;

use yii\helpers\ArrayHelper;

class BaseItem
{
    private array $url;

    protected string $action;

    public string $label;
    public array $linkOptions;
    public bool $visible = true;

    public function general(array $cfgUrl = []): array
    {
        $params = [];
        foreach ($cfgUrl as $key => $cfg) {
            if (is_string($key)) {
                $params = ArrayHelper::merge($params, [$key => $cfg]);
            }
            else {
                $this->url[0] .= '/' . $cfg;
            }
        }
        if (!empty($params)) {
            $this->url = ArrayHelper::merge($this->url, $params);
        }

            return [
                'label' => $this->label,
                'url' => $this->url,
                'linkOptions' => $this->linkOptions
            ];
    }

    public function setPartUrl(string $partUrl): void
    {
        $this->url = [$partUrl . '/' . $this->action];
    }
}
