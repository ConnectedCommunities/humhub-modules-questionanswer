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

use humhub\modules\user\models\User;
use Yii;

trait ReportContentTrait
{

    /**
     * Checks to see if the reportcontent module is enabled
     */
    public function reportModuleEnabled()
    {
        return Yii::$app->hasModule('reportcontent');
    }
    /**
     * Checks if the given or current user can report post with given id.
     *
     * @param (optional) Int $userId
     * @return bool
     */
    public function canReportPost($userId = "")
    {


        if(!Yii::$app->hasModule('reportcontent'))
            return false;

        if ($userId == "")
            $userId = Yii::$app->getUser()->id;

        $user = User::findOne(['id' => $userId]);

        if ($user->super_admin)
            return false;

        if ($this->created_by == $user->id)
            return false;


        if (Yii::$app->getUser()->isGuest)
            return false;

        if (User::findOne(['id' => $this->created_by, 'super_admin' => 1]))
            return false;

        return true;

    }

}
?>