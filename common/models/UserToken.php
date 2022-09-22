<?php

declare(strict_types=1);

namespace common\models;

use bizley\jwt\Jwt;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Lcobucci\Clock\SystemClock;
use Ramsey\Uuid\Nonstandard\Uuid;
use Ramsey\Uuid\Rfc4122\UuidV4;
use thamtech\uuid\validators\UuidValidator;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property string $id
 * @property string $userId
 * @property int $type
 * @property string $token
 * @property string $expiredAt
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property User $user
 */
class UserToken extends \yii\db\ActiveRecord
{
    public const TYPE_ACCESS_TOKEN = 1;
    public const TYPE_REFRESH_TOKEN = 2;

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt']
                ],
                'value' => function () {
                    $carbon = new Carbon();
                    $carbon->format('Y-m-d H:i:s');
                    return $carbon->toDateTimeString();
                }
            ],
        ];
    }


    public function beforeValidate(): bool
    {
        if (\Yii::$app->db->driverName === 'mysql') {
            if($this->isNewRecord) {
                $this->id = UuidV4::uuid4()->toString();
            }
        }

        return parent::beforeValidate();
    }

    public function getDateValue(string $fieldName, string $mask = 'd.m.Y H:i'): string
    {
        return date($mask, strtotime(Carbon::parse($this->{$fieldName}, Yii::$app->timeZone)->toRfc3339String()));
    }

    public static function tableName(): string
    {
        return '{{%user_token}}';
    }

    public function rules(): array
    {
        return [
            [['userId', 'type', 'token', 'expiredAt',], 'required'],
            [['token'], 'string'],
            [['type'], 'default', 'value' => null],
            [['type'], 'integer'],
            [['expiredAt', 'createdAt', 'updatedAt'], 'safe'],
            [
                'userId',
                UuidValidator::class,
            ],
            [
                'type',
                'in',
                'range' => [self::TYPE_ACCESS_TOKEN, self::TYPE_REFRESH_TOKEN,],
            ],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'type' => 'Type',
            'token' => 'Token',
            'expiredAt' => 'Expired At',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    /**
     * @throws InvalidConfigException
     */
    public static function createToken(Jwt $jwt, int $type, string $userId, int $expire, array $data = []): self
    {
        if (!in_array($type, [self::TYPE_ACCESS_TOKEN, self::TYPE_REFRESH_TOKEN])) {
            throw new \InvalidArgumentException('Неизвестный тип ключа');
        }

        $token = new self();
        $token->id = Uuid::uuid4()->toString();
        $token->userId = $userId;
        $token->type = $type;
        $token->generateToken($jwt, $token->id, $expire, $data);

        return $token;
    }

    /**
     * @throws InvalidConfigException
     */
    public function generateToken(Jwt $jwt, string $id, int $expire, array $data): void
    {
        $dateNow = CarbonImmutable::instance(SystemClock::fromUTC()->now());
        $dateExpire = $dateNow->addSeconds($expire);
        $this->expiredAt = Carbon::parse(time() + $expire)->toDateTimeString();
        if ($this->type == (self::TYPE_ACCESS_TOKEN || self::TYPE_REFRESH_TOKEN)) {
            $this->token = $this->createTokenString($jwt, $id, $dateNow, $dateExpire, $data);
        }
    }

    /**
     * @throws InvalidConfigException
     */
    private function createTokenString(
        Jwt $jwt,
        string $id,
        CarbonImmutable $now,
        CarbonImmutable $expire,
        array $data
    ): string {
        $tokenBuilder = $jwt->getBuilder()
            ->canOnlyBeUsedAfter($now)
            ->identifiedBy($id)
            ->issuedAt($now)
            ->expiresAt($expire);

        foreach ($data as $name => $value) {
            $tokenBuilder->withClaim($name, $value);
        }

        return $tokenBuilder->getToken(
            $jwt->getConfiguration()->signer(),
            $jwt->getConfiguration()->signingKey()
        )
            ->toString();
    }
}
