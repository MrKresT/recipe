<?php

namespace app\models\forms;

use app\models\Ingredient;
use app\models\PvRecipeIngredient;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class RecipeForm extends \app\models\Recipe
{
    public $ingredients;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['ingredients'], 'checkIngredient']
        ]);
    }

    public function checkIngredient()
    {
        if (count($this->ingredients) < 2){
            $this->addError('ingredients', 'Ингредиентов должно быть минимум 2');
            return false;
        }
        if (count(array_unique($this->ingredients)) != count($this->ingredients)){
            $this->addError('ingredients', 'Присутствует дубль ингедиентов');
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
            [
                'ingredients' => Yii::t('models', 'Ingredients')
            ]); // TODO: Change the autogenerated stub
    }


    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveRecipe()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        if (!$this->save()) {
            $transaction->rollBack();
            return false;
        }
        if (count($this->ingredients)) {
            PvRecipeIngredient::deleteAll(['recipe_id' => $this->id]);
            foreach ($this->ingredients as $ingredient_id) {
                $ingredient = new PvRecipeIngredient();
                $ingredient->recipe_id = $this->id;
                $ingredient->ingredient_id = $ingredient_id;
                if (!$ingredient->save()) {
                    $transaction->rollBack();
                    return false;
                }
            }
        }
        $transaction->commit();
        return true;
    }
}
