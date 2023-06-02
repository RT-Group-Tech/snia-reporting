<?php
namespace Rtgroup\SniaReporting;

use Cultures;

class Reporting
{
    private $db;

    private $data=[];

    public function __construct($db)
    {
        $this->db=$db;
    }

    /**
     * Generer le rapport.
     */
    public function generate()
    {
        $this->prepapreData();

        echo "result:\n";
        print_r($this->data);

    }

    /**
     * Method pour preparer les données
     */
    private function prepapreData()
    {
        /**
         * Cultures data.
         */
        require_once "./data/Cultures.php";
        $cultures=new Cultures($this->db);
        $this->data['cultures']=$cultures->get();
    }

}