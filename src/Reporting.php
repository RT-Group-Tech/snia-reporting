<?php
namespace Rtgroup\SniaReporting;



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
        $this->prepareData();

        return $this->data;

    }

    /**
     * Method pour preparer les données
     */
    private function prepareData()
    {
        /**
         * Cultures data.
         */
        $cultures=new Cultures($this->db);
        $this->data['cultures']=$cultures->get();
    }

}