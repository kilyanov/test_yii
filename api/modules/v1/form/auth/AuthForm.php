<?php

declare(strict_types=1);

namespace api\modules\v1\form\auth;

use common\models\UserToken;
use api\modules\v1\records\auth\TokenFull;
use api\modules\v1\records\user\User;
use OpenApi\Annotations as OA;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * @OA\Schema(
 *     required={"username","password"},
 *     title="Вход пользователя в систему"
 * )
 */
class AuthForm extends Model
{
    /**
     * @OA\Property(
     *     property="username",
     *     type="string",
     *     description="Логин пользователя",
     * )
     */
    public string $username;

    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="Пароль пользователя",
     * )
     */
    public string $password;


    private ?User $_user = null;

    public function rules(): array
    {
        return [
            [['username', 'password', ], 'required',],
            [['username', 'password',], 'string', 'max' => 255,],
            [
                ['username', 'password',],
                'filter',
                'filter' => 'trim',
                'skipOnArray' => true,
            ],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function login(): bool|TokenFull
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user === null) return false;
            else {
                $expire = Yii::$app->params['token_access_expire'];
                $expireRefresh = Yii::$app->params['token_refresh_expire'];

                switch ($user->status) {
                    case User::STATUS_ACTIVE:
                        /** @var UserToken $tokenAccess */
                        /** @var UserToken $tokenRefresh */
                        [$tokenAccess, $tokenRefresh] = Yii::$app->db->transaction(
                            function () use ($user, $expire, $expireRefresh) {
                                UserToken::deleteAll(['userId' => $user->id]);
                                $tokenAccess = UserToken::createToken(
                                    Yii::$app->jwt,
                                    UserToken::TYPE_ACCESS_TOKEN,
                                    $user->id,
                                    $expire
                                );
                                $tokenRefresh = UserToken::createToken(
                                    Yii::$app->jwt,
                                    UserToken::TYPE_REFRESH_TOKEN,
                                    $user->id,
                                    $expireRefresh,
                                    [
                                        'accessId' => $tokenAccess->id,
                                        'refresh' => 1,
                                    ]
                                );

                                if (!$tokenAccess->save()) {
                                    throw new Exception(reset($tokenAccess->firstErrors), 422);
                                }
                                if (!$tokenRefresh->save()) {
                                    throw new Exception(reset($tokenRefresh->firstErrors), 422);
                                }

                                return [$tokenAccess, $tokenRefresh];
                            }
                        );

                        return new TokenFull([
                            'accessToken' => $tokenAccess->token,
                            'accessExpire' => $tokenAccess->expiredAt,
                            'refreshToken' => $tokenRefresh->token,
                            'refreshExpire' => $tokenRefresh->expiredAt,
                        ]);
                        break;
                    case User::STATUS_VERIFICATION:
                        throw new Exception('Пользователь проверяется', 422);
                        break;
                    case User::STATUS_INACTIVE:
                        throw new Exception('Пользователь неактивирован', 422);
                        break;
                }
            }
        }

        return false;
    }

    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
