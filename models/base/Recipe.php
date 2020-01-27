<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "recipe".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property PvRecipeIngredient[] $pvRecipeIngredients
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models','ID'),
            'name' => Yii::t('models','Name'),
        ];
    }

    /**
     * Gets query for [[PvRecipeIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPvRecipeIngredients()
    {
        return $this->hasMany(PvRecipeIngredient::className(), ['recipe_id' => 'id']);
    }
}
