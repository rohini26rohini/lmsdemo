<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_batch(){
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->db->where('batch_status',1);
        $this->db->order_by('am_batch_center_mapping.batch_id','desc');
	    $query	=	$this->db->get('');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }

    public function get_activeBatch()
    {
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->db->where('batch_status',1);
        $this->db->order_by('am_batch_center_mapping.batch_id','desc');
	    $query	=	$this->db->get('');
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    // GET BATCH DETAILS BY ID
    
    public function get_batchby_id($id = NULL)
    {

        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->where('am_batch_center_mapping.batch_id', $id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }
    
    // INSERT BATCH
    
    public function insert_batchdetails($data,$postdata)
    {
        $this->db->insert('am_batch_center_mapping',$data);	

        $batch_id = $this->db->insert_id();
        $details = array();
        $i=0;
        $details = array(
            'batch_id'=>$batch_id
           // 'start_time'=>$data['batch_start_time'],
           // 'end_time'=>$data['batch_end_time']
        );
        if($data['sunday']){
             $start_time=$postdata['sunday_start_time'];
             $end_time=$postdata['sunday_end_time'];
            foreach($start_time as $key=>$row)
              {
                $class_details[$i]=$details;
                $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                $class_details[$i]['week_day']='Sun';
                $class_details[$i]['class_sequence_number']=$i+1;
                $i++;
            }
        }
         
        if($data['monday'])
        {
            $start_time=$postdata['monday_start_time'];
            $end_time=$postdata['monday_end_time'];
           
            foreach($start_time as $key=>$row){
             $class_details[$i]=$details;
             $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
             $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
             $class_details[$i]['week_day']='Mon';
             $class_details[$i]['class_sequence_number']=$i+1;
             $i++;
            }
        }
        if($data['tuesday']){
             $start_time=$postdata['tuesday_start_time'];
             $end_time=$postdata['tuesday_end_time'];
              foreach($start_time as $key=>$row){
             $class_details[$i]=$details;
             $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
             $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
             $class_details[$i]['week_day']='Tue';
             $class_details[$i]['class_sequence_number']=$i+1;
             $i++;
              }
        }
        if($data['wednesday']){
            $start_time=$postdata['wednesday_start_time'];
             $end_time=$postdata['wednesday_end_time'];
              foreach($start_time as $key=>$row)
              {
                    $class_details[$i]=$details;
                    $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                    $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                    $class_details[$i]['week_day']='Wed';
                    $class_details[$i]['class_sequence_number']=$i+1;
                    $i++;
              }
        }
        if($data['thursday']){
            $start_time=$postdata['thursday_start_time'];
             $end_time=$postdata['thursday_end_time'];
              foreach($start_time as $key=>$row)
              {
                    $class_details[$i]=$details;
                    $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                    $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                    $class_details[$i]['week_day']='Thu';
                    $class_details[$i]['class_sequence_number']=$i+1;
                    $i++;
               }
              }
        if($data['friday']){
             $start_time=$postdata['friday_start_time'];
             $end_time=$postdata['friday_end_time'];
            foreach($start_time as $key=>$row)
              {
                $class_details[$i]=$details;
                $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                $class_details[$i]['week_day']='Fri';
                $class_details[$i]['class_sequence_number']=$i+1;
                $i++;
             }
            }
        if($data['saturday']){
             $start_time=$postdata['saturday_start_time'];
             $end_time=$postdata['saturday_end_time'];
            foreach($start_time as $key=>$row)
              {
                $class_details[$i]=$details;
                $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                $class_details[$i]['week_day']='Sat';
                $class_details[$i]['class_sequence_number']=$i+1;
                $i++;
             }
        } 
        
        $this->db->where('batch_id', $batch_id)->delete('am_batch_class_details');
        $query = $this->db->insert_batch('am_batch_class_details',$class_details);	

		$return	=	$batch_id;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }

    
    public function insert_batchFeedetails($data)
    {
        $query	= $this->db->insert_batch('am_batch_fee_installment',$data);	
		$return	=   true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    
    // UPDATE BATCH
    
    public function update_batchdetails($data,$id,$postdata)
    {
        $this->db->where('batch_id', $id);
        $query	= $this->db->update('am_batch_center_mapping',$data);
       
        if(!empty($data['batch_name']) && !empty($postdata['weekday'])){
            $details = array();
            $i=0;
            $details = array(
                'batch_id'=>$id,
                //'start_time'=>$data['batch_start_time'],
               // 'end_time'=>$data['batch_end_time']
            );
            if($data['sunday']){
             $start_time=$postdata['sunday_start_time'];
             $end_time=$postdata['sunday_end_time'];
             foreach($start_time as $key=>$row)
               {
                $class_details[$i]=$details;
                $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                $class_details[$i]['week_day']='Sun';
                $class_details[$i]['class_sequence_number']=$i+1;
                $i++;
             }
           }
         
           if($data['monday'])
        {
            $start_time=$postdata['monday_start_time'];
            $end_time=$postdata['monday_end_time'];
           
            foreach($start_time as $key=>$row){
             $class_details[$i]=$details;
             $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
             $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
             $class_details[$i]['week_day']='Mon';
             $class_details[$i]['class_sequence_number']=$i+1;
             $i++;
            }
        }
        if($data['tuesday']){
             $start_time=$postdata['tuesday_start_time'];
             $end_time=$postdata['tuesday_end_time'];
              foreach($start_time as $key=>$row){
             $class_details[$i]=$details;
             $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
             $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
             $class_details[$i]['week_day']='Tue';
             $class_details[$i]['class_sequence_number']=$i+1;
             $i++;
              }
        }
        if($data['wednesday']){
            $start_time=$postdata['wednesday_start_time'];
             $end_time=$postdata['wednesday_end_time'];
              foreach($start_time as $key=>$row)
              {
                    $class_details[$i]=$details;
                    $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                    $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                    $class_details[$i]['week_day']='Wed';
                    $class_details[$i]['class_sequence_number']=$i+1;
                    $i++;
              }
        }
        if($data['thursday']){
            $start_time=$postdata['thursday_start_time'];
             $end_time=$postdata['thursday_end_time'];
              foreach($start_time as $key=>$row)
              {
                    $class_details[$i]=$details;
                    $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                    $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                    $class_details[$i]['week_day']='Thu';
                    $class_details[$i]['class_sequence_number']=$i+1;
                    $i++;
               }
              }
        if($data['friday']){
             $start_time=$postdata['friday_start_time'];
             $end_time=$postdata['friday_end_time'];
            foreach($start_time as $key=>$row)
              {
                $class_details[$i]=$details;
                $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                $class_details[$i]['week_day']='Fri';
                $class_details[$i]['class_sequence_number']=$i+1;
                $i++;
             }
            }
        if($data['saturday']){
             $start_time=$postdata['saturday_start_time'];
             $end_time=$postdata['saturday_end_time'];
            foreach($start_time as $key=>$row)
              {
                $class_details[$i]=$details;
                $class_details[$i]['start_time']=date('H:i:s',strtotime($row));
                $class_details[$i]['end_time']=date('H:i:s',strtotime($end_time[$key]));
                $class_details[$i]['week_day']='Sat';
                $class_details[$i]['class_sequence_number']=$i+1;
                $i++;
             }
        } 
            $this->db->where('batch_id', $id)->delete('am_batch_class_details');
            $query = $this->db->insert_batch('am_batch_class_details',$class_details);
          //  echo $this->db->last_query();
        }		

		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
         
    }
    
    
    public function insert_question_paper($data)
    {
        $query	= $this->db->insert('am_questions',$data);	
		$return	=	true;
		
		if(!$query){
			$return	=	false;
		}
		
		return $return;
         
    }
    
    public function get_questions()
    {
        $this->db->select('am_questions.*,am_schools.school_name');
        $this->db->from('am_questions');
        $this->db->join('am_schools', 'am_questions.school_id = am_schools.school_id');
        $this->db->where('am_questions.question_status','1');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    public function question_delete($question_id)
    {
            $updateData = array('question_status' => '2');
            $this->db->where('question_id', $question_id);
           $query= $this->db->update('am_questions', $updateData);
        if($query){ return true;}
        else
        {
            return false;
        }
    }
    
    function courseandschool($coursemapp_id) {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id');
        $this->db->join('am_schools', 'am_schools.school_id = am_classes.school_id');
        $this->db->where('am_institute_course_mapping.institute_course_mapping_id', $coursemapp_id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
    }
    
    
    // GET MODE BY ID

    function get_batch_mode($institute_course_mapping_id){
        return $this->db->select('am_classes.batch_mode_id')->from('am_institute_course_mapping')
                    ->join('am_classes','am_classes.class_id=am_institute_course_mapping.course_master_id')
                    ->where('am_institute_course_mapping.institute_course_mapping_id',$institute_course_mapping_id)
                    ->get()->row()->batch_mode_id;
    }
    
    // UPDATE BATCH
    
    public function get_mode_id( $id)
    {
        $this->db->where('mode_id', $id);
        $query	= $this->db->get('am_batch_mode');	
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
         
    }
    
    // GET FROM TABLE WHERE ARRAY
    
    public function get_where($table, $where)
    {
        $this->db->where($where);
        $query	= $this->db->get($table);	
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
         
    }
    
    // GET COURSE BY CENTER ID
    
    // GET BATCH DETAILS BY ID
    
    public function get_courseby_center($id = NULL)
    {
        $this->db->select('*');
        $this->db->from('am_classes');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
        $this->db->where('am_institute_course_mapping.institute_master_id', $id);
        $this->db->where('am_classes.status=','1');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }

    public function get_classrooms_list()
    {
		// $query	=	$this->db->select('*')
        //              ->from('am_classrooms')
        //              ->where('am_classrooms.status', '1')
        //              ->get();
		// $resultArr	=	array();
		// if($query->num_rows() > 0){
		// 	$resultArr	=	$query->result_array();
		// }
        // return $resultArr;
        $this->db->select('am_classrooms.*,am_institute_master.institute_name');
        $this->db->from('am_classrooms');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_classrooms.institute_master_id');
        $this->db->order_by('am_classrooms.room_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();
        }
        return $resultArr;
    }

    /**
	*This function 'll return existing classroom details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_classrooms_exist($data)
    {
        $query= $this->db->get_where('am_classrooms',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert bus details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function classrooms_add($data)
    {
		$res=$this->db->insert('am_classrooms',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    public function get_classroomsdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('am_classrooms')
                    ->where('am_classrooms.room_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function edit_classrooms($data,$id)
    {
        $this->db->where('room_id',$id);
		$query	= $this->db->update('am_classrooms',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    public function delete_classrooms($id)
    {
        $this->db->where('room_id', $id);
        $query=$this->db->delete('am_classrooms');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function get_classrooms_by_id($room_id)
    {
		$this->db->select('*');
		$this->db->where('room_id',$room_id);
		$query	=	$this->db->get('am_classrooms');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }

    function get_class_rooms_by_id($room_id)
    {
		
        $this->db->select('am_classrooms.*,am_institute_master.institute_name');
        $this->db->from('am_classrooms');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_classrooms.institute_master_id');
        $this->db->where('room_id',$room_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->row_array();
        }
        return $resultArr;
    }
    

    
    public function institute_course_add_mapping($data)
    {
        if(!empty($data['room_id']))
        {
            $edit_id=$data['room_id'];
            unset($data['room_id']);
            $this->db->where('room_id',$edit_id);
		    $res	= $this->db->update('am_classrooms',$data);
        }
        else
        {
            unset($data['room_id']);
          $res=$this->db->insert('am_classrooms',$data);
        }

	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }

    }

    public function get_institutecourse_mapping_byid($where)
    {
       $this->db->select('*');
        $query= $this->db->get_where('am_classrooms',$where);
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->row_array();
           return $details;
        }
        else
        {
            return false;
        }
    }


    public function get_institutecourse_mapping_byid1($where)
    {
       $this->db->select('*');
        $query= $this->db->get_where('am_classrooms',$where);
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->row_array();
           return $details;
        }
        else
        {
            return false;
        }
    }









    public function is_course_exist($data)
    {
         unset($data['room_id']);
       $this->db->select('*');
        $query= $this->db->get_where('am_classrooms',$data);

           return $query->num_rows();


    }
    
    
    /*
    *   function'll get batch list by center course mapping table
    *   @params center course mapp id
    *   @author GBS-R
    */
    
    function get_batchby_coursecentermapp($coursemapp_id) {
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id');
        $this->db->where('am_batch_center_mapping.batch_status', 1);
        $this->db->where('am_batch_center_mapping.institute_course_mapping_id', $coursemapp_id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
 // funcgtion'll get branch center batch details
 // @params batch id
 // @author GBS-R
    
    public function get_batch_center_branch($batch_id = NULL)
    {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id=am_institute_course_mapping.institute_course_mapping_id');
        $this->db->where('am_batch_center_mapping.batch_id', $batch_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->row();
        }
        return $resultArr;
    }  
    
// function'll get all batches by course id
// @author GBS-R

function get_all_batches($centermapp_id) {
    $this->db->select('*');
    $this->db->from('am_batch_center_mapping');
    $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
    $this->db->where('am_batch_center_mapping.institute_course_mapping_id', $centermapp_id);
    $this->db->where('am_batch_center_mapping.batch_status', 1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }

    return $resultArr;
}


// function'll get all branches by course id
// @author GBS-R

function get_all_branches($course_id) {
    $this->db->select('*');
    $this->db->from('am_institute_course_mapping');
    $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
    $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
    $this->db->where('am_institute_master.institute_type_id', 2);
    $this->db->where('am_institute_master.status', 1);
    $this->db->group_by('am_institute_course_mapping.branch_master_id');
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }

    return $resultArr;
}  

// function'll get all branches by course id
// @author GBS-R

function get_all_exams($school_id) {
    $this->db->select('*');
    $this->db->from('web_notifications');
    $this->db->where('web_notifications.school_id', $school_id);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result_array();		
    }

    return $resultArr;
}  

// function'll get all centers by course id, branch id
// @author GBS-R

function get_all_centers($course_id, $branch_id) {
    $this->db->select('*');
    $this->db->from('am_institute_course_mapping');
    $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
    $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
    $this->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
    $this->db->group_by('am_institute_course_mapping.institute_master_id');
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }

    return $resultArr;
} 
    
    
// function'll get course branch by course id, branch id
// @author GBS-R

function get_course_centermapp($course_id, $branch_id, $center_id = NULL) {
    $this->db->select('*');
    $this->db->from('am_institute_course_mapping');
    $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
    $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
    $this->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
    if($center_id!='') {
    $this->db->where('am_institute_course_mapping.institute_master_id', $center_id);
    }
    $this->db->group_by('am_institute_course_mapping.institute_master_id');   //   <--- Edited GBS-R 10-01-2019 --->
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }

    return $resultArr;
}  
// function'll return the upcomming courses  and batches under each course
// @author GBS-L

   public function get_upcomming_batch()
    {
        $today = date('Y-m-d');  
        $this->db->select('am_classes.class_name,am_classes.class_id,am_batch_center_mapping.institute_course_mapping_id');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
        $this->db->where('batch_status',1);
        $this->db->where('am_institute_course_mapping.status','1');
        $this->db->where('batch_datefrom >',$today);
//        $this->db->group_by('am_batch_center_mapping.institute_course_mapping_id'); 
        $this->db->group_by('am_classes.class_id'); 
	    $query	=	$this->db->get();
		$courseArr	=	array();
		if($query->num_rows() > 0)
        {
			$courseArr	=	$query->result_array();	//upcomming courses	
		}
        foreach($courseArr as $key=>$course_id)
        {
            $this->db->select('*');
            $this->db->from('am_batch_center_mapping');
            $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
            $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id'); 
             $this->db->join('am_classes', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
            $this->db->where('batch_status',1);
            $this->db->where('am_institute_course_mapping.status','1');
            $this->db->where('batch_datefrom>',$today);
            $this->db->where('am_batch_center_mapping.institute_course_mapping_id',$course_id['institute_course_mapping_id']);
            $query	=	$this->db->get();
             
            if($query->num_rows() > 0)
            {
                 $courseArr[$key]['batch_details']	=	$query->result_array(); //batches under each course
            }
        }
		
		return $courseArr;
    }  
    // function'll return the running courses and batches under each course
    // @author GBS-L

   public function get_running_batch()
    {
        
       $today = date('Y-m-d');  
        $this->db->select('am_classes.class_name,am_classes.class_id,am_batch_center_mapping.institute_course_mapping_id');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
        $this->db->where('batch_status',1);
        $this->db->where('batch_datefrom <=',$today);
        $this->db->where('batch_dateto >=',$today);
        //$this->db->group_by('am_batch_center_mapping.institute_course_mapping_id'); 
        $this->db->group_by('am_classes.class_id'); 
	    $query	=	$this->db->get();
		$courseArr	=	array();
		if($query->num_rows() > 0)
        {
			$courseArr	=	$query->result_array();	//running courses	
            
		}
        foreach($courseArr as $key=>$course_id)
        {
            $this->db->select('*');
            $this->db->from('am_batch_center_mapping');
            $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
            $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id'); 
            $this->db->join('am_classes', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
            $this->db->where('batch_status',1);
            $this->db->where('batch_datefrom<=',$today);
            $this->db->where('batch_dateto>=',$today);
            $this->db->where('am_batch_center_mapping.institute_course_mapping_id',$course_id['institute_course_mapping_id']);
            $query	=	$this->db->get();
             
            if($query->num_rows() > 0)
            {
                 $courseArr[$key]['batch_details']	=	$query->result_array(); //batches under each course
            }
        }
		
		return $courseArr;
    } 
    
    // function'll return the allocated sets under each batch
    // @author GBS-L
    public function allocated_students_inbatch($batch_id)
    {
         $this->db->select('*');
         $query= $this->db->get_where('am_student_course_mapping',array("status"=>"1","batch_id"=>$batch_id));
         return $query->num_rows(); 
    }
    public function get_instalment_dudate($id = NULL)
    {
        $this->db->select('*');
        $this->db->from('am_batch_instalment_duedate');
        $this->db->where('batch_id', $id);
        $this->db->order_by('installment','ASC');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    public function get_fbatchStudents($fbatch) {
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->where('batch_id', $fbatch);
        $this->db->where('status', 1);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    
    public function update_fbatchStudents($fbatch,$studentArr) {
        $updateData = array('status' => 4);
        $this->db->where('batch_id', $fbatch);
        $this->db->where_in('student_id', $studentArr);
        $this->db->where('status', 1);
        $query= $this->db->update('am_student_course_mapping', $updateData);
        if($query){ 
            return 1;
        } else {
            return 0;
        }
    }

    public function get_eachStudents($fBatch,$studentArr) {
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->where('batch_id', $fBatch);
        $this->db->where_in('student_id', $studentArr);
        $this->db->where('status', 1);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }

    public function get_carrentActiveBatch()
    {
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->db->where('batch_status',1);
        $this->db->where('am_batch_center_mapping.batch_dateto >=',date('Y-m-d'));
        $this->db->order_by('am_batch_center_mapping.batch_id','desc');
	    $query	=	$this->db->get('');
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
}
