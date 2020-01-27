<?php

use yii\db\Migration;

/**
 * Class m200125_170111_init
 */
class m200125_170111_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ingredient', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'is_hide' => $this->boolean()->defaultValue(false)->notNull()
        ]);

        $this->createTable('recipe', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('pv_recipe_ingredient', [
            'recipe_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-recipe-pv_recipe_ingredient',
            'pv_recipe_ingredient',
            'recipe_id',
            'recipe',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-ingredient-pv_recipe_ingredient',
            'pv_recipe_ingredient',
            'ingredient_id',
            'ingredient',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-ingredient-pv_recipe_ingredient', 'pv_recipe_ingredient');
        $this->dropForeignKey('fk-recipe-pv_recipe_ingredient', 'pv_recipe_ingredient');
        $this->dropTable('pv_recipe_ingredient');
        $this->dropTable('recipe');
        $this->dropTable('ingredient');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200125_170111_init cannot be reverted.\n";

        return false;
    }
    */
}
