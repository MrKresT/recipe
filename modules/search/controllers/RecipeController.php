<?php

namespace app\modules\search\controllers;

use app\models\forms\SearchRecipeForm;
use yii\base\Model;
use yii\web\Controller;

/**
 * Default controller for the `search` module
 */
class RecipeController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $model = new SearchRecipeForm();

        $resultProvider = null;//$model->getSearchResult();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $resultProvider = $model->getSearchResult();
        }

        return $this->render('index', [
            'model' => $model,
            'resultProvider' => $resultProvider,
        ]);

    }
}
