<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// $Id: Email.php 25 2008-01-26 16:00:46Z pedroix $
//

/**
* @package  HTML_BBCodeParser
*/


require_once($Aplic->getClasseBiblioteca('PEAR/HTML/BBCodeParser/Filter'));




class HTML_BBCodeParser_Filter_Email extends HTML_BBCodeParser_Filter
{

    /**
    * An array of tags parsed by the engine
    *
    * @access   private
    * @var      array
    */
    var $_definedTags = array(  'email' => array(   'htmlopen'  => 'a',
                                                    'htmlclose' => 'a',
                                                    'allowed'   => 'none^img',
                                                    'attributes'=> array('email' =>'href=%2$smailto:%1$s%2$s')

                                               )
                              );


    /**
    * Executes statements before the actual array building starts
    *
    * This method should be overwritten in a filter if you want to do
    * something before the parsing process starts. This can be useful to
    * allow certain short alternative tags which then can be converted into
    * proper tags with preg_replace() calls.
    * The main class walks through all the filters and and calls this
    * method if it exists. The filters should modify their private $_text
    * variable.
    *
    * @return   none
    * @access   private
    * @see      $_text
    */
    function _preparse()
    {
        $options = HTML_BBCodeParser_Filter::_getOptions();
        $o = $options['open'];
        $c = $options['close'];
        $oe = $options['open_esc'];
        $ce = $options['close_esc'];
        $padrao = array(   "!(^|\s)([-a-z0-9_.]+@[-a-z0-9.]+\.[a-z]{2,4})!i",
                            "!".$oe."email(".$ce."|\s.*".$ce.")(.*)".$oe."/email".$ce."!Ui");
        $replace = array(   "\\1".$o."email=\\2".$c."\\2".$o."/email".$c,
                            $o."email=\\2\\1\\2".$o."/email".$c);
        $this->_preparsed = preg_replace($padrao, $replace, $this->_text);
    }


}


?>
