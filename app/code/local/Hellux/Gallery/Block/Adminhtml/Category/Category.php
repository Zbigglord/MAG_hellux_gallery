<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Gallery_Block_Adminhtml_Category_Category extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct(){
        $this->_blockGroup = 'hellux_gallery';
        $this->_controller = 'adminhtml_category_grid';
        $this->_headerText = Mage::helper('hellux_gallery')->__('Lista categorii');
        $this->_addButton('category_new', array(
        'label' => $this->__('Nowa kategoria'),
        'onclick' => "setLocation('{$this->getUrl('*/category/new')}')",
        ));
        parent::__construct();
    }

    protected function _prepareLayout()//Need to override this function to add remove button otherwise it just does not work
    {
        $this->_removeButton('add');

        return parent::_prepareLayout();
    }

}

