<?php

namespace common\base\models;

use Yii;

/**
 * This is the model class for table "message_template".
 *
 * @property int $id
 * @property string $guid
 * @property string $title
 * @property string $type
 * @property string $service
 * @property string $template
 * @property int $is_active
 * @property int $is_deleted
 * @property int $created_by
 * @property int $modified_by
 * @property int $created_on
 * @property int $modified_on
 *
 * @property GrievanceMessageLog[] $grievanceMessageLogs
 * @property User $modifiedBy
 */
class MessageTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'title', 'created_by'], 'required'],
            [['type', 'template'], 'string'],
            [['is_active', 'is_deleted', 'created_by', 'modified_by', 'created_on', 'modified_on'], 'integer'],
            [['guid'], 'string', 'max' => 40],
            [['title', 'service'], 'string', 'max' => 100],
            [['title'], 'unique'],
            [['guid'], 'unique'],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_by' => 'id']],
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
            'title' => 'Title',
            'type' => 'Type',
            'service' => 'Service',
            'template' => 'Template',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceMessageLogs()
    {
        return $this->hasMany(GrievanceMessageLog::className(), ['message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }
}
