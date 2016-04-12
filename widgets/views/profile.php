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

<div class="media-body qanda-profile">

    <div class="row">
        <div class="col-xs-12 qanda-profile-timestamp">
            <small>posted <?php echo HHtml::timeago($timestamp); ?></small>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <a href="<?php echo $this->createUrl('//user/profile', array('uguid' => $user->guid)); ?>">
                <span class="pull-left profile-size-sm">
                    <img class="media-object img-rounded profile-size-sm"
                     src="<?php echo $user->getProfileImage()->getUrl(); ?>"
                     height="32" width="32" alt="32x32" data-src="holder.js/32x32"/>
                    <div class="profile-overlay-img profile-overlay-img-sm"></div>
                </span>
            </a>
            <div class="user-title pull-left">
                <strong><?php echo CHtml::encode($user->displayName); ?> <?php echo "(".KarmaUser::model()->score($user->id).")"; ?></strong><br/><span class="truncate"><?php echo CHtml::encode($user->profile->title); ?></span>
            </div>
        </div>
    </div>
    
</div>