<?php
trait ReportContentTrait
{

    /**
     * Checks if the given or current user can report post with given id.
     *
     * @param (optional) Int $userId
     * @return bool
     */
    public function canReportPost($userId = "")
    {

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