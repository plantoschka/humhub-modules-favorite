<?php

/**
 * This widget is used to show a favorite link inside the wall entry controls.
 *
 * @author Anton Kurnitzky
 */
class FavoriteLinkWidget extends HWidget
{
    /**
     * The Object to favorite
     *
     * @var type
     */
    public $object;

    /**
     * Initialize the Widget
     *
     */
    public function init()
    {

        // Inject some important Javascript Variables
        Yii::app()->clientScript->setJavascriptVariable(
            "favoriteUrl", Yii::app()->createUrl('//favorite/favorite/favorite', array('contentModel' => '-className-', 'contentId' => '-id-'))
        );
        Yii::app()->clientScript->setJavascriptVariable(
            "unfavoriteUrl", Yii::app()->createUrl('//favorite/favorite/unFavorite', array('contentModel' => '-className-', 'contentId' => '-id-'))
        );

        // Updates the Favorite Counter (favorite.js)
        $favorites = Favorite::GetFavorites(get_class($this->object), $this->object->id);
        Yii::app()->clientScript->registerScript(
            "updateFavoriteCounter" . $this->object->getUniqueId()
            , "updateFavoriteCounters('" . get_class($this->object) . "', '" . $this->object->id . "', " . count($favorites) . ");"
            , CClientScript::POS_READY
        );

        // Ensure favorite Javascript is loaded
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.modules.favorite.resources') . '/favorite.js'
            ), CClientScript::POS_BEGIN
        );

        // Execute favorite Javascript Init
        Yii::app()->clientScript->registerScript('initFavorite', 'initFavoriteModule();', CClientScript::POS_READY);

    }

    /**
     * Executes the widget
     */
    public function run()
    {
        $currentUserFavorited = false;

        $favorites = Favorite::GetFavorites(get_class($this->object), $this->object->id);
        foreach ($favorites as $favorite) {
            if ($favorite->getUser()->id == Yii::app()->user->id) {
                $currentUserFavorited = true;
            }
        }

        $this->render('favoriteLink', array(
            'favorites' => $favorites,
            'currentUserFavorited' => $currentUserFavorited,
            'id' => $this->object->getUniqueId()
        ));
    }
}