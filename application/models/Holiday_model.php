<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Holiday_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }

    public function add_holiday($data)
    {
         $this->db->select('*');
         $this->db->where(array("date"=>$data['date']));
         $query= $this->db->get('am_holidays');
        // return $query->num_rows();
         if($query->num_rows()>0)
         {
             return 2;
         }
         else
         {
               $res=$this->db->insert('am_holidays',$data);
               if($res)
                {
                   return true;
                }
                else
                {
                    return false;
                }
         }
    }

    public function get_allholidays()
    {
         $this->db->select('*');
         $this->db->order_by('id','desc');
         $query= $this->db->get('am_holidays');
        $data_array=array();
         if($query->num_rows()>0)
         {
            $data_array=$query->result_array();
         }
        return $data_array;
    }
    //edit holiday
    public function edit_holiday($id,$data)
    {
          $this->db->select('*');
          $this->db->where(array("date"=>$data['date']));
          $this->db->where('id!=',$id);
         $query= $this->db->get('am_holidays');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('id', $id);
               $query=$this->db->update('am_holidays',$data);
               if($query)
               {
                 return true;
               }
              else
              {
                 return false;
              }
         }
    }
    //delete holiday
    public function delete_holidaydata($id)
    {
                $this->db->where('id', $id);
               $query=$this->db->delete('am_holidays');
               if($query)
               {
                 return true;
               }
              else
              {
                 return false;
              }
    }

}
?>
