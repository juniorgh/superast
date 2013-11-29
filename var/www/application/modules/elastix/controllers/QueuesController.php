<?php

class Elastix_QueuesController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $this->getResponse()->setHeader('Content-Type', 'text/plain');
    }

    public function indexAction() {
        
    }


}

