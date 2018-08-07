<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 09:28
 */
class Hellux_Gallery_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action {


 public function indexAction()
 {
  $this->_title($this->__('Gallery'))->_title($this->__('Lista categorii'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_category_category'));
  $this->renderLayout();
 }

 public function newAction(){
  $this->_title($this->__('Gallery'))->_title($this->__('Dodaj nową kategorię'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_category_edit'));
  $this->renderLayout();
 }

 public function editAction()
 {

  //$id = $this->getRequest()->getParam('id');

  $this->_title($this->__('Gallery'))->_title($this->__('Edytuj kategorię'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/gallery');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_category_edit'));
  $this->renderLayout();
 }


 public function saveAction()
 {

  $category = $this->getRequest()->getPost();

  if(isset($_FILES['category_thumbnail']['name']) and (file_exists($_FILES['category_thumbnail']['tmp_name']))){

   try {

    $uploader = new Varien_File_Uploader('category_thumbnail');
    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


    $uploader->setAllowRenameFiles(false);
    $uploader->setFilesDispersion(false);

    $path = Mage::getBaseDir('media') . DS . 'hellux' . DS . 'gallery' . DS . 'galerie' . DS  ;

    if (!is_dir($path)) {
     mkdir($path, 0775);
    }

    $uploader->save($path, $_FILES['category_thumbnail']['name']);

    $category['category_thumbnail'] = Mage::getBaseUrl('media') . 'hellux' . DS . 'gallery' . DS . 'galerie' . DS . $_FILES['category_thumbnail']['name'];

   }catch(Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError($e);
   }

  }

  if(isset($category['category_id']) && $category['category_id'] != ''){

    Hellux_Gallery_Model_Resource_Category::editCategory($category);

  }else{

   Hellux_Gallery_Model_Resource_Category::saveCategory($category);

  }

  $this->_title($this->__('Gallery'))->_title($this->__('Lista kategorii'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/gallery');
  $this->_addContent($this->getLayout()->createBlock('hellux_gallery/adminhtml_category_category'));
  $this->renderLayout();

 }//end sve action

 public function massDeleteAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie zaznaczono kategorii.'));
  } else {
   try {

    $success_array = array();
    $error_array = array();

    foreach ($ids as $id) {

     $success = Hellux_Gallery_Model_Resource_Category::deleteCategory($id);

     if($success != FALSE){
      array_push($success_array, $id);
     }else{
      array_push($error_array, $id);
     }


    }

    if(!empty($success_array)){
     $this->_getSession()->addSuccess(
      $this->__('Usunięto %d kategorii.', count($success_array))
     );
    }

    if(!empty($error_array)){
     $this->_getSession()->addError(
      $this->__('Kategorii w których napotkano problem z usunięciem: %d.', count($error_array))
     );
    }

   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_gallery')->__('Wystąpił błąd podczas usuwania kategorii.')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');

 }//END mass deleteAction

 public function massActivateAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie zaznaczono kategorii.'));
  } else {
   try {

    foreach ($ids as $id) {

     Hellux_Gallery_Model_Resource_Category::changeActive($id, 'on');

    }

    $this->_getSession()->addSuccess(
     $this->__('Zmieniono %d kategorii.', count($ids))
    );

   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_gallery')->__('Wystąpił błąd podczas aktywowania kategorii.')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');

 }//END mass activateAction

 public function massDesactivateAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie zaznaczono kategorii.'));
  } else {
   try {

    foreach ($ids as $id) {

     Hellux_Gallery_Model_Resource_Category::changeActive($id, 'off');

    }

    $this->_getSession()->addSuccess(
     $this->__('Zmieniono %d kategorii.', count($ids))
    );

   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_gallery')->__('Wystąpił błąd podczas dezaktywowania kategorii.')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');

 }//END mass activateAction

 public function massToArchiveAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie zaznaczono kategorii.'));
  } else {
   try {

    foreach ($ids as $id) {

     Hellux_Gallery_Model_Resource_Category::changeArchive($id, 'on');

    }

    $this->_getSession()->addSuccess(
     $this->__('Zmieniono %d kategorii.', count($ids))
    );

   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_gallery')->__('Wystąpił błąd podczas przenoszenia kategorii.')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');

 }//END mass activateAction

 public function massFromArchiveAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie zaznaczono kategorii.'));
  } else {
   try {

    foreach ($ids as $id) {

     Hellux_Gallery_Model_Resource_Category::changeArchive($id, 'off');

    }

    $this->_getSession()->addSuccess(
     $this->__('Zmieniono %d kategorii.', count($ids))
    );

   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_gallery')->__('Wystąpił błąd podczas przywracania kategorii.')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');

 }//END mass activateAction

}//END CLASS