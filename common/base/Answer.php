<?php

declare(strict_types=1);

namespace common\base;

use Yii;
use yii\base\BaseObject;
use yii\helpers\Html;

class Answer extends BaseObject
{
    public const DEFAULT_FORCE_RELOAD = '#crud-datatable-pjax';

    public \yii\base\Model $model;
    public string $forceReload = self::DEFAULT_FORCE_RELOAD;
    public string $title = '';
    public string $content = '';
    public string $footer = '';
    public string $tmp = '';
    public array $buttonCloseOptions = [
            'class' => 'btn btn-default pull-left',
            'data-dismiss' => 'modal'
    ];
    public array $buttonSaveOptions = [
        'class' => 'btn btn-info',
        'type' => 'submit'
    ];
    public array $buttonCreateOptions = [
        'class' => 'btn btn-success',
        'role' => 'modal-remote'
    ];
    public array $postOptions = ['class' => 'text-success'];
    public array $postUpdateOptions = ['class' => 'text-success'];
    public array $errorActionOptions = ['class' => 'text-success'];
    public array $contentActionOptions = ['class' => 'text-success'];
    public string $postMsg = 'Данные успешно сохранены.';
    public string $postUpdateMsg = 'Данные успешно сохранены.';

    public function setPostOptions(array $options): self
    {
        $this->postOptions = $options;
        return $this;
    }
    
    public function setPostUpdateOptions(array $options): self
    {
        $this->postUpdateOptions = $options;
        return $this;
    }
    
    public function setErrorActionOptions(array $options): self
    {
        $this->errorActionOptions = $options;
        return $this;
    }
    
    public function setContentActionOptions(array $options): self
    {
        $this->contentActionOptions = $options;
        return $this;
    }
    
    public function setButtonCloseOptions(array $options): self
    {
        $this->buttonCloseOptions = $options;
        return $this;
    }
    
    public function setButtonSaveOptions(array $options): self
    {
        $this->buttonSaveOptions = $options;
        return $this;
    }
    
    public function setButtonCreateOptions(array $options): self
    {
        $this->buttonCreateOptions = $options;
        return $this;
    }
    
    public function setPostMsg(string $msg): self
    {
        $this->postMsg = $msg;
        return $this;
    }
    
    public function setPostUpdateMsg(string $msg): self
    {
        $this->postUpdateMsg = $msg;
        return $this;
    }
    
    public function getButtonClose(): string
    {
        return Html::button('Закрыть', $this->buttonCloseOptions);
    }
    
    public function getButtonSave(): string
    {
        return Html::button('Сохранить', $this->buttonSaveOptions);
    }
    
    public function getButtonCreate(array $url): string
    {
        return Html::a('Создать ещё', $url, $this->buttonCreateOptions);
    }
    
    public function isGet(): array
    {
        return [
            'title' => $this->title,
            'content' => Yii::$app->controller->renderAjax(
                $this->tmp, ['model' => $this->model,]
            ),
            'footer' => $this->getButtonClose() . $this->getButtonSave()
        ];
    }
    
    public function isPost(array $urlCreate, array $options = []): array
    {
        return [
            'forceReload' => $this->forceReload,
            'title' => $this->title,
            'content' => Html::tag(
                'span',
                $this->postMsg,
                $this->postOptions
            ),
            'footer' => $this->getButtonClose() . $this->getButtonCreate($urlCreate)
        ];
    }
    
    public function isPostUpdate(): array
    {
        return [
            'forceReload' => $this->forceReload,
            'title' => $this->title,
            'content' => Html::tag(
                'span',
                $this->postUpdateMsg,
                $this->postUpdateOptions
            ),
            'footer' => $this->getButtonClose()
        ];
    }
    
    public function getDelete(): array
    {
        return [
            'forceClose' => true,
            'forceReload' => $this->forceReload
        ];
    }
    
    public function isErrorAction(): array
    {
        return [
            'forceReload' => $this->forceReload,
            'title' => $this->title,
            'content' => Html::tag(
                'span',
                implode(',', $this->model->getFirstErrors()),
                $this->errorActionOptions
            ),
            'footer' => $this->getButtonClose()
        ];
    }
    
    public function isContentAction(string $content): array
    {
        return [
            'forceReload' => $this->forceReload,
            'title' => $this->title,
            'content' => Html::tag(
                'span',
                $content,
                $this->contentActionOptions
            ),
            'footer' => $this->getButtonClose()
        ];
    }
    
}
