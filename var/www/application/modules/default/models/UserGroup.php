<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `user_group`
 * do banco de dados
 * @package Default
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_Model_UserGroup {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $user_group = new Default_Model_DbTable_UserGroup();
        return $user_group->insert($data);
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
        $user_group = new Default_Model_DbTable_UserGroup();
        if(!is_null($id)) {
            return $user_group->find($id)->current()->toArray();
        } else {
            $query = $user_group->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            if($pager == false) {
                return $user_group->fetchAll($query)->toArray();
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
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_id = ?', $data['user_group_id']);
        unset($data['user_group_id']);
        return $user_group->update($data, $where);
    }

    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_id = ?', $id);
        return $user_group->delete($where);
    }

    /** 
     * Remove registros pela chave estrangeira que referencia a tabela `user`
     * @param  string|integer  $userId Valor da chave estrangeira que referencia a tabela `user`
     * @return integer
     */
    public static function deleteByUser($userId) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_user = ?', $userId);
        return $user_group->delete($where);
    }

    /** 
     * Remove registros pela chave estrangeira que referencia a tabela `group`
     * @param  string|integer  $groupId Valor da chave estrangeira que referencia a tabela `group`
     * @return integer
     */
    public static function deleteByGroup($groupId) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_group = ?', $groupId);
        return $user_group->delete($where);
    }

    /** 
     * Busca os grupos relacionados à um determinado usuário cadastrado na tabela `user`
     * @param  integer|string  $userId Chave primária da tabela `user`
     * @return array                   Result set com os dados encontrados
     */
    public static function readUserGroups($userId) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $query = $user_group->select()->setIntegrityCheck(false)
        ->from(array('ug' => 'user_group'))
        ->join(array('u' => 'user'), 'u.user_id = ug.user_group_user')
        ->join(array('g' => 'group'), 'g.group_id = ug.user_group_group')
        ->where('u.user_id = ?', $userId);

        if(!is_null($where)) {
            foreach($where as $cond) {
                $query->where($cond);
            }
        }

        if(!is_null($order)) {
            $query->order($order);
        }

        return $user_group->fetchAll($query)->toArray();
    }

}

