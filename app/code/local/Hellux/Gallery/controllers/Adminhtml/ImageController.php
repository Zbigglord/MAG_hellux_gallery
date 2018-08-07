<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:44
 */
class Hellux_Gallery_Adminhtml_ImageController extends Mage_Adminhtml_Controller_Action {

 public function indexAction()
 {
  $this->_title($this->__('Image'))->_title($this->__('Obrazki galerii'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/image');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_image_image'));
  $this->renderLayout();
 }


 public function editAction()
 {

  $ids = $this->getRequest()->getParam('ids');
  $this->_title($this->__('Galley'))->_title($this->__('Edytuj obrazek'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/gallery');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_image_edit'));
  $this->renderLayout();
  //var_dump($this->getRequest()->getParam('path'));
 }

 public function addsingleAction()
 {

  $this->_title($this->__('Gallery'))->_title($this->__('Dodaj obrazek'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/gallery');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_image_edit'));
  $this->renderLayout();
 }

 public function addmultipleAction()
 {
  $this->getRequest()->setParam('multiple', 1);
  $this->_title($this->__('Gallery'))->_title($this->__('Dodaj obrazki'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/gallery');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_image_edit'));
  $this->renderLayout();
 }

 public function saveAction()
 {
  $images = $this->getRequest()->getPost();
  $category = $images['parent_id'];
  if(isset($images['image_id']) && $images['image_id'] != ''){
   $edit_id = $images['image_id'];//set variable to further checking if it is edit action or new action
  }

  if(!isset($edit_id)){//means that it iss add new action

   if(isset($_FILES['image_path']) && is_array($_FILES['image_path']['name'])){//multiple upload - means no edit

    //clean up magentos act:
    $data = array();

    foreach($_FILES['image_path']['name'] as $key => $value){

     try {

      $uploader = new Varien_File_Uploader(array(
       'name' => $_FILES['image_path']['name'][$key],
       'type' => $_FILES['image_path']['type'][$key],
       'tmp_name' => $_FILES['image_path']['tmp_name'][$key],
       'error' => $_FILES['image_path']['error'][$key],
       'size' => $_FILES['image_path']['size'][$key]
      ));
      $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


      $uploader->setAllowRenameFiles(false);
      $uploader->setFilesDispersion(false);

      $path = Mage::getBaseDir('media') . DS . 'hellux' . DS . 'gallery' . DS . 'obrazki' . DS . $category ;

      if (!is_dir($path)) {
       mkdir($path, 0775);
      }

      $uploader->save($path, $_FILES['image_path']['name'][$key]);

      $image_path = Mage::getBaseUrl('media'). 'hellux' . DS . 'gallery' . DS . 'obrazki' . DS . $category . DS . $_FILES['image_path']['name'][$key];
      $data[] = $image_path;

     }catch(Exception $e) {
      Mage::getSingleton('adminhtml/session')->addError($e);
     }

    }//END loop uploader

    $save_messages = Hellux_Gallery_Model_Resource_Image::saveMultipleImage($data,$category);

    if(!empty($save_messages)){
     foreach($save_messages[0] as $err){
      $this->_getSession()->addError($err);
     }
     foreach($save_messages[1] as $scc){
      $this->_getSession()->addSuccess($scc);
     }
    }

   }elseif(isset($_FILES['image_path']['name']) and (file_exists($_FILES['image_path']['tmp_name']))){//means this is add single new action


    if(isset($_FILES['image_path']['name']) and (file_exists($_FILES['image_path']['tmp_name']))){

     try {

      $uploader = new Varien_File_Uploader('image_path');
      $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


      $uploader->setAllowRenameFiles(false);
      $uploader->setFilesDispersion(false);

      $path = Mage::getBaseDir('media') . DS . 'hellux' . DS . 'gallery' . DS . 'obrazki' . DS . $category ;

      if (!is_dir($path)) {
       mkdir($path, 0775);
      }

      $uploader->save($path, $_FILES['image_path']['name']);

      $images['image_path'] = Mage::getBaseUrl('media'). 'hellux' . DS . 'gallery' . DS . 'obrazki' . DS . $category . DS . $_FILES['image_path']['name'];

     }catch(Exception $e) {
      Mage::getSingleton('adminhtml/session')->addError($e);
     }

    }

    $save_image = Hellux_Gallery_Model_Resource_Image::saveSingleImage($images);

    if($save_image === TRUE){
     Mage::getSingleton('adminhtml/session')->addSuccess('Obrazek zapisano poprawnie');
    }

   }//end ADD NEW actions

  }else{//it is edit sinle action

   if(isset($_FILES['image_path']['name']) and (file_exists($_FILES['image_path']['tmp_name']))){

    try {

     $uploader = new Varien_File_Uploader('image_path');
     $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


     $uploader->setAllowRenameFiles(false);
     $uploader->setFilesDispersion(false);

     $path = Mage::getBaseDir('media') . DS . 'hellux' . DS . 'gallery' . DS . 'obrazki' . DS . $category ;

     if (!is_dir($path)) {
      mkdir($path, 0775);
     }

     $uploader->save($path, $_FILES['image_path']['name']);

     $images['image_path'] = Mage::getBaseUrl('media'). 'hellux' . DS . 'gallery' . DS . 'obrazki' . DS . $category . DS . $_FILES['image_path']['name'];

    }catch(Exception $e) {
     Mage::getSingleton('adminhtml/session')->addError($e);
    }

   }//end checking if image has chenged

   Hellux_Gallery_Model_Resource_Image::editSingleImage($images);

  }

  $this->_redirect('*/*/index');
 }

 public function massDeleteAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Wybierz obrazek(i) do usunięcia.'));
  } else {
   try {
    foreach ($ids as $id) {
     $model = Mage::getSingleton('hellux_gallery/image')->load($id);
     $model->delete();
    }

    $this->_getSession()->addSuccess(
     $this->__('Usunięto %d obrazków.', count($ids))
    );
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_gallery')->__('Wystąpił błąd podczas usuwania obrazka(ów).')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');
 }//END mass deleteAction
}