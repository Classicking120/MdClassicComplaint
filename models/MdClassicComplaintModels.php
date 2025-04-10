<?php

date_default_timezone_set('Africa/Lagos');

if (!class_exists('tb_submit_complaint')) { 

class Tb_submit_complaint extends Model{}
 
}


if (!class_exists('tb_complaint_feedback')) { 

class Tb_complaint_feedback extends Model{}
 
}

if (!class_exists('tb_complaint_notes')) { 

class Tb_complaint_notes extends Model{}
 
}

if (!class_exists('tb_lifetech_lms_add_student')) { 

class Tb_lifetech_lms_add_student extends Model{}
 
}
 

function fetchUserId($user){
     
         
    
    $student_instance = new Tb_lifetech_lms_add_student;
   
    $queryUser = $student_instance->select()->where('lifetech_matno', '=', $user)->orWhere('lifetech_username', '=', $user)->get();
    
    if(count($queryUser) > 0 ){
        
        $response = ['lifetech_general_id' => $queryUser[0]->lifetech_general_id, 'lifetech_username' =>$queryUser[0]->lifetech_username, 'lifetech_email' => $queryUser[0]->lifetech_email, 'lifetech_surname' => $queryUser[0]->lifetech_surname ];
        return $response;
    }else{
        
        return false;
    }
    
}

function fetchUserById($user_id){
    
    $student_instance = new Tb_lifetech_lms_add_student;
    $queryUser = $student_instance->select()->where('lifetech_general_id', '=', $user_id)->get();
    
    if(count($queryUser) > 0 ){
        
        $response = ['lifetech_general_id' => $queryUser[0]->lifetech_general_id, 'lifetech_username' =>$queryUser[0]->lifetech_username, 'lifetech_email' => $queryUser[0]->lifetech_email, 'lifetech_surname' => $queryUser[0]->lifetech_surname ];
        return $response;
    }else{
        
        return false;
    }
    
}









?>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      