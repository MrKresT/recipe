<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models', 'Recipes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('models', 'Create Recipe'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'label' => Yii::t('models', 'Ingredients'),
                'format' => 'raw',
                'value' => function ($model) {
                    /**
                     * @var $model \app\models\Recipe
                     */
                    $res = '';
                    foreach ($model->pvRecipeIngredients as $recipeIngredient) {
                        $ingredient = $recipeIngredient->ingredient;
                        if ($ingredient) {
                            $res .= Html::encode($ingredient->name) . ($ingredient->is_hide ? ' (Скрыт)' : '') . '<br>';
                        }
                    }
                    return $res;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
