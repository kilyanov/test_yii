<?php

declare(strict_types=1);

namespace common\services;

use yii\base\Model;

interface ServiceInterface
{
    public function find(string $id): Model;
    public function search(array $params): array;
    public function create(array $params): bool|string|array;
    public function update(Model $model): bool|string|array;
    public function delete(Model $model): bool|string|array;
    public function deleteAll(array $params): bool|string|array;
    public function load(string $q = '', ?string $id = null): array;
    public function loadSearch(string $q = ''): array;
    public function valueLoad(Model $model): array;

    public function getCfgSearchModel(): array;
    public function setCfgSearchModel(array $cfgParams): void;
    public function getCfgModel(): array;
    public function setCfgModel(array $cfgParams): void;


}
