<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_Gallery_Block_Adminhtml_Category_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('id');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

 protected function _prepareCollection()
 {
  $collection = Mage::getModel('hellux_gallery/category')->getCollection();
  foreach($collection as $item){

   if($item['category_archive'] == '0'){

    $item['category_archive'] = 'NIE';

   }else{

    $item['category_archive'] = 'TAK';

   }

   if($item['category_is_active'] == '0'){

    $item['category_is_active'] = 'TAK';

   }else{

    $item['category_is_active'] = 'NIE';

   }

  }
  $this->setCollection($collection);
  return parent::_prepareCollection();
 }


    protected function _prepareColumns()
    {

       $this->addColumn('category_id',
           array(
               'header'=> $this->__('ID'),
               'width' => '50px',
               'index' => 'category_id'
           )
       );

     $this->addColumn('category_thumbnail',
      array(
       'header'=> $this->__('Obrazek kategorii'),
       'width' => '10%',
       'index' => 'category_thumbnail',
       'align' => 'center',
       'renderer' => 'hellux_gallery_block_adminhtml_category_grid_renderer_image'
      )
     );
        $this->addColumn('category_title',
         array(
          'header'=> $this->__('Nazwa kategorii'),
          'width' => '20%',
          'index' => 'category_title'
         )
        );

     $this->addColumn('category_description',
      array(
       'header'=> $this->__('Opis kategorii'),
       'width' => '20%',
       'index' => 'category_description'
      )
     );

     $this->addColumn('category_added_date',
      array(
       'header'=> $this->__('Data dodania'),
       'width' => '80px',
       'align' => 'center',
       'index' => 'category_added_date'
      )
     );

     $this->addColumn('category_edited_date',
      array(
       'header'=> $this->__('Data edycji'),
       'width' => '80px',
       'align' => 'center',
       'index' => 'category_edited_date'
      )
     );

     $this->addColumn('category_is_active',
      array(
       'header'=> $this->__('Aktywna'),
       'width' => '80px',
       'align' => 'center',
       'index' => 'category_is_active'
      )
     );

     $this->addColumn('category_archive',
      array(
       'header'=> $this->__('Archiwum'),
       'width' => '80px',
       'align' => 'center',
       'index' => 'category_archive'
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
        //$this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> $this->__('Usuń'),
             'url'  => $this->getUrl('*/*/massDelete'),
        ));

     $this->getMassactionBlock()->addItem('switch_on', array(
      'label'=> $this->__('Aktywuj'),
      'url'  => $this->getUrl('*/*/massActivate'),
     ));

     $this->getMassactionBlock()->addItem('switch_off', array(
      'label'=> $this->__('Dezaktywuj'),
      'url'  => $this->getUrl('*/*/massDesactivate'),
     ));

     $this->getMassactionBlock()->addItem('to_archive', array(
      'label'=> $this->__('Przenieś do archiwum'),
      'url'  => $this->getUrl('*/*/massToArchive'),
     ));

     $this->getMassactionBlock()->addItem('from_archive', array(
      'label'=> $this->__('Przywróć z archiwum'),
      'url'  => $this->getUrl('*/*/massFromArchive'),
     ));
        return $this;
    }
    }
