<?php

namespace RWF\Form\FormElements;

//Imports
use RWF\Form\AbstractFormElement;
use RWF\Util\String;

/**
 * An/Aus Option
 * 
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class OnOffOption extends AbstractFormElement {

    /**
     * Label
     * 
     * @var Array 
     */
    protected $label = array('on' => 'an', 'off' => 'aus');

    /**
     * setzt den Text der fuer An/Aus angezeigt werden soll
     * 
     * @param  String $on  Text fuer An
     * @param  String $off Text fuer Aus
     * @return \RWF\Form\Formelement
     */
    public function setLabel($on, $off) {

        $this->label = array('on' => $on, 'off' => $off);
        return $this;
    }
    
   /**
    * setzt das Label auf An/Aus
    * 
    * @return \RWF\Form\Formelement
    */
    public function setOnOffLabel() {
        
        $this->setLabel('an', 'aus');
        return $this;
    }
    
    /**
    * setzt das Label auf Ja/Nein
    * 
    * @return \RWF\Form\Formelement
    */
    public function setYesNoLabel() {
        
        $this->setLabel('ja', 'nein');
        return $this;
    }
    
    /**
    * setzt das Label auf Aktiv/Inaktiv
    * 
    * @return \RWF\Form\Formelement
    */
    public function setActiveInactiveLabel() {
        
        $this->setLabel('aktiv', 'inaktiv');
        return $this;
    }

    /**
     * gibt die Texte fuer den An und den Aus Button zurueck
     * 
     * @return Array
     */
    public function getLabel() {

        $this->label;
    }

    /**
     * erzeugt das HTML Element fuer die Web View
     * 
     * @return String
     */
    protected function fetchWebView() {

        //Zufaellige ID
        $randomId = String::randomStr(64);
        $this->addId('a' . $randomId);

        //Deaktiviert
        $disabled = '';
        if ($this->isDisabled()) {

            $disabled = ' disabled="disabled" ';
            $this->addClass('disabled');
        }

        //CSS Klassen
        $class = '';
        if (count($this->classes) > 0) {

            $class = ' ' . String::encodeHTML(implode(' ', $this->classes));
        }

        //CSS IDs
        $id = '';
        if (count($this->ids) > 0) {

            $id = ' id="' . String::encodeHTML(implode(' ', $this->ids)) . '" ';
        }

        //HTML Code
        $html = '<div class="rwf-ui-form-content">' . "\n";

        //Titel
        if ($this->getTitle() != '') {

            $html .= '<div class="rwf-ui-form-content-title">' . String::encodeHTML($this->getTitle()) . ($this->isRequiredField() ? ' <span class="rwf-ui-form-content-required">*</span>' : '') . "</div>\n";
        }

        //Formularfeld
        $html .= '<div class="rwf-ui-form-content-element">';
        $html .= '<div ' . $id . ' class="rwf-ui-form-content-on-off-chooser' . $class . '">' . "\n";
        $html .= '<input type="radio" id="a' . $randomId . '_on" name="' . $this->getName() . '" value="1" ' . ($this->getValue() == true ? 'checked="checked"' : '') . $disabled . '/>' . "\n";
        $html .= '<label class="yes" for="a' . $randomId . '_on">' . String::encodeHTML($this->label['on']) . '</label>' . "\n";
        $html .= '<input type="radio" id="a' . $randomId . '_off" name="' . $this->getName() . '" value="0" ' . ($this->getValue() == false ? 'checked="checked"' : '') . $disabled . '/>' . "\n";
        $html .= '<label class="no" for="a' . $randomId . '_off">' . String::encodeHTML($this->label['off']) . '</label>' . "\n";
        $html .= "</div>\n";
        $html .= "</div>\n";

        //Beschreibung
        if ($this->getDescription() != '') {

            $html .= '<div class="rwf-ui-form-content-description">' . String::encodeHTML($this->getDescription()) . '</div>';
        }

        $html .= "</div>\n";

        //JavaScript ueberpruefung
        $html .= "<script type=\"text/javascript\">\n";
        $html .= "
            \$(function() {
                $('#a" . $randomId . "').buttonset();
            });\n";
        $html .= "</script>\n";

        return $html;
    }

    /**
     * erzeugt das HTML Element fuer die Mobile View
     * 
     * @return String
     */
    protected function fetchMobileView() {

        return 'not implemented';
    }

    /**
     * prueft die Eingabedaten auf gueltigkeit
     * 
     * @return Boolean
     */
    public function validate() {

        $valid = true;
        $value = $this->getValue();

        //Pflichtfeld
        if ($this->isRequiredField() && $value == '') {

            $this->messages[] = 'Das Feld ' . String::encodeHTML($this->getTitle()) . ' muss ausgefüllt werden';
            $valid = false;
        }

        //erlaubte Werte Pruefen
        if ($value != 0 && $value != 1) {

            $this->messages[] = 'Ungültige Eingabe für ' . String::encodeHTML($this->getTitle());
            $valid = false;
        }

        if ($valid === false) {

            $this->addClass('rwf-ui-form-content-invalid');
        }
        return $valid;
    }

}
