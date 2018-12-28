<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\questionanswer\models;

use humhub\modules\questionanswer\models\Comment;
use humhub\components\ActiveRecord;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\search\interfaces\Searchable;
use yii\helpers\Url;

/**
 * Category == Space
 */
class Category extends ActiveRecord
{

    const SEPARATOR = " > "; // string used to separate group from category e.g. Investment > Tax Matters

    const EXPECTED_NUMBER_OF_PARTS = 2; // After separation, we only ever expect 2 parts: group and category

    const GROUP_NAME_POSITION = 0; // part of array that will contain the group name

    const CATEGORY_NAME_POSITION = 1; // part of array that will contain the category name

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'contentcontainer_module';
    }

    /**
     * Category has a Space
     *
     * @return Space
     */
    public function getSpace()
    {
        return $this->hasOne(Space::class, ['id' => 'contentcontainer_id']);
    }

    /**
     * Add scopes to Category model
     * We are only interested in spaces that have enabled the module
     */
    public static function find()
    {
        return parent::find()->andWhere(['module_id' => 'questionanswer']);
    }

    /**
     * Retrieve all the categories grouped
     *
     * @return array
     */
    public static function all()
    {
        $groups = [];

        // Get the list of hidden categories. If there's nothing set, set an empty array.
        $hidden = array_map('trim', explode("\n", Yii::$app->getModule('questionanswer')->settings->get('hiddenCategoryList')));
        if($hidden == null) $hidden = [];

        foreach(self::find()->all() as $category) {

            if($category->getSpace()->exists()) {

                // Explode '>'. Everything before == Group, everything after == category name
                $parts = explode(self::SEPARATOR, $category->space->name);

                // A category must not be in the `hiddenCategoryList` list
                if(!in_array($parts[self::GROUP_NAME_POSITION], $hidden)) {

                    // Add link to parent category
                    $groups[$parts[self::GROUP_NAME_POSITION]]['link'] = $category->space->createUrl('//questionanswer/question/index');
                    $groups[$parts[self::GROUP_NAME_POSITION]]['createLink'] = $category->space->createUrl('//questionanswer/question/create');

                    if(count($parts) == self::EXPECTED_NUMBER_OF_PARTS) { // Subcategories must have two parts
                        $groups[$parts[self::GROUP_NAME_POSITION]][] = [
                            'name' => $parts[self::CATEGORY_NAME_POSITION],
                            'description' => $category->space->description,
                            'subCategory' => true,
                            'link' => $category->space->createUrl('//questionanswer/question/index'),
                            'space' => $category->space,
                        ];
                    } else { // A space with the questionanswer module enabled
                        $groups[$category->space->name][] = [
                            'name' => $category->space->name,
                            'description' => $category->space->description,
                            'subCategory' => false,
                            'link' => $category->space->createUrl('//questionanswer/question/index'),
                            'space' => $category->space
                        ];
                    }

                }

            }


        }

        return $groups;

    }

    /**
     * Filters results by the question_id
     * @param $question_id
     */
    public function question($question_id)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>"question_id=:question_id",
            'params' => array(':question_id' => $question_id)
        ));

        return $this;
    }

}
