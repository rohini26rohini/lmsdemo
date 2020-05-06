<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }
    
    //get all request
    
    public function get_allmaintenanace_requestList()
    {
         $query= $this->db->select('assets_maintenance_service.*,assets_maintenance_service_details.*,am_institute_master.institute_name,assets_maintenance_service_type.type as maintenanacetype_name,assets_maintenance_service_type.allowed_amount')
                     ->from('assets_maintenance_service')
                     ->where('assets_maintenance_service.status', '1')
                     ->join('assets_maintenance_service_details', 'assets_maintenance_service.id = assets_maintenance_service_details.service_id') 
                    ->join('am_institute_master', 'assets_maintenance_service.institute_id = am_institute_master.institute_master_id')
                   ->join('assets_maintenance_service_type', 'assets_maintenance_service.maintenance_type = assets_maintenance_service_type.id')
                   ->order_by('assets_maintenance_service_details.id','DESC')
                   //->group_by('assets_maintenance_service_details.service_id')
                     ->get();

        $resultArr	=	array();
        $check_array	=	array();
        $result	=	array();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
          // echo "<pre>"; print_r($resultArr);
            foreach($resultArr as $row)
            {
              // echo "<pre>"; print_r($row['service_id']);
                if(in_array($row['service_id'],$check_array))
                {


                }
                else
                {

                    array_push($check_array,$row['service_id']);
                    array_push($result,$row);
                }
            }

            //echo $this->db->last_query();exit();
        }
       return   $result;
    }
    public function get_maintenance_request_byId($id)
    {
         $query= $this->db->select('assets_maintenance_service.*,assets_maintenance_service_details.*,am_institute_master.institute_name,assets_maintenance_service_type.type as maintenanacetype_name,assets_maintenance_service_type.allowed_amount')
                     ->from('assets_maintenance_service')
                ->where(array('assets_maintenance_service.status'=>'1','assets_maintenance_service.id'=>$id))
                     ->join('assets_maintenance_service_details', 'assets_maintenance_service.id = assets_maintenance_service_details.service_id') 
                    ->join('am_institute_master', 'assets_maintenance_service.institute_id = am_institute_master.institute_master_id')
                   ->join('assets_maintenance_service_type', 'assets_maintenance_service.maintenance_type = assets_maintenance_service_type.id')
               ->order_by('assets_maintenance_service_details.id','DESC')
                     ->get();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->row_array(); 
        }
       return   $resultArr;
    }
    
    //
    public function get_purchaseQuote_byId($id)
    {
      $query= $this->db->select('asset_purchase.*,asset_purchase_quotes.*')
                        ->from('asset_purchase')
                        ->join('asset_purchase_quotes', 'asset_purchase_quotes.asset_purchase_id = asset_purchase.id', 'left') 
                        ->where(array('asset_purchase.status'=>'1','asset_purchase.id'=>$id))
                        ->get();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
       return   $resultArr;  
    }
    public function delete_delete_Quote($id){
       $this->db->where('quote_id', $id);
      $query=$this->db->delete('asset_purchase_quotes'); 
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function duplicationCheck($purchase_data){
        $query=$this->db->get_where('asset_purchase', $purchase_data);
        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }
    public function duplicationCheckEdit($title, $id){
        $purchase_data=array(
            "title"=>strtoupper($title),
            'status'=>1
        );
        $query= $this->db->where($purchase_data)
                        ->where('id !=', $id)
                        ->get('asset_purchase');
        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }
}

?>
