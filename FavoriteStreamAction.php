<?php
/*
 * Filter wall to only show user favorites
 * @author Anton Kurnitzky
 */
class FavoriteStreamAction extends ContentContainerStreamAction
{

    /**
     * Setup additional filters
     */
    public function setupFilters()
    {
        $this->criteria->join .= " LEFT JOIN favorite ON content.object_id=favorite.object_id";
        $this->criteria->condition .= " AND favorite.created_by= '" . Yii::app()->user->id . "'";
        $this->criteria->condition .= " AND favorite.object_model=content.object_model";

        parent::setupFilters();
    }

}