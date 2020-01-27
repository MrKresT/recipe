<?php

/**
 * @var $model \app\models\forms\SearchRecipeForm
 * @var $resultProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="search-default-index">
    <h1><?= Yii::t('app', 'Search Recipe') ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ingredients')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($model->getIngredients(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберете ингредиенты ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumSelectionLength' => 5
        ],
    ])->label('Выберете ингредиенты');
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if ($model->ingredients && $resultProvider): ?>
        <?= GridView::widget([
            'dataProvider' => $resultProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                ],
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
                [
                    'label' => 'Кол-во найденных ингр.',
                    'attribute' => 'kolvo_i',
                ]
            ],
        ]); ?>
    <?php elseif ($model->ingredients && !$resultProvider): ?>
        <p>Ничего не найдено</p>
    <?php endif ?>
</div>
