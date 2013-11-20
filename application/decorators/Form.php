<?php
/**
 * Formulário padrão decorado da aplicação.
 * 
 * @package Application
 * @category Decorator
 * @author William D. Urbano <contato@williamurbano.com.br>
 */
class Application_Decorator_Form extends Zend_Form {

    /**
     * Método construtor do formulário.
     * Cria um formulário e define as opções padrões para a decoração do formulário
     *
     * @param array $options
     * @return void
     */
    public function __construct(array $options = null) {
        parent::__construct($options);
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'ui form segment')),
            'Form',
        ));


        // $this->setDecorators(array(array('viewScript', array('viewScript' => '_form.phtml'))));

        // $decorator = new Application_Decorator_Element();
        // $this->setElementDecorators(array($decorator));
        $this->setElementDecorators(
            array(
                array('ViewScript',
                    array(
                        'viewScript'=>'_elements.phtml'
                        ),
                    )
                )
            );
    }

}