<?php


class Data
{
    protected $db;

    private array $data=[];

    public function __construct($db)
    {
        $this->db=$db;
    }

    /**
     * Method pour recuperer toutes les données relatives à chaque culture.
     */
    public function getCultures()
    {
        $cultures=$this->db->get("cultures",array("culture_status"=>"actif"));

        for($i=0; $i<count($cultures); $i++)
        {

        }

        $this->data['cultures']=$cultures;
    }
}