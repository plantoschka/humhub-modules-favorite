<?php
/**
 * This view is shown when a user clicks on the "Favorite" menu item
 * It shows a stream widget which shows all wall entries that the user favorited.
 *
 * @author Anton Kurnitzky
 */
?>

<?php
$this->widget('application.modules.favorite.widgets.FavoriteStreamWidget', array(
    'contentContainer' => $this->contentContainer,
    'streamAction' => '//favorite/favoriteWall/stream',
));
?>