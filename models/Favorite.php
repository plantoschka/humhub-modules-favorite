<?php

/**
 * Handles all of the basic operations on favorite table
 *
 * The followings are the available columns in table 'favorite':
 * @property integer $id
 * @property integer $target_user_id
 * @property string $object_model
 * @property integer $object_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @package humhub.modules.favorite.models
 */
class Favorite extends HActiveRecordContentAddon
{

    /**
     * Favorites Count for specific model
     */
    public static function GetFavorites($objectModel, $objectId)
    {
        $cacheId = "favorites_" . $objectModel . "_" . $objectId;
        $cacheValue = Yii::app()->cache->get($cacheId);

        if ($cacheValue === false) {
            $newCacheValue = Favorite::model()->findAllByAttributes(array('object_model' => $objectModel, 'object_id' => $objectId));
            Yii::app()->cache->set($cacheId, $newCacheValue, HSetting::Get('expireTime', 'cache'));
            return $newCacheValue;
        } else {
            return $cacheValue;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Favorite the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'favorite';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('object_model, object_id', 'required'),
            array('id, object_id, target_user_id created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('created_at', 'length', 'max' => 45),
            array('updated_at', 'safe')
        );
    }

    /**
     * Gets user for this favorite
     */
    public function getUser()
    {
        return User::model()->findByPk($this->created_by);
    }

    /**
     * After Save, delete FavoritesCount (Cache) for target object
     */
    protected function afterSave()
    {
        Yii::app()->cache->delete('favorites_' . $this->object_model . "_" . $this->object_id);
        return parent::afterSave();
    }

    /**
     * Before Delete, remove FavoritesCount (Cache) of target object.
     */
    protected function beforeDelete()
    {
        Yii::app()->cache->delete('favorites_' . $this->object_model . "_" . $this->object_id);

        return parent::beforeDelete();
    }

}