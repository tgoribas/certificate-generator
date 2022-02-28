<?php
/**
 * Classe com as funções do gerador de certificados
 *
 * @author Tiago Ribas <tgoribas@gmail.com>
 */

session_start();
require_once 'Config.php';

class Certificate{

    public $dados = array();
    public $totalRow;

    /**
     * Metodo para criar um Array com as informações do CSV
     *
     * @param string $fileCSV
     * @return boolean
     */
    public function getCertificate($fileCSV) {

        $rows = 0;
        if (($handle = fopen($fileCSV, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($rows > 0){

                    $this->dados[$rows]['name'] = $data['0'];
                    $this->dados[$rows]['nameSlug']    = $this->slugify($data['0']).$this->slugify($data['4']);
                    $this->dados[$rows]['doc']         = $data['1'];
                    $this->dados[$rows]['date']        = $data['2'];
                    $this->dados[$rows]['gender']      = $data['3'];
                    $this->dados[$rows]['course']      = $data['4'];
                    $this->dados[$rows]['workload']    = $data['5'];

                    $exYear = explode('/', $data['6']);
                    $this->dados[$rows]['startMonth'] = $this->dateToMonth($data['6']);
                    $this->dados[$rows]['startYear']  = $exYear[count($exYear)-1];

                    $exYear = explode('/', $data['7']);
                    $this->dados[$rows]['endMonth'] = $this->dateToMonth($data['7']);
                    $this->dados[$rows]['endYear']  = $exYear[count($exYear)-1];
                }
                $rows++;
            }
            fclose($handle);
        }

        $this->setTotalRow($rows);

        return true;
    }

    /**
     * Metodo responsavel por retornar o nome do mes em português
     *
     * @param string $date
     * @return void
     */
    public static function dateToMonth($date)
    {

        // Formata a data para apresentação do nome do mês em pt_BR
        $formatter = new \IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN
        );
        $formatter->setPattern('MMMM');

        // Explode a data
        $explode = explode('/', $date);
        // Verifica se a data está no formatdo dd/mm/yyyy ou mm/yyyy
        if (count($explode) == 2) {
            $dateObj = DateTime::createFromFormat('d-m', "15-" . $explode[0]);
            return $formatter->format($dateObj);
        } elseif (count($explode) == 3) {
            $dateObj = DateTime::createFromFormat('d-m', "15-" . $explode);
            return $dateObj->format('F');
        }
        return 'ERROR';
    }

    /**
     * Metodo responsavel por fazer o slug de uma string
     *
     * @param string $text
     * @param string $divider
     * @return string
     */
    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }


    /**
     * Metodo responavel por criar um array com os nomes dos arquivos que será usado no Javascript
     *
     * @return string
     */
    public function arrayJavascript()
    {
        // Cria Array para ser usado no Javascript
        $fileName = '';
        foreach ($this->dados as $dado) {
            $fileName .= '"' . $dado['nameSlug'] . '",';
        }
        return '[' . substr($fileName, 0, -1) . "]";
    }

    /**
     * Metodo responsavel por deletar as imagens usadas para gerar o PDF.
     *
     * @return void
     */
    public function delImage()
    {
        $config = new Config();
        foreach ($this->dados as $dado) {
            $filedir = $config->getFOLDER() . '/certificate/' . $_SESSION['newFolder'] ;
            $filePath = $filedir . "/" . $dado['nameSlug'] . ".png" ;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        return true;
    }

    /**
     * Get the value of totalRow
     */ 
    public function getTotalRow()
    {
        return $this->totalRow;
    }

    /**
     * Set the value of totalRow
     *
     * @return  self
     */ 
    public function setTotalRow($totalRow)
    {
        $this->totalRow = $totalRow;

        return $this;
    }
}