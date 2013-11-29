<?php

class Superast_Utils_MenuIterator {

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
     * 
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
     * 
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

    public static function getActiveNode($array, $lastChild = false) {
        $active = array();
        foreach($array as $k => $v) {
            if(array_key_exists('menu_active', $array[$k])) {
                $active = $array[$k];
                if(array_key_exists('childs', $array[$k])) {
                    $active['childs'] = self::getActiveNode($array[$k]['childs']);
                }
            } else {
                if(array_key_exists('childs', $array[$k])) {
                    self::getActiveNode($array[$k]['childs']);
                }
            }
        }

        if($lastChild == true) {
            $active = self::getLastActive($active);
        }

        return $active;
    }

    public static function getLastActive($node) {
        if(array_key_exists('childs', $node)) {
            return self::getLastActive($node['childs']);
        } else {
            return $node;
        }
    }

    public static function getPagesTitle($active) {
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