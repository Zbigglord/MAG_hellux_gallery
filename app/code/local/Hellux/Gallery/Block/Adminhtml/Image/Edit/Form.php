<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Gallery_Block_Adminhtml_Image_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

 protected function _prepareForm()
 {

  $id = $this->getRequest()->getParam('id');
  $is_multiple = $this->getRequest()->getParam('multiple');
  if(isset($id) && $id != ''){

   $images = Hellux_Gallery_Model_Resource_Image::getImageData($id);
   foreach($images as $item){
    $image_id = $item['image_id'];
    $category = $item['parent_id'];
    $image_description = $item['image_description'];
    $image_title = $item['image_title'];
    $image_alt = $item['image_alt'];
   }

  }else{

   $image_id = '';
   $category = '';
   $image_description = '';
   $image_title = '';
   $image_alt = '';

  }

  $form   = new Varien_Data_Form(array(
   'id'        => 'edit_form',
   'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
   'method'    => 'post',
   'enctype' => 'multipart/form-data'
  ));



  if(isset($id) && $id != ''){

   $fieldset   = $form->addFieldset('base_fieldset', array(
    'legend'    => Mage::helper('hellux_gallery')->__("Edytuj obrazek"),
    'class'     => 'fieldset-wide',
   ));

  }else{

   $fieldset   = $form->addFieldset('base_fieldset', array(
    'legend'    => Mage::helper('hellux_gallery')->__("Dodaj obrazek(ki)"),
    'class'     => 'fieldset-wide',
   ));

  }


  if(isset($is_multiple) && $is_multiple != 0){

   $fieldset->addField('parent_id', 'select', array(
    'label'     => Mage::helper('hellux_gallery')->__('Kategoria obrazków: '),
    'required'  => true,
    'name'      => 'parent_id',
    'values' => Hellux_Gallery_Model_Resource_Category::toOptionArray()
   ));

   $fieldset->addType('file', Mage::getConfig()->getBlockClassName('hellux_gallery/adminhtml_image_helper'));
   $fieldset->addField('image_path', 'file', array(
    'label'     => Mage::helper('hellux_gallery')->__('Dodaj obrazki'),
    'multiple'  => 'multiple',
    'required'  => true,
    'name'      => 'image_path[]',
    'value'     => ''
   ));


  }else{

   if(isset($id) && $id != ''){//single edit

    $fieldset->addField('image_id', 'hidden', array(
     'name'      => 'image_id',
     'required'  => false,
     'value'     => $id
    ));

    $fieldset->addField('parent_id', 'select', array(
     'label'     => Mage::helper('hellux_gallery')->__('Kategoria obrazków: '),
     'required'  => true,
     'name'      => 'parent_id',
     'value' => $category,
     'values' => Hellux_Gallery_Model_Resource_Category::toOptionArray(),
    ));

    $fieldset->addField('image_path', 'file', array(
     'label'     => Mage::helper('hellux_gallery')->__('Zmień obrazek(zostaw puste aby nie zmieniać)'),
     'required'  => false,
     'name'      => 'image_path',
     'value'     => ''
    ));

    $fieldset->addField('image_title', 'text', array(
     'name'      => 'image_title',
     'label'     => Mage::helper('hellux_gallery')->__('Tytuł obrazka (seo)'),
     'required'  => false,
     'value'     => $image_title
    ));

    $fieldset->addField('image_alt', 'text', array(
     'name'      => 'image_alt',
     'label'     => Mage::helper('hellux_gallery')->__('ALT obrazka (seo)'),
     'required'  => false,
     'value'     => $image_alt
    ));

    $fieldset->addField('image_description', 'text', array(
     'name'      => 'image_description',
     'label'     => Mage::helper('hellux_gallery')->__('Opis obrazka'),
     'title'     => Mage::helper('hellux_gallery')->__('Opis obrazka (max 255 znaków)'),
     'required'  => false,
     'value'     => $image_description
    ));

   }else{//add single

    $fieldset->addField('parent_id', 'select', array(
     'label'     => Mage::helper('hellux_gallery')->__('Kategoria obrazków: '),
     'required'  => true,
     'name'      => 'parent_id',
     'value'     => '',
     'values' => Hellux_Gallery_Model_Resource_Category::toOptionArray()
    ));

    $fieldset->addField('image_path', 'file', array(
     'label'     => Mage::helper('hellux_gallery')->__('Dodaj obrazek'),
     'required'  => true,
     'name'      => 'image_path',
     'value'     => ''
    ));

    $fieldset->addField('image_title', 'text', array(
     'name'      => 'image_title',
     'label'     => Mage::helper('hellux_gallery')->__('Tytuł obrazka (seo)'),
     'required'  => false,
     'value'     => ''
    ));

    $fieldset->addField('image_alt', 'text', array(
     'name'      => 'image_alt',
     'label'     => Mage::helper('hellux_gallery')->__('ALT obrazka (seo)'),
     'required'  => false,
     'value'     => ''
    ));

    $fieldset->addField('image_description', 'text', array(
     'name'      => 'image_description',
     'label'     => Mage::helper('hellux_gallery')->__('Opis obrazka'),
     'title'     => Mage::helper('hellux_gallery')->__('Opis obrazka (max 255 znaków)'),
     'required'  => false,
     'value'     => ''
    ));

   }

  }

  $form->setUseContainer(true);
  $this->setForm($form);

  return parent::_prepareForm();
 }

}
