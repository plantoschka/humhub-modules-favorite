<?php

/**
 * This controller manages the favorite wall inside a space
 *
 * @author Anton Kurnitzky
 */
class FavoriteWallController extends ContentContainerController
{
    public function actions()
    {
        return array(
            'stream' => array(
                'class' => 'FavoriteStreamAction',
                'contentContainer' => $this->contentContainer
            ),
        );
    }

    /**
     * Show the favorite space widget
     */
    public function actionShow()
    {
        $this->render('show', array());
    }
}