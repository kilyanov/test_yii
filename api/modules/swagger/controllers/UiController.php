<?php

namespace api\modules\swagger\controllers;

use common\models\User;
use common\models\UserToken as UserTokenAlias;
use api\modules\v1\records\auth\UserToken;
use Yii;
use yii\web\Controller;

class UiController extends Controller
{

    public function actionSwagger($id): string
    {
        Yii::$app->response->format = 'html';
        $this->layout = false;
        $token = '';

        if ($id) {
            $user = User::find()->where(['username' => $id])->one();
            if ($user instanceof User) {
                $tokenModel = UserToken::findOne([
                    'userId' => $user->id,
                    'type' => UserTokenAlias::TYPE_ACCESS_TOKEN
                ]);
                $token = $tokenModel?->token;
            }
        }

        return $this->render(
            'swagger',
            [
                'token' => $token,
                'ver' => 'v1',
            ]
        );
    }

    public function actionTest()
    {
        phpinfo();
        die();
    }
}
