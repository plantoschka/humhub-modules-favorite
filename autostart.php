<?php
/*
 * Autostart actions for this module
 * @author Anton Kurnitzky
 */
Yii::app()->moduleManager->register(array(
    'id' => 'favorite',
    'class' => 'application.modules.favorite.FavoriteModule',
    'import' => array(
        'application.modules.favorite.*',
        'application.modules.favorite.behaviors.*',
        'application.modules.favorite.models.*',
    ),
    'events' => array(
        array('class' => 'User', 'event' => 'onBeforeDelete', 'callback' => array('FavoriteModule', 'onUserDelete')),
        array('class' => 'HActiveRecordContent', 'event' => 'onBeforeDelete', 'callback' => array('FavoriteModule', 'onContentDelete')),
        array('class' => 'HActiveRecordContentAddon', 'event' => 'onBeforeDelete', 'callback' => array('FavoriteModule', 'onContentAddonDelete')),
        array('class' => 'IntegrityChecker', 'event' => 'onRun', 'callback' => array('FavoriteModule', 'onIntegrityCheck')),
        array('class' => 'WallEntryLinksWidget', 'event' => 'onInit', 'callback' => array('FavoriteModule', 'onWallEntryLinksInit')),
        array('class' => 'WallEntryAddonWidget', 'event' => 'onInit', 'callback' => array('FavoriteModule', 'onWallEntryAddonInit')),
        array('class' => 'SpaceMenuWidget', 'event' => 'onInit', 'callback' => array('FavoriteModule', 'onSpaceMenuInit')),
    ),
));
?>