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
 */
?>
<?php
/**
 * This View shows a profile
 *
 * @property User $user is the user object
 *
 * @package application.modules.questionanswer
 * @since 0.5
 */
?>

<div class="media-body" style="position:absolute;top:0;right:0; padding:10px; width:200px; background-color:#708FA0; color:#fff;">
    <a href="<?php echo $this->createUrl('//user/profile', array('uguid' => $user->guid)); ?>" style="color:#fff;">
        <img id="user-account-image" class="img-rounded pull-left"
             src="<?php echo $user->getProfileImage()->getUrl(); ?>"
             height="32" width="32" alt="32x32" data-src="holder.js/32x32"
             style="width: 32px; height: 32px; margin-right:10px;"/>

        <div class="user-title pull-left hidden-xs">
            <strong><?php echo CHtml::encode($user->displayName); ?> <?php echo "(".KarmaUser::model()->score($user->id).")"; ?></strong><br/><span class="truncate"><?php echo CHtml::encode($user->profile->title); ?></span>
        </div>
    </a>
</div>