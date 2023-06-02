<?php


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

        $factor=[];
        for($i=count($collectes)-1; $i>=0; $i--)
        {
            $collectes[$i]['input']=str_replace(" ","_",$collectes[$i]['input']);
            $collectes[$i]['input']=strtolower($collectes[$i]['input']);
            $collectes[$i]['valeur']=str_replace(" ","_",$collectes[$i]['valeur']);
            $collectes[$i]['valeur']=strtolower($collectes[$i]['valeur']);

            if($collectes[$i]['input']=="nom_de_la_spéculation")
            {
                if(array_key_exists($collectes[$i]['valeur'],$factor))
                {
                    continue;
                }

                $culture=array(
                    "menage_agricole"=>$this->getMenageAgricole($collectes[$i]),
                    "superficie"=>"0Ha",
                    "rendement"=>"",
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

    /**
     * Method pour obtenir le nombre de ménage agricole le plus recent.
     * @param $data
     * @return mixed
     */
    private function getMenageAgricole($data)
    {
        foreach($data as $key=>$val)
        {
            if($key=="nombre_de_ménages_agricoles")
            {
                return $val;
            }
        }
    }

}