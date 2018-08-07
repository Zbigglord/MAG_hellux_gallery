<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Gallery_Block_Adminhtml_Image_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('image_id');
        // $this->setDefaultSort('COLUMN_ID');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

 protected function _prepareCollection()
 {
  $collection = Mage::getModel('hellux_gallery/image')->getCollection();
  //join looks like that: cat is table that i wanna join with, than cat.category_id is where join ON happens, an than columns that i wanna get:
  $collection->getSelect()->join(array('cat' => 'hellux_gallery_category'),
   'cat.category_id = main_table.parent_id', array('category_title'));
  $this->setCollection($collection);
  return parent::_prepareCollection();
 }
	
	    protected function _prepareColumns()
    {

       $this->addColumn('image_id',
           array(
               'header'=> $this->__('ID'),
               'width' => '50px',
               'index' => 'image_id'
           )
       );

     $this->addColumn('category_title',
      array(
       'header'=> $this->__('Kategoria'),
       'width' => '10%',
       'index' => 'category_title'
      )
     );

     $this->addColumn('image_path',
      array(
       'header'=> $this->__('Obrazek'),
       'width' => '10%',
       'index' => 'image_path',
       'align' => 'center',
       'renderer' => 'hellux_gallery_block_adminhtml_image_grid_renderer_image'
      )
     );

     $this->addColumn('image_description',
      array(
       'header'=> $this->__('Opis obrazka'),
       'width' => '40%',
       'index' => 'image_description'
      )
     );

        $this->addColumn('image_title',
         array(
          'header'=> $this->__('Tytuł obrazka(seo)'),
          'width' => '20%',
          'index' => 'image_title'
         )
        );


     $this->addColumn('image_alt',
      array(
       'header'=> $this->__('ALT obrazka(seo)'),
       'width' => '20%',
       'index' => 'image_alt'
      )
     );
        
        return parent::_prepareColumns();
    }



    public function getRowUrl($row)
    {
       return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

        protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('hellux_gallery/category')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        // $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> $this->__('Usuń'),
             'url'  => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
     }

    }//END CLASS
