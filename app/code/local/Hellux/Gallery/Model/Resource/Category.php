<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */ 
class Hellux_Gallery_Model_Resource_Category extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_gallery/category', 'category_id');
    }

    public static function checkIfExists($title){

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $check_query = "SELECT * FROM hellux_gallery_category WHERE category_title = '$title'";
        $success = $readConnection->query($check_query);
        $found = $success->rowCount();

        if($found > 0){

            return TRUE;

        }else{

            return FALSE;

        }

    }//end checkIfExists($title)


    public static function saveCategory($data){

        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');

        $category_title = $data['category_title'];
        $category_thumbnail = $data['category_thumbnail'];
        $category_description = $data['category_description'];
        $category_is_active = $data['category_is_active'];
        $category_archive = $data['category_archive'];

     if(isset($data['category_archive'])){

      $category_archive = $data['category_archive'];

     }else{

      $category_archive = '0';

     }


        $check_if_exists = self::checkIfExists($category_title);

      if($check_if_exists != TRUE){

        $insert_query = "INSERT INTO hellux_gallery_category
          (
            category_title,
            category_thumbnail,
            category_description,
            category_is_active,
            category_added_date,
            category_archive
          ) VALUES(
           '$category_title',
           '$category_thumbnail',
           '$category_description',
           '$category_is_active',
            NOW(),
           '$category_archive'
          )
       ";

        $success = $writeConnection->query($insert_query);

        if(!$success){

            throw new Exception($success->errorInfo());

        }else{

            Mage::getSingleton('adminhtml/session')->addSuccess('Nowa kategoria została dodana poprawnie.');
        }

      }else{

       Mage::getSingleton('adminhtml/session')->addError('Taka kategoria już istnieje. Kategoria nie została dodana.');

      }

    }//end saveCategory($data)

 public static function editCategory($data){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  $category_title = $data['category_title'];
  $category_thumbnail = $data['category_thumbnail'];
  $category_description = $data['category_description'];
  $category_is_active = $data['category_is_active'];
  $category_archive = $data['category_archive'];
  $category_id = $data['category_id'];

  if(isset($data['category_archive'])){

   $category_archive = $data['category_archive'];

  }else{

   $category_archive = '0';

  }

  if(isset($category_thumbnail) || $category_thumbnail != ''){

   $edit_query = "UPDATE hellux_gallery_category SET
            category_title = '$category_title',
            category_thumbnail = '$category_thumbnail',
            category_description = '$category_description',
            category_is_active = '$category_is_active',
            category_edited_date = NOW(),
            category_archive = '$category_archive'
            WHERE category_id = '$category_id'
       ";

  }else{

   $edit_query = "UPDATE hellux_gallery_category SET
            category_title = '$category_title',
            category_description = '$category_description',
            category_is_active = '$category_is_active',
            category_edited_date = NOW(),
            category_archive = '$category_archive'
            WHERE category_id = '$category_id'
       ";

  }

   $success = $writeConnection->query($edit_query);

   if(!$success){

    throw new Exception($success->errorInfo());

   }else{

    Mage::getSingleton('adminhtml/session')->addSuccess('Kategorię wyedytowano poprawnie.');
   }


 }//end saveCategory($data)

    public static function getCategoryById($id){

     $resource = Mage::getSingleton('core/resource');
     $readConnection = $resource->getConnection('core_read');
     $check_query = "SELECT * FROM hellux_gallery_category WHERE category_id = '$id'";
     $success = $readConnection->query($check_query);

     if(!$success){

      throw new Exception($success->errorInfo());

     }else{

      $result = $success->fetchAll();
      return $result;

     }

    }//end getArticleById()

 public static function getPathsForSelect(){

  $resource = Mage::getSingleton('core/resource');
  $readConnection = $resource->getConnection('core_read');
  $results = array();
  try{

   $get_query = "SELECT * FROM hellux_gallery_category";
   $results = $readConnection->fetchAll($get_query);

  }catch (Exception $e){

   Mage::getSingleton('adminhtml/session')->addError($e);

  }

  return $results;

 }//end getPath($id)

 public static function toOptionArray()
 {

  $paths = self::getPathsForSelect();

  $pathsarray = array(array('value' => -1, 'label' => 'wybierz...'));

  foreach ($paths as $path){

   $pathsarray[] = array('value'=>$path['category_id'],'label'=>$path['category_title']);

  }

  return $pathsarray;

 }//needed to select

 public static function changeActive($id, $flag){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  if($flag == 'on'){
   $flag = 0;
  }else{
   $flag = 1;
  }

  try{

   $change_query = "UPDATE hellux_gallery_category set category_is_active = '$flag' WHERE category_id = '$id'";
   $success = $writeConnection->query($change_query);

  }catch (Exception $e){

   Mage::getSingleton('adminhtml/session')->addError($e);

  }

 }//end function changeActive($id, $flag)

 public static function changeArchive($id, $flag){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  if($flag == 'on'){
   $flag = 1;
  }else{
   $flag = 0;
  }

  try{

   $change_query = "UPDATE hellux_gallery_category set category_archive = '$flag' WHERE category_id = '$id'";
   $success = $writeConnection->query($change_query);

  }catch (Exception $e){

   Mage::getSingleton('adminhtml/session')->addError($e);

  }

 }//end function changeArchive($id, $flag)

 public static function checkChildren($id){//check if category has images

  $resource = Mage::getSingleton('core/resource');
  $readConnection = $resource->getConnection('core_read');

  try{

   $check_query = "SELECT * FROM hellux_gallery_image WHERE parent_id = '$id'";
   $success = $readConnection->query($check_query);
   $found = $success->rowCount();


  }catch (Exception $e){

   Mage::getSingleton('adminhtml/session')->addError($e);

  }

  if(isset($found) && $found > 0){

   return TRUE;//if has images

  }else{

   return FALSE;

  }

 }//end checkChildren($id)

 public static function deleteCategory($id){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  $has_children = self::checkChildren($id);

  if($has_children == FALSE){//if has no images continue

   try{

    $check_query = "DELETE FROM hellux_gallery_category WHERE category_id = '$id'";
    $success = $writeConnection->query($check_query);
    Mage::getSingleton('adminhtml/session')->addSuccess('Kategorię: '.$id.' usunięto poprawnie.');
    return TRUE;

   }catch (Exception $e){

    Mage::getSingleton('adminhtml/session')->addError($e);

   }

  }else{

   Mage::getSingleton('adminhtml/session')->addError('Kategoria: '.$id.' ma przypisane do obrazki. Usuń obrazki, następnie usuń kategorię.');
   return FALSE;

  }

 }//end deleteCategory($id)




}//END CLASS