<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Gallery_Block_Adminhtml_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareForm()
    {

     $id = $this->getRequest()->getParam('id');
     if(isset($id) && $id != ''){

      $category = Hellux_Gallery_Model_Resource_Category::getCategoryById($id);

      foreach($category as $item){

       $category_id = $item['category_id'];
       $title = $item['category_title'];
       $description = $item['category_description'];
       $is_active = $item['category_is_active'];
       $is_archive = $item['category_archive'];

      }

     }else{

      $category_id = '';
      $title = '';
      $description = '';
      $is_active = '';
      $is_archive = '';

     }



        $form   = new Varien_Data_Form(array(
         'id'        => 'edit_form',
         'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
         'method'    => 'post',
         'enctype' => 'multipart/form-data'
        ));

      if(isset($id) && $id != ''){

       $fieldset   = $form->addFieldset('base_fieldset', array(
        'legend'    => Mage::helper('hellux_gallery')->__("Edytuj kategorię"),
        'class'     => 'fieldset-wide',
       ));

      }else{

       $fieldset   = $form->addFieldset('base_fieldset', array(
        'legend'    => Mage::helper('hellux_gallery')->__("Dodaj kategorię"),
        'class'     => 'fieldset-wide',
       ));

      }

     if(isset($id) && $id != ''){

      $fieldset->addField('category_id', 'hidden', array(
       'name'      => 'category_id',
       'required'  => false,
       'value'     => $id
      ));

     }


        $fieldset->addField('category_title', 'text', array(
         'name'      => 'category_title',
         'label'     => Mage::helper('hellux_gallery')->__('Nazwa kategorii'),
         'title'     => Mage::helper('hellux_gallery')->__('Nazwa kategorii'),
         'required'  => true,
         'value'     => $title
        ));

     if(isset($id) && $id != ''){

      $fieldset->addField('category_thumbnail', 'file', array(
       'label'     => Mage::helper('hellux_gallery')->__('Obrazek (zostaw puste aby nie zmieniać)'),
       'required'  => false,
       'name'      => 'category_thumbnail',
       'value'     => ''
      ));

     }else{

      $fieldset->addField('category_thumbnail', 'file', array(
       'label'     => Mage::helper('hellux_gallery')->__('Obrazek'),
       'required'  => false,
       'name'      => 'category_thumbnail',
       'value'     => ''
      ));

     }

     $fieldset->addField('category_description', 'textarea', array(
      'name'      => 'category_description',
      'label'     => Mage::helper('hellux_gallery')->__('Krótki opis(opcjonalnie)'),
      'title'     => Mage::helper('hellux_gallery')->__('Opis będzie wykorzystany pod obrazkiem kategorii w liście'),
      'required'  => false,
      'value'     => $description
     ));

     $fieldset->addField('category_is_active', 'select', array(
      'label'     => Mage::helper('hellux_gallery')->__('Aktywna'),
      'required'  => true,
      'name'      => 'category_is_active',
      'value'  => $is_active,
      'values' => array('0' => 'Aktywna','1' => 'Wyłączona'),
      'disabled' => false,
      'readonly' => false,
      'tabindex' => 1
     ));

     $fieldset->addField('category_archive', 'select', array(
      'label'     => Mage::helper('hellux_gallery')->__('Przenieś do archiwum'),
      'required'  => true,
      'name'      => 'category_archive',
      'value'  => $is_archive,
      'values' => array('0' => 'Nie','1' => 'Tak'),
      'disabled' => false,
      'readonly' => false,
      'tabindex' => 1
     ));


        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
