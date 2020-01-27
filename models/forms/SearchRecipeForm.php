<?php


namespace app\models\forms;


use app\models\PvRecipeIngredient;
use app\models\Recipe;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class SearchRecipeForm extends Recipe
{
    public $ingredients;
    public $kolvo_i;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['ingredients'], 'checkIngredients'],
            [['kolvo_i'], 'safe'],
        ]);
    }

    public function checkIngredients()
    {
        if (count($this->ingredients) < 2) {
            $this->addError('ingredients', 'Выберете больше ингредиентов');
            return false;
        }
        if (count(array_unique($this->ingredients)) != count($this->ingredients)) {
            $this->addError('ingredients', 'Присутствует дубль ингедиентов');
            return false;
        }
        return true;
    }

    public function getSearchResult()
    {
        $countIngr = count($this->ingredients);
        $query = PvRecipeIngredient::find()
            ->select(['recipe_id', 'kolvo_i' => new Expression('count(ingredient_id)')])
            ->andWhere(['ingredient_id' => $this->ingredients]);

        $query5 = clone $query;
        $query5->andHaving(new Expression("count(ingredient_id) = $countIngr"))->groupBy(['recipe_id']);

        $queryFind = SearchRecipeForm::find()
            ->select(['recipe.*', 'pr.kolvo_i'])
            ->joinWith('pvRecipeIngredients pv')
            ->innerJoin('ingredient i','pv.ingredient_id = i.id')
            ->innerJoin(['pr'=>$query5],'pr.recipe_id = recipe.id')
            ->groupBy(['recipe.id'])
            ->having(new Expression('sum(i.is_hide) = 0'));

        if ($queryFind->exists()) {
            return new ActiveDataProvider([
                'query' =>  SearchRecipeForm::find()
                    ->select(['recipe.*', 't.kolvo_i'])
                    ->innerJoin(['t' => $queryFind], 't.id = recipe.id')
                    ->orderBy(['name' => SORT_ASC]),
                'sort' => false,
            ]);
        }
        $query2to4 = clone $query;
        $query2to4->andHaving(new Expression("count(ingredient_id) BETWEEN 2 AND $countIngr"))->groupBy(['recipe_id']);

        $queryFind = SearchRecipeForm::find()
            ->select(['recipe.*', 'pr.kolvo_i'])
            ->joinWith('pvRecipeIngredients pv')
            ->innerJoin('ingredient i','pv.ingredient_id = i.id')
            ->innerJoin(['pr'=>$query2to4],'pr.recipe_id = recipe.id')
            ->groupBy(['recipe.id'])
            ->having(new Expression('sum(i.is_hide) = 0'));

        if ($queryFind->exists()) {
            return new ActiveDataProvider([
                'query' => SearchRecipeForm::find()
                    ->select(['recipe.*', 't.kolvo_i'])
                    ->innerJoin(['t' => $queryFind], 't.id = recipe.id')
                    ->orderBy([
                        't.kolvo_i' => SORT_DESC,
                        'name' => SORT_ASC,
                    ]),
                'sort' => false,
            ]);
        }
        return null;
    }

}
