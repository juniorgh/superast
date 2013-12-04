<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `group`
 * do banco de dados
 * @package Default
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_Model_Group {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $group = new Default_Model_DbTable_Group();
        return $group->insert($data);
    }
    
    /** 
     * Busca um ou mais registros no banco de dados pela chave primária ou pelos parâmetros passados utilizados nas cláusulas SQL
     * @param  integer                    $id    Valor da chave primária do registro desejado
     * @param  boolean                    $pager Define se a consulta é destinada ao Zend_Paginator
     * @param  array                      $where Condicionais booleanas para preencher as cláusulas WHERE e AND para a consulta
     * @param  array                      $order Campos para preencher a cláusula ORDER BY 
     * @return array|Zend_Db_Table_Select        Se $pager for FALSE retorna um array com o result set. Caso contrário, retorna um
     *                                           objeto do tipo Zend_Db_Table_Select para ser executado pelo Zend_Paginator
     */
    public static function read($id = null, $pager = false, array $where = null, array $order = null) {
        $group = new Default_Model_DbTable_Group();
        if(!is_null($id)) {
            return $group->find($id)->current()->toArray();
        } else {
            $query = $group->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('group_name');
            }

            if($pager == false) {
                return $group->fetchAll($query);
            } else {
                return $query;
            }
        }
    }

    /** 
     * Atualiza um registro na tabela
     * @param  array   $data Dados que serão atualizados na tabela
     * @return integer
     */
    public static function update(array $data) {
        $group = new Default_Model_DbTable_Group();
        $where = $group->getAdapter()->quoteInto('group_id = ?', $data['group_id']);
        unset($data['group_id']);
        return $group->update($data, $where);
    }

    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $group = new Default_Model_DbTable_Group();
        $where = $group->getAdapter()->quoteInto('group_id = ?', $id);
        return $group->delete($where);
    }

}

