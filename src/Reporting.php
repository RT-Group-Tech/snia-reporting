<?php
namespace Rtgroup\SniaReporting;



use ChrisTenday\PdfGenerate\Pdf;


class Reporting
{
    private $db;

    private $dataSet=[];

    private $templatePath;
    private $destinationPath;

    public function __construct($db,$templatePath="",$destinationPath="")
    {
        $this->db=$db;
        $this->templatePath=$templatePath;
        $this->destinationPath=$destinationPath;
    }

    /**
     * Generer le rapport.
     */
    public function generate()
    {
        $this->prepareData();


        $pdf=new Pdf($this->templatePath);
        $pdf->setDestinationFolder($this->destinationPath);
        $pdf->setData("province","Nord-Kivu");
        $pdf->setData("populationTotale","-");
        $pdf->setData("cultureCategorie","Vivrière");

        $culturesData=$this->dataSet['cultures'];
        //print_r($this->dataSet); exit();
        foreach($culturesData as $dataTitle =>$data)
        {
            $block=$pdf->newBlock("table");
            $block->setData("culture",str_replace("_"," ",$dataTitle));
            $block->setData("menage",$data['menage_agricole']);
            $block->setData("superficie",$data['superficie']);
            $block->setData("rendement",$data['rendement']);
            $block->setData("production",$data['production']);
            $block->setData("distribution",$data['distribution']);
            $block->setData("importation",$data['importation']);
            $block->setData("exportation",$data['exportation']);
        }

        return $pdf->generate();

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
        $this->dataSet['cultures']=$cultures->get();

    }

}