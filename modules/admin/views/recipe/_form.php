<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\forms\RecipeForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingredients')->widget(\unclead\multipleinput\MultipleInput::class, [
        'max' => 10,
        'min' => 2, // should be at least 2 rows
        'allowEmptyList' => false,
        'enableGuessTitle' => true,
        'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
        'columns' => [
            [
                'name'  => 'ingredients',
                'type'  => 'dropDownList',
                'title' => Yii::t('models','Ingredients'),
                'items' => \yii\helpers\ArrayHelper::map( $model->getIngredients(true),'id','name'),
            ],
        ]
    ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('models', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
