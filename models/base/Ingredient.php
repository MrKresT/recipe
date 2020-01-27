<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string|null $name
 * @property int $is_hide
 *
 * @property PvRecipeIngredient[] $pvRecipeIngredients
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_hide'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'is_hide' => 'Скрытость',
        ];
    }

    /**
     * Gets query for [[PvRecipeIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPvRecipeIngredients()
    {
        return $this->hasMany(PvRecipeIngredient::className(), ['ingredient_id' => 'id']);
    }
}
