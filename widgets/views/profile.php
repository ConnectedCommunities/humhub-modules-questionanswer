<?php
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
?>

<div class="media-body" style="position:absolute;top:0;right:0; padding:10px; width:200px; background-color:#708FA0; color:#fff;">
    <a href="<?php echo \yii\helpers\Url::toRoute(['/user/profile', 'uguid' => $user->guid]); ?>" style="color:#fff;">
        <img id="user-account-image" class="img-rounded pull-left"
             src="<?php echo $user->getProfileImage()->getUrl(); ?>"
             height="32" width="32" alt="32x32" data-src="holder.js/32x32"
             style="width: 32px; height: 32px; margin-right:10px;"/>

        <div class="user-title pull-left hidden-xs">
            <strong><?php echo Html::encode($user->displayName); ?> <?php echo "(".KarmaUser::score($user->id).")"; ?></strong><br/><span class="truncate"><?php echo Html::encode($user->profile->title); ?></span>
        </div>
    </a>
</div>