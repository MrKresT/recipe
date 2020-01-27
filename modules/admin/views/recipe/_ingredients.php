<?php
use yii\grid\GridView;use yii\helpers\Html;

?>

<div class="ingredient-index">

    <h2><?= 'Ингредиенты' ?></h2>

<p>
    <?= Html::a(Yii::t('models', 'Add Ingredient'), ['add-ingredient'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProviderIngredients,
    'filterModel' => $searchModelIngredients,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        [
            'attribute' => 'is_hide',
            'format' => 'raw',
            'filter'=>false,
            'value' => function ($model) {
                return ($model->is_hide
                        ? 'Скрыт'
                        : 'Не скрыт')
                    . Html::a($model->is_hide ? 'Сделать видимым' : 'Скрыть',
                        \yii\helpers\Url::to(['/admin/ingredient/hide', 'id' => $model->id]),
                        ['class' => 'btn btn-success', 'style'=>'margin-left:5px']);
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>


</div>
