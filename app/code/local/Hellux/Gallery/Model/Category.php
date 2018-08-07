<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */

    //decided to use it for frontend - for backend is resource

class Hellux_Gallery_Model_Category extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_gallery/category');
    }

    public static function getList(){//frontend list

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $check_query = "SELECT * FROM hellux_gallery_category WHERE category_is_active = '0' AND category_archive = 0 ORDER BY category_id DESC";
        $success = $readConnection->query($check_query);
        $result = $success->fetchAll();

        return $result;

    }//end get list

    public static function getCatParam($param, $id){//frontend list

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $check_query = "SELECT * FROM hellux_gallery_category WHERE category_id = '$id' AND category_is_active = '0' AND category_archive = 0 ORDER BY category_id DESC";
        $success = $readConnection->query($check_query);
        $result = $success->fetchAll();
        foreach($result as $r){
            $data = $r[$param];
        }

        return $data;

    }//end get list

    public static function getArchive(){//frontend list archive

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $check_query = "SELECT * FROM hellux_gallery_category WHERE category_archive = 1 ORDER BY category_id DESC";
        $success = $readConnection->query($check_query);
        $result = $success->fetchAll();

        return $result;

    }//end get archive


}//END CLASS