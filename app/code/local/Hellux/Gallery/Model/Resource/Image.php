<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */ 
class Hellux_Gallery_Model_Resource_Image extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_gallery/image', 'image_id');
    }

    public static function checkIfImageExists($path, $category_id){

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $check_query = "SELECT * FROM hellux_gallery_image WHERE parent_id = '$category_id' AND image_path = '$path'";
        $success = $readConnection->query($check_query);
        $found = $success->rowCount();

        if($found > 0){

            return TRUE;

        }else{

            return FALSE;

        }

    }//end checkIfImageExists($path, $category_id)


    public static function saveMultipleImage($data, $category_id){

        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $error_array = array();
        $success_array = array();
        $msg_array = array();

       foreach($data as $path){
        $check_if_exists = self::checkIfImageExists($path, $category_id);

      if($check_if_exists === FALSE){

        $insert_query = "INSERT INTO hellux_gallery_image (parent_id, image_path) VALUES ('$category_id', '$path')";

        $success = $writeConnection->query($insert_query);

        if(!$success){

            throw new Exception($success->errorInfo());

        }else{

         $success_array[] = ('Obrazek: '.$path.' został dodany poprawnie.');
        }

      }else{

       $error_array[] = ('Taki obrazek w podanej kategorii już istnieje: '.$path.' - obrazek nie został dodany.');

      }
     }

     array_push($msg_array, $error_array);//add error messages
     array_push($msg_array, $success_array);//add success messages
     return $msg_array;

    }//end saveMultipleImage($data, $category_id)

 public static function saveSingleImage($data){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  $parent_id = $data['parent_id'];
  $image_path = $data['image_path'];
  $image_description = isset($data['image_description']) ? $data['image_description'] : '';
  $image_title = isset($data['image_title']) ? $data['image_title'] : '';
  $image_alt = isset($data['image_alt']) ? $data['image_alt'] : '';

  $check_if_exists = self::checkIfImageExists($image_path, $parent_id);

  if($check_if_exists === FALSE){

   $insert_query = "INSERT INTO hellux_gallery_image (
                    parent_id,
                    image_path,
                    image_description,
                    image_title,
                    image_alt
                    ) VALUES (
                    '$parent_id',
                    '$image_path',
                    '$image_description',
                    '$image_title',
                    '$image_alt'
                    )";

   $success = $writeConnection->query($insert_query);

   if(!$success){

    throw new Exception($success->errorInfo());

   }else{

    return TRUE;

   }

  }else{
   Mage::getSingleton('adminhtml/session')->addError('Taki obrazek już istnieje dla podanej kategorii. Obrazek nie został zapisany');
   return FALSE;
  }

 }//end saveSingleImage($data, $id)

  public static function getImageData($id){

   $resource = Mage::getSingleton('core/resource');
   $readConnection = $resource->getConnection('core_read');
   $check_query = "SELECT * FROM hellux_gallery_image WHERE image_id = '$id'";
   $success = $readConnection->query($check_query);
   $result = $success->fetchAll();

   return $result;

  }//end getImageData($id)

 public static function editSingleImage($data){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  $image_id = $data['image_id'];
  $parent_id = $data['parent_id'];
  $image_path = $data['image_path'];
  $image_description = isset($data['image_description']) ? $data['image_description'] : '';
  $image_title = isset($data['image_title']) ? $data['image_title'] : '';
  $image_alt = isset($data['image_alt']) ? $data['image_alt'] : '';

  if($image_path != ''){

   $edit_query = "UPDATE hellux_gallery_image SET
            parent_id = '$parent_id',
            image_path = '$image_path',
            image_description = '$image_description',
            image_title = '$image_title',
            image_alt = '$image_alt'
            WHERE image_id = '$image_id'
       ";

  }else{

   $edit_query = "UPDATE hellux_gallery_image SET
            parent_id = '$parent_id',
            image_description = '$image_description',
            image_title = '$image_title',
            image_alt = '$image_alt'
            WHERE image_id = '$image_id'
       ";

  }

   $success = $writeConnection->query($edit_query);

   if(!$success){

    throw new Exception($success->errorInfo());

   }else{

    Mage::getSingleton('adminhtml/session')->addSuccess('Obrazek uaktualniony poprawnie.');

   }

 }//end editSingleImage($data, $id)


}//END CLASS