<?php

/**
 * This module provides favorite support for content and content addons
 * Each wall entry will get a favorite button.
 *
 * @author Anton Kurnitzky
 */
class FavoriteModule extends HWebModule
{
    /**
     * On User delete, also delete all corresponding favorites of this user
     *
     * @param type $event
     */
    public static function onUserDelete($event)
    {
        foreach (Favorite::model()->findAllByAttributes(array('created_by' => $event->sender->id)) as $favorite) {
            $favorite->delete();
        }
    }

    /**
     * On delete of a content object, also delete all corresponding favorites
     *
     * @param $event
     */
    public static function onContentDelete($event)
    {
        foreach (Favorite::model()->findAllByAttributes(array('object_id' => $event->sender->id, 'object_model' => get_class($event->sender))) as $favorites) {
            $favorites->delete();
        }
    }

    /**
     * On delete of a content addon object, e.g. a poll
     * also delete all favorites
     *
     * @param $event
     */
    public static function onContentAddonDelete($event)
    {
        foreach (Favorite::model()->findAllByAttributes(array('object_id' => $event->sender->id, 'object_model' => get_class($event->sender))) as $favorites) {
            $favorites->delete();
        }
    }

    /**
     * On run of integrity check command, validate all module data
     *
     * @param type $event
     */
    public static function onIntegrityCheck($event)
    {
        $integrityChecker = $event->sender;
        $integrityChecker->showTestHeadline("Validating Favorite Module (" . Favorite::model()->count() . " entries)");
    }

    /**
     * On initializing the wall entry controls also add the favorite link widget
     *
     * @param type $event
     */
    public static function onWallEntryLinksInit($event)
    {
        $event->sender->addWidget('application.modules.favorite.widgets.FavoriteLinkWidget', array('object' => $event->sender->object), array('sortOrder' => 10));
    }

    /**
     * On init of the wall entry addons, add a overview of existing favorites
     *
     * @param type $event
     */
    public static function onWallEntryAddonInit($event)
    {

    }

    /**
     * Show a favorite menu inside the Space-Menu
     * Here the user can see all his favorites inside this space
     *
     * @param type $event
     */
    public static function onSpaceMenuInit($event)
    {
        $space = Yii::app()->getController()->getSpace();
        if ($space->isModuleEnabled('favorite')) {
            $event->sender->addItem(array(
                'label' => Yii::t('FavoriteModule.base', 'Favorite'),
                'group' => 'modules',
                'url' => $space->createUrl('//favorite/favoriteWall/show'),
                'icon' => '<i class="fa fa-star"></i>',
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'favorite'),
                'sortOrder' => 105,
            ));
        }
    }

    public function init()
    {
        // import the module-level models and components
        $this->setImport(array(
            'favorite.models.*',
            'favorite.behaviors.*',
        ));
    }

    public function behaviors()
    {
        return array(
            'SpaceModuleBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
            ),
        );
    }
}