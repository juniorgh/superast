<?php

/** 
 * Adaptador de acesso à tabela do banco de dados
 * @package Elastix
 * @subpackage Model
 * @category DbTable
 * @see Elastix_Model_Agent
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Elastix_Model_DbTable_Agent extends Zend_Db_Table_Abstract {

    /** 
     * Nome da tabela do banco de dados
     * @var string
     * @access protected
     */
    protected $_name = 'agent';

}