<?php
namespace App\Traits;

use Carbon\Carbon;

trait Query{
    public function scopeSearchBy($query,$column,$data,$type=null)
    {
        $isBoolean=is_bool($data);
        $isValidData= $isBoolean?true: (!!$data);
        if($isValidData){
            if($type=='like'){
                return  $query->where($column,'like', $data);
            }
            if($type=='whereIn'){
                return  $query->whereIn($column,$data);
            }
            if($type==null){
                return  $query->where($column,$data);
            }
           return  $query->where($column,$type,$data);
        }
        return $query;
    }

    public function scopeSearchByRelationship($query,$relationships=null,$column=null,$data=null,$type=null)
    {

        if (is_array($relationships)){
            $relationship1  =   isset($relationships[0]) ? $relationships[0] : null;
            $relationship2  =   isset($relationships[1]) ? $relationships[1] : null;
            $relationship3  =   isset($relationships[2]) ? $relationships[2] : null;
        }else{
            $relationship1  =   $relationships;
            $relationship2  =   null;
            $relationship3  =   null;
        }
        $isBoolean=is_bool($data);
        $isValidData= $isBoolean?true: (!!$data);

        if($isValidData)
        {
            $query->whereHas($relationship1, function ($query) use ($data,$column,$relationship2,$relationship3,$type){
                if($relationship2){
                    return $query->whereHas($relationship2, function ($query) use ($data,$column,$type,$relationship3){
                        if($relationship3){
                            return $query->whereHas($relationship3, function ($query) use ($data,$column,$type){
                                if($type=='like'){
                                    return  $query->where($column,'like', '%' . $data. '%');
                                }
                                if($type=='whereNotIn'){
                                    return  $query->whereNotIn($column, $data);
                                }
                                if($type=='whereIn'){
                                    return  $query->whereIn($column, $data);
                                }
                                if($type==null){
                                    return  $query->where($column,$data);
                                }
                               return  $query->where($column,$type,$data);
                            });
                        }
                        if($type=='like'){
                            return  $query->where($column,'like', '%' . $data. '%');
                        }
                        if($type=='whereNotIn'){
                            return  $query->whereNotIn($column, $data);
                        }
                        if($type=='whereIn'){
                            return  $query->whereIn($column, $data);
                        }
                        if($type==null){
                            return  $query->where($column,$data);
                        }
                       return  $query->where($column,$type,$data);
                    });
                }
                if($type=='like'){
                    return  $query->where($column,'like', '%' . $data. '%');
                }
                if($type=='whereNotIn'){
                    return  $query->whereNotIn($column, $data);
                }
                if($type=='whereIn'){
                    return  $query->whereIn($column, $data);
                }
                if($type==null){
                    return  $query->where($column,$data);
                }
               return  $query->where($column,$type,$data);
             });
        }
        return $query;
    }

    public function scopeSearchByDate($query,$data, $operator, $column='created_at')
    {
        if($data)
        {
            $fixed_format=Carbon::createFromFormat('d-m-Y', $data)->format("Y-m-d");
           return $query->whereDate($column,$operator, $fixed_format);
        }
        return $query;
    }

    public function scopeSearchByHavingDate($query,$data, $operator, $column,$startDate=true)
    {
        if($data)
        {
            $fixed_format='';
            if ($startDate)
            {
                $fixed_format=Carbon::createFromFormat('d-m-Y', $data)->hour(0)->minutes(0)->second(0)->format("Y-m-d H:i:s");
            }else
            {
                $fixed_format=Carbon::createFromFormat('d-m-Y', $data)->hour(23)->minutes(59)->second(59)->format("Y-m-d H:i:s");
            }

           return $query->having($column,$operator, $fixed_format);
        }
        return $query;
    }
}