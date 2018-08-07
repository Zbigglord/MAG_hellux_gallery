<?php

 /**
  * Created by Zbigglord.
  * User: BBJaga
  * Date: 2017-04-16
  * Time: 10:45
  */
 class Hellux_Gallery_Block_Adminhtml_Image_Helper extends Varien_Data_Form_Element_Image{
 //make your renderer allow "multiple" attribute
 public function getHtmlAttributes(){
  return array_merge(parent::getHtmlAttributes(), array('multiple'));
 }
}
