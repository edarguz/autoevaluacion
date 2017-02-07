<?php

/**
 * AdminBootstrap class file.
 *
 * @author Matt Skelton
 * @date 20-May-2013
 */
Yii::import('admin.library.bootstrap.components.Bootstrap');

/**
 * The main point of this class is to change the assets path for the
 * Admin Module's Bootstrap component. This is needed because if the front-end
 * uses Bootstrap too, it will override this module's style. We force it to load
 * a separate asset folder, thereby separating the styles between front/backend.
 */
class AdminBootstrap extends Bootstrap
{
    /**
     * @var boolean indicates whether assets should be republished on every request.
     */
    public $forceCopyAssets = false;

    /**
     * Returns the URL to the published assets folder.
     * @return string the URL
     */
    public function getAssetsUrl()
    {
        if (isset($this->_assetsUrl))
            return $this->_assetsUrl;
        else
        {
            $assetsPath = Yii::getPathOfAlias('application.modules.admin.library.bootstrap.assets');
            $assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, $this->forceCopyAssets);
            return $this->_assetsUrl = $assetsUrl;
        }
    }

}
?>
