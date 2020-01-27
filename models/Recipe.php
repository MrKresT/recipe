<?php

namespace app\models;

use Yii;
use yii\db\Expression;

class Recipe extends base\Recipe
{

    public function getMyIngredients($showHide = false)
    {
        $query = Ingredient::find()
            ->joinWith('pvRecipeIngredients pv')
            ->andWhere(['pv.recipe_id' => $this->id]);
        if (!$showHide) {
            $query->andWhere(['is_hide' => false]);
        }
        return $query->all();
    }

    public function getIngredients($showHide = false)
    {
        $query = Ingredient::find()
            ->select(['id', 'name' => new Expression('CASE WHEN is_hide THEN CONCAT(name, " (Скрыт)") ELSE name END')]);
        if (!$showHide) {
            $query->andWhere(['is_hide' => false]);
        }

        return $query->all();
    }

}
