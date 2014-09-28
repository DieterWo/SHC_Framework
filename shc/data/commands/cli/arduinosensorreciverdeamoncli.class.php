<?php

namespace SHC\Command\CLI;

//Imports
use RWF\Request\Commands\CliCommand;
use SHC\Arduino\ArduinoSensorReciver;
use SHC\Core\SHC;

/**
 * Sensordaten vom Arduino Lesen
 * 
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class ArduinoSensorReciverDeamonCli extends CliCommand {

    /**
     * kurzer Kommandozeilen Parameter
     * 
     * @var String 
     */
    protected $shortParam = '-ar';

    /**
     * voller Kommandozeilen Parameter
     * 
     * @var String 
     */
    protected $fullParam = '--arduinoreciver';

    /**
     * Debug Modus aktiv
     * 
     * @var Boolean 
     */
    protected $debug = false;

    /**
     * gibt die Hilfe zu der Kommandozeilen Funktion auf die Kommandozeile aus
     */
    public function writeHelp() {
        
    }

    /**
     * konfiguriert das CLI Kommando
     */
    protected function config() {
        
    }

    /**
     * fuehrt das CLI Kommando aus
     */
    protected function executeCliCommand() {

        global $argv;
        
        //Debug aktivieren
        if (in_array('-d', $argv) || in_array('--debug', $argv)) {

            $this->debug = true;
        }
        
        //Sprache einbinden
        SHC::getLanguage()->loadModul('ArduinoReciver');

        //pruefen on Server aktiviert
        if (!SHC::getSetting('shc.arduinoReciver.active')) {

            throw new Exception('Der Arduino Reciver wurde deaktiviert', 1600);
        }
        
        $arduinoReciver = new ArduinoSensorReciver(SHC::getSetting('shc.arduinoReciver.interface'), SHC::getSetting('shc.arduinoReciver.baudRate'));
        $arduinoReciver->readDataEndless($this->debug);
        $arduinoReciver->close();
    }

}