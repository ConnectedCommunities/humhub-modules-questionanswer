<?php
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