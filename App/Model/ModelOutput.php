<?php

namespace App\Model;

class ModelOutput{
    
    private static function make($datas){
        return new ModelOutput($datas);
    }

    public static function makeOne(array $datas){
        if(empty($datas))
            return ModelOutput::make([]);
        return ModelOutput::makeAll($datas)[0];
    }

    public static function makeAll(array $datas){
        $tempArray = [];

        
        foreach($datas as $data){
            $contain = false;
            foreach($tempArray as $tempKey => $tempValue){
                
                if($data['id'] === $tempValue['id']){
                    $contain = true;

                    foreach($data as $dataKey => $dataValue){
                        
                        if(!isset($tempValue[$dataKey])){
                            $tempArray[$tempKey][$dataKey] = $dataValue;
                        }else if($tempValue[$dataKey] != $dataValue && !is_array($tempValue[$dataKey])){
                            $tempArray[$tempKey][$dataKey] = [$tempValue[$dataKey], $dataValue];
                        }else if($tempValue[$dataKey] != $data[$dataKey]){
                            $tempArray[$tempKey][$dataKey][] = $data[$dataKey];
                        }
                        
                    }

                }
                
            }

            if(!$contain){
                $tempArray[] = $data;
            }
            
        }
        
        $result = [];
        foreach($tempArray as $tempValue){
            $result[] = ModelOutput::make($tempValue);
        }

        return $result;

    }

    public function __construct(array $datas){

        foreach($datas as $key=>$data){
            $this->$key = $data;
        }

    }

}