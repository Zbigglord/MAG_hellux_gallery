<?php
 /**
  * Created by Hellux.
  * User: Zbigglord
  * Date: 2017-01-26
  * Time: 15:41
  */
 /* @var $installer Mage_Core_Model_Resource_Setup */
 $installer = $this;

 $installer->startSetup();

//Hellux hellux_gallery/category

 $tableName = $installer->getTable('hellux_gallery/category');
 if ($installer->getConnection()->isTableExists($tableName) !=  TRUE){

  $table = $installer->getConnection()
   ->newTable($tableName)
   ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
    array(
     'identity' => true,
     'unsigned' => true,
     'nullable' => false,
     'primary' => true,
    ),
    'Category Id'
   )
   ->addColumn('category_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Tytuł kategorii'
   )
   ->addColumn('category_thumbnail', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Ścieżka do pliku thumbnail'
   )
   ->addColumn('category_description', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Krótki opis kategorii (dla listy)'
   )

   ->addColumn('category_added_date', Varien_Db_Ddl_Table::TYPE_DATE,
    null,
    array(),
    'Data dodania'
   )
  ->addColumn('category_edited_date', Varien_Db_Ddl_Table::TYPE_DATE,
   null,
   array(),
   'Data edycji'
  )
  ->addColumn('category_is_active', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
   array(),
   'Aktywna (tak/nie)'
  )
  
    ->addColumn('category_archive', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
   array(),
   'Archiwum (tak/nie)'
  );

  $installer->getConnection()->createTable($table);

 }//END hellux_gallery/category
 
 //Hellux hellux_gallery/image

 $tableName = $installer->getTable('hellux_gallery/image');
 if ($installer->getConnection()->isTableExists($tableName) !=  TRUE){

  $table = $installer->getConnection()
   ->newTable($tableName)
   ->addColumn('image_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
    array(
     'identity' => true,
     'unsigned' => true,
     'nullable' => false,
     'primary' => true,
    ),
    'Obrazek Id'
   )
   ->addColumn('parent_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Kategoria'
   )
   ->addColumn('image_path', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Ścieżka do pliku'
   )
   ->addColumn('image_description', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Krótki opis (dla listy)'
   )

   ->addColumn('image_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Tytuł'
   )

  ->addColumn('image_alt', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
   array(),
   'Alt'
  );

  $installer->getConnection()->createTable($table);

 }//END hellux_gallery/image


 $installer->endSetup();