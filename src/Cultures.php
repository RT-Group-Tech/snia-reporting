<?php
namespace Rtgroup\SniaReporting;

class Cultures extends Data
{
    public function get()
    {
        $collectes=$this->db->selectJoin("formulaire_inputs",array("formulaire_input_id","input"))
            ->selectJoin("collecte_details",array("collecte_detail_id","valeur"))
            ->selectJoin("collectes",array("formulaire_id"))
            ->join("formulaire_inputs","collecte_details","formulaire_input_id")
            ->join("collecte_details","collectes","collecte_id")
            ->joinWhere("collectes","formulaire_id","=",33)
            ->executeJoin();

        $factor=array();
        for($i=count($collectes)-1; $i>=0; $i--)
        {
            $collectes[$i]['input']=$this->formatInput($collectes[$i]['input']);

            $collectes[$i]['valeur']=$this->formatInput($collectes[$i]['valeur']);

            if($this->equals($collectes[$i]['input'],"nom_de_la_spéculation"))
            {
                if(array_key_exists($collectes[$i]['valeur'],$factor))
                {
                    continue;
                }
                //TODO:Rearrange and Cluster data set by culture.
                $culture=array(
                    "menage_agricole"=>$this->getMenageAgricole($collectes[$i]['input'],$collectes), //TODO: Bug on calculating menage agricole.
                    "superficie"=>"-",
                    "rendement"=>"-",
                    "production"=>"",
                    "distribution"=>"",
                    "importation"=>"",
                    "exportation"=>""
                );

                $factor[$collectes[$i]['valeur']]=$culture;
            }

        }

        return $factor;


    }

    private function formatInput($key)
    {
        $input=str_replace(" ","_",$key);

        return $input;
    }

    /**
     * Method pour obtenir le nombre de ménage agricole le plus recent.
     * @param $data
     * @return mixed
     */
    private function getMenageAgricole($culture,$data)
    {
        for($i=0; $i<count($data); $i++)
        {
            $key=$this->formatInput($data[$i]['input']);
            if($key=="nombre_de_ménages_agricoles")
            {
                $menageAgricole=$data[$i]['valeur'];

                return $menageAgricole;

            }
        }

        return "-";
    }

    /**
     * Method pour comparer 2 strings.
     * @param $str1
     * @param $str2
     * @param bool $ignoreCase
     * @return bool
     */
    private function equals($str1,$str2,$ignoreCase=true)
    {
        if($ignoreCase)
        {
            if(strcasecmp($str1,$str2)==0)
            {
                return true;
            }

            return false;
        }
        else
        {
            if(strcmp($str1,$str2)==0)
            {
                return true;
            }

            return false;
        }
    }

}