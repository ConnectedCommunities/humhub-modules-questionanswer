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

/**
 * This View shows a profile
 *
 * @property User $user is the user object
 *
 * @package application.modules.questionanswer
 * @since 0.5
 */
use yii\helpers\Html;
use humhub\modules\karma\models\KarmaUser;
use humhub\modules\user\widgets\Image as UserImage;
?>
<?=
UserImage::widget([
    'user' => $user,
    'width' => 40,
    'htmlOptions' => ['class' => 'pull-left']
]);
?>
<div class="media-body">
    <div class="media-heading" style="margin-bottom: 0; margin-top:3px;">
        <div class="user-title">
            <a href="<?php echo \yii\helpers\Url::toRoute(['/user/profile', 'uguid' => $user->guid]); ?>" style="padding-right: 5px;">
                <strong><span class="fullname"><?php echo Html::encode($user->displayName); ?></span> <?php if(isset(Yii::$app->modules['karma'])) echo "(".KarmaUser::score($user->id).")"; ?></strong>
            </a>
            <span class="post-timestamp" title="<?= $timestamp; ?>"><?= \humhub\widgets\TimeAgo::widget(['timestamp' => $timestamp]); ?></span>
        </div>

        <!--<div class="pull-right labels">-->
        <!--<span class="label label-default">Label</span>-->
        <!--</div>-->
    </div>
    <div class="media-subheading" style="margin-bottom: 5px;">
        <span class="truncate"><?= \humhub\modules\directory\widgets\UserGroupList::widget(['user' => $user]); ?></span>
    </div>
</div>