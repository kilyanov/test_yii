<?php

declare(strict_types=1);

namespace common\models;

use Carbon\CarbonImmutable;
use Lcobucci\Clock\SystemClock;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $username Логин
 * @property string $auth_key Ключ
 * @property string $password_hash Пароль
 * @property string|null $password_reset_token Токен для сброса пароля
 * @property string $email Email
 * @property string|null $verification_token Токен регистрации
 * @property int $status
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property UserToken[] $userTokens
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_BLOCK = -1;
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_VERIFICATION = 3;

    public static function getListData(): array
    {
        $models = self::find()->andWhere(['status' => self::STATUS_ACTIVE])->all();

        return ArrayHelper::map($models, 'id', 'username');
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_BLOCK => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_INACTIVE => 'Не активный',
            self::STATUS_VERIFICATION => 'На проверке',
        ];
    }

    public function getStatusValue(): string
    {
        if ($this->hasProperty('status')) {
            $list = self::getStatusList();
            return $list[$this->status];
        }
    }

    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public function rules(): array
    {
        return [
            [['username', 'password_hash', 'email', ], 'required'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['status', 'phoneCheck',], 'integer'],
            [['phone', 'username', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'currentProfile'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Ключ',
            'password_hash' => 'Пароль',
            'password_reset_token' => 'Токен для сброса пароля',
            'email' => 'Email',
            'verification_token' => 'Токен регистрации',
            'status' => 'Статус',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return ActiveRecord|null
     **/
    public static function findIdentityByAccessToken($token, $type = UserToken::TYPE_ACCESS_TOKEN): ActiveRecord|IdentityInterface|null
    {
        if ($type === 'yii\filters\auth\HttpBearerAuth') {
            $type = UserToken::TYPE_ACCESS_TOKEN;
        }
        return static::find()
            ->joinWith('userTokens t', false)
            ->andWhere([
                't.token' => $token,
                't.type' => $type,
            ])
            ->andWhere([
                    '>',
                    't.expiredAt',
                    CarbonImmutable::instance(SystemClock::fromUTC()->now())->toDateTimeString(),
                ]
            )
            ->one();
    }

    public function getUserTokens(): ActiveQuery
    {
        return $this->hasMany(UserToken::class, ['userId' => 'id']);
    }

    public static function findByUsername(string $username): ?ActiveRecord
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public static function findByPasswordResetToken(string $token): ?ActiveRecord
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken(string $token): ?ActiveRecord
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function findByEmail(string $email): ?ActiveRecord
    {
        return static::findOne([
            'email' => $email,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @throws Exception
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

}
