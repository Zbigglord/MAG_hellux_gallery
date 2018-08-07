<?php

 /**
  * Created by Zbigglord.
  * Date: 2017-04-14
  * Time: 11:31
  */
 class Hellux_Gallery_IndexController extends Mage_Core_Controller_Front_Action
 {

  public function indexAction()//default action for index
  {
   $this->loadLayout();
   $this->renderLayout();
  }

 }