<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="recipe-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('models', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                            $res .= Html::encode($ingredient->name) . ($ingredient->is_hide ? ' (Скрыт)' : '').'<br>';
                        }
                    }
                    return $res;
                }
            ]
        ],
    ]) ?>

</div>
