<?php

/**
 * This controller provides the favorite button
 * @author Anton Kurnitzky
 */
class FavoriteController extends ContentAddonController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@', (HSetting::Get('allowGuestAccess', 'authentication_internal')) ? "?" : "@"),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Create a new entry in favorite table
     */
    public function actionFavorite()
    {
        $this->forcePostRequest();
        $attributes = array('object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::app()->user->id);
        $favorite = Favorite::model()->findByAttributes($attributes);
        if ($favorite == null && !Yii::app()->user->isGuest) {
            // Create Favorite Object
            $favorite = new Favorite();
            $favorite->object_model = $this->contentModel;
            $favorite->object_id = $this->contentId;
            $favorite->save();
        }
        $this->actionShowFavorites();
    }

    /**
     * Returns an JSON with current favorite information about a content object
     */
    public function actionShowFavorites()
    {
        // Some Meta Infos
        $currentUserFavorited = false;
        $favorites = Favorite::GetFavorites($this->contentModel, $this->contentId);
        foreach ($favorites as $favorite) {
            if ($favorite->getUser()->id == Yii::app()->user->id) {
                $currentUserFavorited = true;
            }
        }
        $json = array();
        $json['currentUserFavorited'] = $currentUserFavorited;
        $json['favoriteCounter'] = count($favorites);
        echo CJSON::encode($json);
        Yii::app()->end();
    }

    /**
     * Remove entry in favorite table
     */
    public function actionUnFavorite()
    {
        $this->forcePostRequest();
        if (!Yii::app()->user->isGuest) {
            $attributes = array('object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::app()->user->id);
            $favorite = Favorite::model()->findByAttributes($attributes);
            if ($favorite != null) {
                $favorite->delete();
            }
        }
        $this->actionShowFavorites();
    }

}