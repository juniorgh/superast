<?php

/** 
 * Objeto de iteração dos menus do sistema
 * @package Superast
 * @subpackage Utils
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Superast_Utils_MenuIterator {

    /** 
     * Retorna o nome do menu trazendo toda os seus menus superiores numa unica string
     * @param  array $menus Menus parar serem tratados
     * @return array        Nome dos menus formatados
     */
    public static function parseHierarchyNames($menus) {
        $names = array();
        foreach($menus as $k => $v) {
            $id = $menus[$k]['menu_id'];
            $name = $menus[$k]['menu_name'];
            $names[$id] = $name;

            if(array_key_exists('childs', $menus[$k])) {
                foreach($menus[$k]['childs'] as $i => $j) {
                    $id = $menus[$k]['childs'][$i]['menu_id'];
                    $name = sprintf('%s > %s', $menus[$k]['menu_name'], $menus[$k]['childs'][$i]['menu_name']);
                    $names[$id] = $name;

                    if(array_key_exists('childs', $menus[$k]['childs'][$i])) {
                        foreach($menus[$k]['childs'][$i]['childs'] as $x => $y) {
                            $id = $menus[$k]['childs'][$i]['childs'][$x]['menu_id'];
                            $name = sprintf('%s > %s > %s', $menus[$k]['menu_name'], $menus[$k]['childs'][$i]['menu_name'], $menus[$k]['childs'][$i]['childs'][$x]['menu_name']);
                            $names[$id] = $name;
                        }
                    }
                }
            }
        }

        return $names;
    }

    /** 
     * Encontra e define a flag de menu ativo para a página ativa.
     * @param  array  $array      Array com os menus para localização da página ativa
     * @param  string $module     Nome do module ativo
     * @param  string $controller Nome da controller ativa
     * @return array              Array com o menu ativo definido
     */
    public static function findActive($array, $module, $controller) {
        if(count($array) > 0) {
            foreach($array as $k => $v) {
                if(array_key_exists('childs', $v)) {
                    $array[$k]['childs'] = self::findActive($v['childs'], $module, $controller);
                } else {
                    if($v['menu_module'] == $module && $v['menu_controller'] == $controller) {
                        $array[$k]['menu_active'] = 1;
                    }
                }
            }

        }
        return $array;
    }

    /** 
     * Define a flag de menu ativo para toda a árvore ativa.
     * @param  array $array Lista de menus para verificação
     * @return array        Árvore com o menu e as flags definidas
     */
    public static function makeActiveHierarchy($array) {
        if(count($array) > 0) {
            foreach($array as $k => $v) {
                if(array_key_exists('menu_active', $array[$k])) {
                    return $array;
                } else {
                    if(array_key_exists('childs', $array[$k])) {
                        foreach($array[$k]['childs'] as $i => $j) {
                            if(array_key_exists('menu_active', $array[$k]['childs'][$i])) {
                                $array[$k]['menu_active'] = 1;
                            } else {
                                if(array_key_exists('childs', $array[$k]['childs'][$i])) {
                                    foreach($array[$k]['childs'][$i]['childs'] as $x => $y) {
                                        if(array_key_exists('menu_active', $array[$k]['childs'][$i]['childs'][$x])) {
                                            $array[$k]['childs'][$i]['menu_active'] = 1;
                                            $array[$k]['menu_active'] = 1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return $array;
        } else {
            return array();
        }
    }

    /** 
     * Obtém o nó completo do menu atualmente ativo
     * @param  array   $menus     Array com os menus para verificação
     * @param  boolean $lastChild Define se deseja apenas o último menu ou o nó completo
     * @return array              Array com o nó completo do menu ativo
     */
    public static function getActiveNode(array $menus, $lastChild = false) {
        $active = array();
        foreach($menus as $k => $v) {
            if(array_key_exists('menu_active', $menus[$k])) {
                $active = $menus[$k];
                if(array_key_exists('childs', $menus[$k])) {
                    $active['childs'] = self::getActiveNode($menus[$k]['childs']);
                }
            } else {
                if(array_key_exists('childs', $menus[$k])) {
                    self::getActiveNode($menus[$k]['childs']);
                }
            }
        }

        if($lastChild == true) {
            $active = self::getLastActive($active);
        }

        return $active;
    }

    /** 
     * Obtém o menu ativo pelo nó completo
     * @param  array $node Nó completo do menu desejado
     * @return array       Último menu ativo do nó
     */
    public static function getLastActive(array $node) {
        if(array_key_exists('childs', $node)) {
            return self::getLastActive($node['childs']);
        } else {
            return $node;
        }
    }

    /** 
     * Constrói um array com o título da página de toda o nó do menu ativo
     * @param  array $active Nó completo do menu ativo
     * @return array         Lista com os títulos do nó do menu ativo
     */
    public static function getPagesTitle(array $active) {
        if(count($active) > 0) {
            $names = array();
            $names[] = !empty($active['menu_page_title']) ? $active['menu_page_title'] : $active['menu_name'];
            if(array_key_exists('childs', $active)) {
                $names[] = !empty($active['childs']['menu_page_title']) ? $active['childs']['menu_page_title'] : $active['childs']['menu_name'];
                if(array_key_exists('childs', $active['childs'])) {
                    $names[] = !empty($active['childs']['childs']['menu_page_title']) ? $active['childs']['childs']['menu_page_title'] : $active['childs']['childs']['menu_name'];
                }
            }

            $first = array_shift($names);
            if(count($names) > 0) {
                $last = array_pop($names);
                unset($names);
                $names = array($first, $last);
            } else {
                $names = array($first);
            }

            return $names;
        } else {
            return $active;
        }
    }

}