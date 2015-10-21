<?php
/**
 * This view is used by the FavoriteLinkWidget to inject a link to the
 * Wall Entry Controls.
 */
?>

<?php if (Yii::app()->user->isGuest): ?>
    <?php echo CHtml::link('<i class="fa fa-star-o"></i>', Yii::app()->user->loginUrl, array('data-target' => '#globalModal', 'data-toggle' => 'modal')); ?>
<?php else: ?>
    <a href="#" id="<?php echo $id . "-FavoriteLink"; ?>" class="favorite favoriteAnchor"
       style="<?php if ($currentUserFavorited): ?>display:none<?php endif; ?>"><?php echo '<i class="fa fa-star-o"></i>'; ?></a>
<?php endif; ?>
    <a href="#" id="<?php echo $id . "-UnfavoriteLink"; ?>" class="unfavorite favoriteAnchor"
       style="<?php if (!$currentUserFavorited): ?>display:none<?php endif; ?>"><?php echo '<i class="fa fa-star" style="color:#EAC117"></i>'; ?></a>

<?php
// get class name and model id from $id variable
list($className, $modelId) = explode("_", $id);
?>

<!-- show count of users who have favorited this post -->
<?php ?><span class="<?php echo $id . "-FavoriteCount"; ?>"></span><?php ?>