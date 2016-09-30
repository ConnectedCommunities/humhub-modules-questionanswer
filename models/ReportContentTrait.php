<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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
 *
 *
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences GNU AGPL v3
 *
 */

trait ReportContentTrait
{

    /**
     * Checks to see if the reportcontent module is enabled
     */
    public function reportModuleEnabled()
    {
        return isset(Yii::app()->modules['reportcontent']);
    }
    /**
     * Checks if the given or current user can report post with given id.
     *
     * @param (optional) Int $userId
     * @return bool
     */
    public function canReportPost($userId = "")
    {

        if(!$this->reportModuleEnabled())
            return false;

        if ($userId == "")
            $userId = Yii::app()->user->id;

        $user = User::model()->findByPk($userId);

        if ($user->super_admin)
            return false;

        if ($this->created_by == $user->id)
            return false;

        if (Yii::app()->user->isGuest)
            return false;

        if (User::model()->exists('id = ' . $this->created_by . ' and super_admin = 1'))
            return false;

        return true;

    }

}
?>