<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Hostel_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
     /*
    *  add hostel building
    *   @author GBS-L
    */
     public function hostel_building_add($data)
    {
         
          $this->db->select('*');
          $this->db->where($data);
          $this->db->where('building_status!=','2');
         $query= $this->db->get('hl_hostel_building');
        // return $query->num_rows();
         if($query->num_rows()>0)
         {
             return 2;
         }
         else
         {
               $res=$this->db->insert('hl_hostel_building',$data);	
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
    
    public function getNum_hostelBuilding_details_ajax()
    {
      
       
		//$query	=	$this->db->select('hl_hostel_building.*, am_institute_master.institute_name')
		$query	=	$this->db->select('hl_hostel_building.*')
                     ->from('hl_hostel_building')
                    ->where('hl_hostel_building.building_status!=', '2')
                    // ->join('am_institute_master', 'hl_hostel_building.group_id = am_institute_master.institute_type_id')
                    ->order_by('building_id','DESC')
                     ->get();

		return $query->num_rows();  
    }

    public function hostelBuilding_details_ajax_search($start, $length, $order, $dir,$search)
    {
      
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }
		$query	=	$this->db->select('hl_hostel_building.*, am_institute_master.institute_name')
                      ->from('hl_hostel_building')
                      ->join('am_institute_master', 'hl_hostel_building.group_id = am_institute_master.institute_type_id')
                      ->where('hl_hostel_building.building_status!=', '2')
                      ->where('(
                                `building_name` LIKE "%'.$search.'%" OR
                                `building_status` LIKE "%'.$search.'%" OR
                                `institute_name` LIKE "%'.$search.'%"
                              )')
                      // ->like('building_name',$search)
                      // ->like('building_status',$search)
                      // ->or_like('institute_name',$search)
                      ->limit($length,$start)
                      ->group_by('building_id')
                      ->order_by('building_id','DESC')
                      ->get();

		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    }

    public function hostelBuilding_details_ajax($start="", $length="", $order="", $dir="")
    {
      
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }
				$query	=	$this->db->select('hl_hostel_building.*')
                           ->from('hl_hostel_building')
                          ->where('hl_hostel_building.building_status!=', '2')
                    // ->join('am_institute_master', 'hl_hostel_building.group_id = am_institute_master.institute_type_id')
                     ->limit($length,$start)
                     ->order_by('building_id','DESC')
                     ->get();

		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    } 
    
    //show building data by id
    public function get_hostel_buildingdata_byId($building_id)
    {
       $query= $this->db->get_where('hl_hostel_building',array("building_id"=>$building_id));
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->row_array(); 
        }
      return   $resultArr; 
    }
    
    public function hostel_building_edit($id,$data)
    {
         $this->db->select('*');
         $this->db->where($data);
         $this->db->where('building_status!=','2');
          $this->db->where('building_id!=',$id);
         $query= $this->db->get('hl_hostel_building');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('building_id', $id);
               $query=$this->db->update('hl_hostel_building',$data);		
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
    public function hostel_building_status($building_id,$building_status)
    {
              $this->db->where('building_id', $building_id);
               $query=$this->db->update('hl_hostel_building',array("building_status"=>$building_status));		
               if($query)
               {
                 return true; 
               }
              else
              {
                 return false;
              }  
        
    }
    
    public function hostel_floor_add($data)
    {
       
         $this->db->select('*');
         $this->db->where($data);
          $this->db->where('floor_status!=','2');
         $query= $this->db->get('hl_hostel_floor');
        // return $query->num_rows();
         if($query->num_rows()>0)
         {
             return 2;
         }
         else
         {
               $res=$this->db->insert('hl_hostel_floor',$data);	
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
    //show all floors
    public function get_all_hostelFloor()
    {
       // $query= $this->db->get_where('hl_hostel_floor',array("floor_status!="=>"2"));
       $query= $this->db->select('hl_hostel_floor.*,hl_hostel_building.building_name')
                     ->from('hl_hostel_floor')
                     ->where('hl_hostel_floor.floor_status!=', '2')
                     ->join('hl_hostel_building', 'hl_hostel_floor.building_id = hl_hostel_building.building_id')
                    ->order_by('	floor_id','DESC')
                     ->get();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
      return   $resultArr;
    }
    //change floor status
    public function hostel_floor_status($floor_id,$floor_status)
    {
            if($floor_status == 1)
            {
               $this->db->select('*');
               $this->db->where('floor_id',$floor_id);
               $building_id= $this->db->get('hl_hostel_floor')->row()->building_id;
                if($building_id !="")
                   {
                         $this->db->where('building_id', $floor_id);
                         $sql=$this->db->update('hl_hostel_building',array("building_status"=>1)); 
                         if($sql)
                            {
                                $this->db->where('floor_id', $floor_id);
                                $query=$this->db->update('hl_hostel_floor',array("floor_status"=>$floor_status));
                            }
                            else
                            {
                                return false;
                            }
                   }
            }
           else
            {
               $this->db->where('floor_id', $floor_id);
               $query=$this->db->update('hl_hostel_floor',array("floor_status"=>$floor_status));
            }
           if($query)
           {
             return true;
           }
           else
           {
             return false;
           }

    }

    //edit floor
    public function hostel_floor_edit($id,$data)
    {
          $this->db->select('*');
          $this->db->where($data);
          $this->db->where('floor_status!=','2');
          $this->db->where('floor_id!=',$id);
         $query= $this->db->get('hl_hostel_floor');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('floor_id', $id);
               $query=$this->db->update('hl_hostel_floor',$data);
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
    //add room type
    public function hostel_roomtype_add($data)
    {
         $this->db->select('*');
        $this->db->where($data);
          $this->db->where('roomtype_status!=','2');
         $query= $this->db->get('hl_hostel_roomtype');
        // return $query->num_rows();
         if($query->num_rows()>0)
         {
             return 2;
         }
         else
         {
               $res=$this->db->insert('hl_hostel_roomtype',$data);
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
    
    //edit roomtype
    public function hostel_roomtype_edit($id,$data)
     {
         $this->db->select('*');
         $this->db->where($data);
          $this->db->where('roomtype_status!=','2');
         $this->db->where('roomtype_id!=',$id);
         $query= $this->db->get('hl_hostel_roomtype');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('roomtype_id', $id);
               $query=$this->db->update('hl_hostel_roomtype',$data);
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

    //change roomtype status
    public function hostel_roomtype_status($roomtype_id,$roomtype_status)
    {
               $this->db->where('roomtype_id', $roomtype_id);
               $query=$this->db->update('hl_hostel_roomtype',array("roomtype_status"=>$roomtype_status));
               if($query)
               {
                 return true;
               }
              else
              {
                 return false;
              }
    }
    
    //get floors by building id
    public function get_floors_by_buildingId($data)
    {
         $this->db->select('*');
         $query= $this->db->where($data);
         $query= $this->db->where('floor_status=','1');
         $query= $this->db->get('hl_hostel_floor');
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
      return   $resultArr;
    }
    //add rooms in hostel
    public function hostel_rooms_add($data)
    {
         $this->db->select('*');
         $this->db->where($data);
         $this->db->where('room_status!=','2');
         $query= $this->db->get('hl_hostel_rooms');
        // print_r($this->db->last_query());
         if($query->num_rows()>0)
         {
             return 2;
         }
         else
         {
               $res=$this->db->insert('hl_hostel_rooms',$data);
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
    
    //get room list
    public function get_allroom_list()
    {
      $query= $this->db->select('hl_hostel_rooms.*,hl_hostel_building.building_name,hl_hostel_floor.floor,hl_hostel_roomtype.room_type')
                     ->from('hl_hostel_rooms')
                     ->where('hl_hostel_rooms.room_status!=', '2')
                     ->join('hl_hostel_building', 'hl_hostel_rooms.building_id = hl_hostel_building.building_id')
                     ->join('hl_hostel_floor', 'hl_hostel_rooms.floor_id = hl_hostel_floor.floor_id')
                     ->join('hl_hostel_roomtype', 'hl_hostel_rooms.roomtype_id = hl_hostel_roomtype.roomtype_id')
                    ->order_by('hl_hostel_rooms.room_id','desc')
                     ->get();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
      return   $resultArr;  
    }

    //get room details by id
    public function get_hostel_roomdata_byId($id)
    {
        $query= $this->db->select('hl_hostel_rooms.*,hl_hostel_building.building_name,hl_hostel_floor.floor,hl_hostel_roomtype.room_type')
                     ->from('hl_hostel_rooms')
                     ->where(array('hl_hostel_rooms.room_status!='=> '2','hl_hostel_rooms.room_id'=>$id))
                     ->join('hl_hostel_building', 'hl_hostel_rooms.building_id = hl_hostel_building.building_id')
                     ->join('hl_hostel_floor', 'hl_hostel_rooms.floor_id = hl_hostel_floor.floor_id')
                     ->join('hl_hostel_roomtype', 'hl_hostel_rooms.roomtype_id = hl_hostel_roomtype.roomtype_id')
                     ->get();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->row_array();
        }
      return   $resultArr;
    }
    //edit room
    public function hostel_room_edit($room_id,$data)
    {
         $this->db->select('*');
         $this->db->where($data);
         $this->db->where('room_status!=','2');
         $this->db->where('room_id!=',$room_id);
         $query= $this->db->get('hl_hostel_rooms');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('room_id', $room_id);
               $query=$this->db->update('hl_hostel_rooms',$data);
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
    //get rooms for booking by building id,floor id and roomtype
    public function get_roomlist_for_booking($data)
    {
         $data['room_status']=1;
         $this->db->select('*');
          $this->db->where($data);
         $query= $this->db->get('hl_hostel_rooms');
         $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr; 
    }
    
    
    //get student list for hostel who doesn't get rooms yet
    public function get_studentlist_for_hostel()
    {
         $this->db->select('*');
         $this->db->where(array("status!="=>"5","hostel"=>"yes"));
         $query= $this->db->get('am_students');
         $resultArr	=	array();

         if($query->num_rows()>0)
         {
             $resultArr=$query->result_array();

             $student_array=array();
             $i=0;
             if(!empty($resultArr))
             {
                 foreach($resultArr as $row)
                 {
                     $sql= $this->db->get_where('hl_room_booking',array("student_id"=>$row['student_id'],"delete_status"=>"1"));
                     if($sql->num_rows() <= 0)//room not alloted
                     {
                        $student_array[$i]['student_id']=$row['student_id'];
                        $student_array[$i]['registration_number']=$row['registration_number'];
                        $student_array[$i]['name']=$row['name'];
                     }
                     $i++;
                 }
             }
         }
         return   $student_array;
    }
    //book hostel room for student 
    //@params student id,room id
    public function hostel_rooms_booking($data)
    {

       $res=$this->db->insert('hl_room_booking',$data);
       if($res)
        {
           return true;
        }
        else
        {
            return false;
        }

    }
    
    //get all room booking details
    public function all_roombooking_list()
    {
         $query=$this->db->select('hl_room_booking.*,am_students.registration_number,am_students.contact_number,hl_hostel_rooms.building_id,hl_hostel_rooms.room_number,hl_hostel_building.building_name')
                ->from('hl_room_booking')
                ->where('hl_room_booking.delete_status!=','2')
                ->join('am_students','hl_room_booking.student_id = am_students.student_id')
                ->join('hl_hostel_rooms', 'hl_room_booking.room_id = hl_hostel_rooms.room_id')
                ->join('hl_hostel_building', 'hl_hostel_rooms.building_id = hl_hostel_building.building_id')
                ->order_by('hl_room_booking.id','DESC')
                ->get();

         $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr;
    }//get all room booking details by student id
    public function all_roombooking_list_byStudId($id)
    {
         $query=$this->db->select('hl_room_booking.*,am_students.registration_number,am_students.contact_number,hl_hostel_rooms.building_id,hl_hostel_rooms.room_number,hl_hostel_building.building_name')
                ->from('hl_room_booking')
                ->where(array('hl_room_booking.delete_status!='=>'2','am_students.student_id'=>$id))
                ->join('am_students','hl_room_booking.student_id = am_students.student_id')
                ->join('hl_hostel_rooms', 'hl_room_booking.room_id = hl_hostel_rooms.room_id')
                ->join('hl_hostel_building', 'hl_hostel_rooms.building_id = hl_hostel_building.building_id')
                ->order_by('hl_room_booking.id','DESC')
                ->get();

         $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr;   
    }

     /*
     *  hostel seraching
     *   @author GBS-L
     */
    public function search_booking($data)
     {
       $query=$this->db->select('hl_room_booking.*,am_students.registration_number,am_students.contact_number,hl_hostel_rooms.building_id,hl_hostel_rooms.room_number,hl_hostel_building.building_name')
                ->from('hl_room_booking')
                ->where($data)
                ->join('am_students','hl_room_booking.student_id = am_students.student_id')
                ->join('hl_hostel_rooms', 'hl_room_booking.room_id = hl_hostel_rooms.room_id')
                ->join('hl_hostel_building', 'hl_hostel_rooms.building_id = hl_hostel_building.building_id')
                ->order_by('hl_room_booking.id','DESC')
                ->get();
         $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr;

     }
    //get all student list from hostel room booking table
    public function get_studentlist_for_hostelsearch()
    {
         $query= $this->db->select('hl_room_booking.student_id,am_students.registration_number,am_students.name')
         ->where(array("am_students.status"=>"1","am_students.hostel"=>"yes"))
         ->from('hl_room_booking')
         ->join('am_students','hl_room_booking.student_id = am_students.student_id')
         ->get();
         $resultArr	=	array();

         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr;
    }

    
  /*get details of booke roomdata by id
  @auther GBS-L
  */
    public function get_booked_roomdata_byId($id)
    {
       $query=$this->db->select('hl_room_booking.*,am_students.registration_number,am_students.contact_number,hl_hostel_rooms.building_id,hl_hostel_rooms.room_number,hl_hostel_rooms.floor_id,hl_hostel_rooms.roomtype_id,hl_hostel_building.building_name')
                ->from('hl_room_booking')
                ->where('hl_room_booking.id',$id)
                ->join('am_students','hl_room_booking.student_id = am_students.student_id')
                ->join('hl_hostel_rooms', 'hl_room_booking.room_id = hl_hostel_rooms.room_id')
                ->join('hl_hostel_building', 'hl_hostel_rooms.building_id = hl_hostel_building.building_id')
                ->get();
         $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->row_array();
         }
         return   $resultArr;    
    }
    //change room
    public function change_hostelRoom($id,$data)
    {
           $this->db->where('id', $id);
           $query=$this->db->update('hl_room_booking',$data);
           if($query)
           {
             return true;
           }
          else
          {
             return false;
          }  
    }
    //
    public function load_buildingList_ajax ()
    {
        $query	=	$this->db->select('hl_hostel_building.*')
                   ->from('hl_hostel_building')
                   ->where('hl_hostel_building.building_status!=', '2')
                   ->order_by('building_id','DESC')
                   ->get();
        $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr;  
    }
    //change room status
    public function hostel_room_status($room_id,$room_status)
    {
        if($room_status == 1)
        {
               $this->db->select('*');
               $this->db->where('room_id',$room_id);
               $details= $this->db->get('hl_hostel_rooms');
             
               if($details)
               {
                  $roomtype_id= $details->row()->roomtype_id;
                  $floor_id= $details->row()->floor_id;
                  $building_id= $details->row()->building_id;
                   
                  $sql_one= $this->update_fromwhere('hl_hostel_roomtype', array('roomtype_id'=>$roomtype_id),array("roomtype_status"=>"1")); 
                   //echo $this->db->last_query();
                  if($sql_one) 
                  {
                        $sql_two= $this->update_fromwhere('hl_hostel_floor', array('floor_id'=>$floor_id),array("floor_status"=>1));
                     
                          if($sql_two)
                          {
                               $sql_three=$this->update_fromwhere('hl_hostel_building',  array('building_id'=>$building_id),array("building_status"=>1));  
                               if($sql_three)
                               {
                                  $this->db->where('room_id', $room_id);
                                  $query=$this->db->update('hl_hostel_rooms',array("room_status"=>$room_status)); 
                               }
                               else
                                {
                                    return false;
                                }
                          }
                          else
                          {
                                return false;
                          }
                    }
                    else
                    {
                        return false;
                    }
             
               }
            else
            {
                return false;
            }
        }
        else
        {
          $this->db->where('room_id', $room_id);
          $query=$this->db->update('hl_hostel_rooms',array("room_status"=>$room_status));  
        }
               
       if($query)
       {
         return true;
       }
       else
       {
         return false;
       } 
    }
    
    //common function to update
     public function update_fromwhere($table, $where,$data){
        $this->db->where($where);
        $query= $this->db->update($table,$data);
        if($query){ return true;}
        else
        {
            return false;
        }
    }
    //get all hostel fee list
    public function get_allhostelfee()
    {
       $query= $this->db->select('hl_hostel_fees.*,hl_hostel_roomtype.room_type')
         ->where(array("hl_hostel_fees.status"=>"1"))
         ->from('hl_hostel_fees')
         ->join('hl_hostel_roomtype','hl_hostel_roomtype.roomtype_id = hl_hostel_fees.room_type')
         ->order_by('hostel_fee_id','desc')
         ->get();
         $resultArr	=	array();

         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr; 
    }
    //add hostel fee
    public function hostel_fees_add($data)
    {
      
       $res=$this->db->insert('hl_hostel_fees',$data);
       if($res)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    function save_hostel_fees($data){
      $res = $this->db->insert('hl_hostel_fees',$data);
      if($res){
        return $this->db->insert_id();
      }else{
        return false;
      }
    }

    function save_hostel_fees_details($data){
      $this->db->where('hostel_fee_id',$data[0]['hostel_fee_id'])->delete('hl_hostel_fees_details');
      $res = $this->db->insert_batch('hl_hostel_fees_details',$data);
      if($res){
        return true;
      }else{
        return false;
      }
    }

    function update_hostel_fees($data,$hostel_fee_id){
      $res = $this->db->where('hostel_fee_id',$hostel_fee_id)->update('hl_hostel_fees',$data);
      if($res){
        return true;
      }else{
        return false;
      }
    }

    function get_hostel_room_type_fees_details($id){
      $data['hostel_fees'] = $this->db->where('hostel_fee_id',$id)->get('hl_hostel_fees')->row_array();
      $data['hostel_fees_amount'] = $this->db->select('hl_hostel_fees_details.*,am_payment_heads.ph_head_name')
                                              ->from('hl_hostel_fees_details')
                                              ->join('am_payment_heads','am_payment_heads.ph_id=hl_hostel_fees_details.ph_id')
                                              ->where('hl_hostel_fees_details.hostel_fee_id',$id)
                                              ->get()->result_array();      
      return $data;
    }
    
    function view_hostel_room_type_fees_details($id){
      $data['hostel_fees'] = $this->db->where('hostel_fee_id',$id)->get('hl_hostel_fees')->row_array();
      $data['hostel_fees_amount'] = $this->db->select('hl_hostel_fees_details.*,am_payment_heads.ph_head_name')
                                              ->from('hl_hostel_fees_details')
                                              ->join('am_payment_heads','am_payment_heads.ph_id=hl_hostel_fees_details.ph_id')
                                              ->where('hl_hostel_fees_details.hostel_fee_id',$id)
                                              ->get()->result_array();      
      return $data;
    }

    //edit hostel fee details
    public function hostel_fee_edit($id,$data)
    {
         $this->db->select('*');
         $this->db->where(array("room_type"=>$data['room_type'],"mess_type"=>$data['messtype'],"status"=>1,"hostel_fee_id!="=>$id));
         $query= $this->db->get('hl_hostel_fees');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('hostel_fee_id', $id);
               $query=$this->db->update('hl_hostel_fees',array("room_type"=>$data['room_type'],"mess_type"=>$data['messtype'],"fees"=>$data['fees']));
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

    public function get_roomtype_for_HostelBooking()
    {
        $query=$this->db->select('hl_hostel_roomtype.*')
                    ->from('hl_hostel_roomtype')
                    ->where(array('hl_hostel_roomtype.roomtype_status'=>'1','hl_hostel_fees.status'=>'1'))
                    ->join('hl_hostel_fees','hl_hostel_roomtype.roomtype_id = hl_hostel_fees.room_type')
                    ->group_by('hl_hostel_roomtype.roomtype_id')
                    ->get();
             $resultArr	=	array();
             if($query->num_rows()>0)
             {
               $resultArr=$query->result_array();
             }
             return   $resultArr;
    }

    function get_all_hostel_fee_def(){
      return $this->db->where('fee_type','Hostel Fee')->get('am_fee_definition')->result_array();
    }

    function get_hostel_fee_heads($id){
      return $this->db->select('am_payment_heads.*')
                      ->from('am_payment_heads')
                      ->join('am_fee_definition_details','am_fee_definition_details.fee_head_id=am_payment_heads.ph_id')
                      ->where('am_fee_definition_details.fee_definition_id',$id)
                      ->order_by('am_fee_definition_details.fee_definition_details_id','ASC')
                      ->get()->result_array();
    }
    

    function get_student_list(){
      $query = $this->db->select('am_students.*, cities.name as city_name,am_student_course_mapping.course_id')
                        ->from('am_students')
                        ->join('cities', 'cities.id = am_students.district')
                        ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
                        ->where(array("am_students.hostel"=>"YES","am_students.verified_status"=>1,"am_students.status"=>1))
                        ->group_by('am_students.student_id')
                        ->order_by('am_students.student_id','desc')
	                      ->get();
      $resultArr  =	array();
      if($query->num_rows() > 0){
        $resultArr	=	$query->result_array();
      }
		  return $resultArr;
    }

    function get_student_hostel_rent($student_id,$booking_id){
      $student_details = $this->db->where('student_id',$student_id)->get('am_students')->row_array();
      $roomtype_id = $this->db->select('hl_hostel_rooms.*,hl_room_booking.id as hl_room_booking_id,hl_room_booking.status as hl_room_booking_status')
                              ->from('hl_hostel_rooms')
                              ->join('hl_room_booking','hl_room_booking.room_id=hl_hostel_rooms.room_id')
                              ->where('hl_room_booking.id',$booking_id)
                              ->get()->row();
      $mess_type = $student_details['food_habit'];
      if(strtolower(str_replace(' ','',$student_details['food_habit'])) == 'veg'){$mess_type = 'veg';}
      if(strtolower(str_replace(' ','',$student_details['food_habit'])) == 'nonveg'){$mess_type = 'nonveg';}
      if(strtolower(str_replace(' ','',$student_details['food_habit'])) == 'na'){$mess_type = 'na';}
      $fees = $this->db->select('hl_hostel_fees.*,hl_hostel_roomtype.room_type')->from('hl_hostel_fees')
                        ->join('hl_hostel_roomtype','hl_hostel_roomtype.roomtype_id=hl_hostel_fees.room_type')
                        ->where('hl_hostel_fees.room_type',$roomtype_id->roomtype_id)
                        ->where('hl_hostel_fees.mess_type',$mess_type)
                        ->get()->row_array();
      if(!empty($fees)){
        $fees['hl_room_booking_id'] = $roomtype_id->hl_room_booking_id;
        $fees['hl_room_booking_status'] = $roomtype_id->hl_room_booking_status;
        $fee_details = $this->db->select('am_payment_heads.ph_head_name,hl_hostel_payments.amount,hl_hostel_payments.ph_id')
                                      ->from('hl_hostel_payments')
                                      ->join('am_payment_heads','am_payment_heads.ph_id=hl_hostel_payments.ph_id')
                                      ->where('hl_hostel_payments.payment_type',1)
                                      ->where('hl_hostel_payments.hl_room_booking_id',$roomtype_id->hl_room_booking_id)
                                      ->get()->result_array();
        if(count($fee_details)==0){
          $fee_details = $this->db->select('am_payment_heads.ph_id,am_payment_heads.ph_head_name,hl_hostel_fees_details.amount')
                                  ->from('am_payment_heads')
                                  ->join('hl_hostel_fees_details','hl_hostel_fees_details.ph_id=am_payment_heads.ph_id')
                                  ->where('hl_hostel_fees_details.hostel_fee_id',$fees['hostel_fee_id'])
                                  ->get()->result_array();
        }
        $data['monthly_fees'] = $fees;
        $data['onetime_fees'] = $fee_details;
      }else{
        $data['monthly_fees'] = [];
        $data['onetime_fees'] = [];
      }
      return $data;
    }

    function get_student_hostel_rent_payments($booking_id){
      return $this->db->select('hl_hostel_payments.*')->from('hl_hostel_payments')
                      ->join('hl_room_booking','hl_room_booking.id=hl_hostel_payments.hl_room_booking_id')
                      ->where('hl_room_booking.id',$booking_id)
                      ->where('hl_room_booking.delete_status',1)
                      ->order_by('hl_hostel_payments.hostel_payment_invoices_id','ASC')
                      ->get()->result_array();
    }

    function get_student_batch_details($student_id){
      return $this->db->select('am_batch_center_mapping.*')->from('am_batch_center_mapping')
                      ->join('am_student_course_mapping','am_student_course_mapping.batch_id=am_batch_center_mapping.batch_id')
                      ->where('am_student_course_mapping.student_id',$student_id)
                      ->where('am_batch_center_mapping.batch_status',1)
                      ->get()->row_array();
    }

    function save_hostel_rent($data){
      $invoice = array(
                    'invoice_no'=>'INVH'.time(),
                    'hl_room_booking_id'=>$data[0]['hl_room_booking_id'],
                    'total_payed_amount'=>0,
                    'total_payable_amount'=>0
                  );
      foreach($data as $row){
        $invoice['total_payable_amount'] += (float)$row['payable_amount'];
        $invoice['total_payed_amount'] += (float)$row['payed_amount'];
      }
      $res = $this->db->insert('hl_hostel_payment_invoices',$invoice);
      if($res){
        $invoice_id = $this->db->insert_id();
        $this->db->where('id',$invoice_id)->update('hl_hostel_payment_invoices',['invoice_no'=>'INVH'.$invoice_id.mt_rand('99999','999999')]);
        foreach($data as $row){
          $row['hostel_payment_invoices_id'] = $invoice_id;
          $res = $this->db->insert('hl_hostel_payments',$row);
        }
        if($res){
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    function update_hostel_room_booking($data,$hl_room_booking_id){
      return $this->db->where('id',$hl_room_booking_id)->update('hl_room_booking',$data);
    } 

    function get_invoice_payments($inv_id){
      $fee_details = $this->db->where('hostel_payment_invoices_id',$inv_id)->get('hl_hostel_payments')->result();
      return $fee_details;         
    }
}
?>
