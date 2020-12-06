<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_stat".
 *
 * @property int $id
 * @property int|null $media_id
 * @property string|null $type
 * @property string|null $logs
 * @property string|null $company_logs
 * @property int|null $total
 * @property int|null $success
 * @property int|null $failed
 * @property int|null $created_on
 *
 * @property Media $media
 */
class GrievanceStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_id', 'total', 'success', 'failed', 'created_on'], 'integer'],
            [['type', 'logs', 'company_logs'], 'string'],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::className(), 'targetAttribute' => ['media_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_id' => 'Media ID',
            'type' => 'Type',
            'logs' => 'Logs',
            'company_logs' => 'Company Logs',
            'total' => 'Total',
            'success' => 'Success',
            'failed' => 'Failed',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
