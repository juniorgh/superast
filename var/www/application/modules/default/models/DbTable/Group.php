<?php

/** 
 * Adaptador de acesso à tabela do banco de dados
 * @package Default
 * @subpackage Model
 * @category DbTable
 * @see Default_Model_Group
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_Model_DbTable_Group extends Zend_Db_Table_Abstract {

    /** 
     * Nome da tabela do banco de dados
     * @var string
     * @access protected
     */
    protected $_name = 'group';

}