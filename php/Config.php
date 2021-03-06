<?php
/**
 * Define as variaveis de configuração do gerador de certificados
 *
 * @author Tiago Ribas <tgoribas@gmail.com>
 */

class Config{

    public $URL;
    public $FOLDER;
    public $DIR;
    public $fileCSV;

    public function __construct()
    {
        $this->setURL('http://' . $_SERVER['HTTP_HOST'] . '/certificate-generator');
        $this->setDIR($_SERVER['DOCUMENT_ROOT'] . '/certificate-generator');
        $this->setFOLDER('certificate');
        $this->setFileCSV('certificados.csv');
    }

    /**
     * Set the value of URL
     *
     * @return  self
     */ 
    public function setURL($URL)
    {
        $this->URL = $URL;

        return $this;
    }

    /**
     * Get the value of URL
     */ 
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * Get the value of fileCSV
     */ 
    public function getFileCSV()
    {
        return $this->fileCSV;
    }

    /**
     * Set the value of fileCSV
     *
     * @return  self
     */ 
    public function setFileCSV($fileCSV)
    {
        $this->fileCSV = $fileCSV;

        return $this;
    }

    /**
     * Get the value of FOLDER
     */ 
    public function getFOLDER()
    {
        return $this->FOLDER;
    }

    /**
     * Set the value of FOLDER
     *
     * @return  self
     */ 
    public function setFOLDER($FOLDER)
    {
        $this->FOLDER = $FOLDER;

        return $this;
    }

    /**
     * Get the value of DIR
     */ 
    public function getDIR()
    {
        return $this->DIR;
    }

    /**
     * Set the value of DIR
     *
     * @return  self
     */ 
    public function setDIR($DIR)
    {
        $this->DIR = $DIR;

        return $this;
    }
}