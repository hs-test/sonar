<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "discom".
 *
 * @property int $id
 * @property string $guid
 * @property string $discom_code
 * @property int $created_at
 *
 * @property Grievance[] $grievances
 * @property User[] $users
 */
class Discom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['guid'], 'string', 'max' => 36],
            [['discom_code'], 'string', 'max' => 50],
            [['discom_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'discom_code' => 'Discom Code',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['discom_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['discom_id' => 'id']);
    }
}
