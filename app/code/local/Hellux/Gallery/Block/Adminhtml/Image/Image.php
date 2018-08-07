<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Gallery_Block_Adminhtml_Image_Image extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct(){
        $this->_blockGroup = 'hellux_gallery';
        $this->_controller = 'adminhtml_image_grid';
        $this->_headerText = Mage::helper('hellux_gallery')->__('Lista obrazków');
        $this->_addButton('image_new_single', array(
        'label' => $this->__('Dodaj obrazek(pojedynczy)'),
        'onclick' => "setLocation('{$this->getUrl('*/image/addsingle')}')",
        ));
        $this->_addButton('image_new_multiple', array(
        'label' => $this->__('Dodaj obrazki'),
        'onclick' => "setLocation('{$this->getUrl('*/image/addmultiple')}')",
        ));

        parent::__construct();
    }

    protected function _prepareLayout()//Need to override this function to add remove button otherwise it just does not work
    {
        $this->_removeButton('add');

        return parent::_prepareLayout();
    }

}//end class

