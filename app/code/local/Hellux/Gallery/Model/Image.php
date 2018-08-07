<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */

    //decided to use it for frontend - for backend is resource

class Hellux_Gallery_Model_Image extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_gallery/image'); 
    }

    public static function getImagesList($category_id){//frntend images that belong to choosen category

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $check_query = "SELECT * FROM hellux_gallery_image WHERE parent_id = '$category_id'";
        $success = $readConnection->query($check_query);
        $result = $success->fetchAll();

        return $result;

    }//end getImageData($id)


}//END CLASS