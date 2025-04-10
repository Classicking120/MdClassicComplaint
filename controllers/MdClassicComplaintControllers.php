 {! import('mdClassicComplaint', 'MdClassicComplaintModels.php') !}
<?php


function sendMail($subject, $recipientName, $to, $complaint_status_feedback){
              $message = "
                <html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>". $subject ."</title>
                    <style>
                            body { 
                                font-family: Arial, sans-serif; 
                                background-color: #f4f4f4; 
                                padding: 20px; 
                                margin: 0;
                                text-align: center;
                            }
                            .container { 
                                background-color: #fff; 
                                padding: 20px; 
                                border-radius: 8px; 
                                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
                                max-width: 500px; 
                                margin: 40px auto; 
                                text-align: left;
                            }
                            .logo { 
                                max-width: 120px; 
                                margin-bottom: 20px; 
                                display: block;
                                margin-left: auto;
                                margin-right: auto;
                                border-radius:10px;
                            }
                            h2 { 
                                color: #333; 
                                text-align: center;
                            }
                            p { 
                                color: #555; 
                                line-height: 1.6; 
                            }
                            .primary-btn {
                                display: inline-block;
                                padding: 6px 12px;
                                border-radius: 6px;
                                font-size: 16px;
                                font-weight: 500;
                                text-align: center;
                                text-decoration: none;
                                color: white !important;
                                background-color: #28a745;
                                border: 1px solid #28a745;
                                transition: background-color 0.3s ease, transform 0.2s ease;
                            }
                            
                            .primary-btn:hover {
                                background-color: #218838;
                                border-color: #1e7e34;
                                transform: scale(1.05);
                                 color: white !important;
                            }
                            
                            .primary-btn:active {
                                background-color: #1e7e34;
                                border-color: #1c7430;
                                transform: scale(0.95);
                            }

                            .footer {
                                margin-top: 20px;
                                font-size: 14px;
                                color: #777;
                            }
                        </style>
                </head>
                <body>
                    <div class='container'>
                        <img src='". lifetech_media_path() ."/lifetech_logo.png' class='logo text-center' width='50px' height='50px' alt='Ogitech Logo' > <!-- Company Logo -->
                        <p><b>Dear ".$recipientName."</b></p>
                        <div>". $complaint_status_feedback  ."</div>
                        
                        <br>
                        <div class='footer'>
                            <p><p>Note: Replies sent from your email will not be received, this is an automatically generated operational email forwarded by OGITECH.</p><br></p>
                            <p><b>©OGITECH Student Affairs Office ".date("Y")."</b></p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                
                // Always set content-type when sending HTML email
                 $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                // More headers
                $headers .= 'From: OGITECH <noreply@ogitech.edu.ng>' . "\r\n";
                
                mail($to,$subject,$message,$headers);
                 
            }

function feedbackSubjectArr($ticket_id){
    
    return [
        '1' =>  "Your Complaint Ticket ID: {$ticket_id} Has Been Escalated",
        '2' =>  "Your Complaint Ticket ID: {$ticket_id} is Pending",
        '3' =>  "Your Complaint Ticket ID: {$ticket_id} is In Progress",
        '4' =>  "Your Complaint Ticket ID: {$ticket_id} Has Been Resolved",
        '5' =>  "Your Complaint Ticket ID: {$ticket_id} Has Been Closed",
        '6' =>  "Your Complaint Ticket ID: {$ticket_id} Has Been Rejected",
        
    ];
} 

function feedbackStatusArr($ticket_id){
    return [
    '1' =>  "<p>We wanted to update you that your complaint with <strong> Ticket ID: {$ticket_id} </strong> has been <strong> Escalated </strong> to a higher authority for further resolution.</p>
            <p>We are committed to ensuring your issue is handled appropriately and will keep you informed of any progress.</p>
            <p> Thank you for your patience. </p>
            ",
    '2' => "<p>Thank you for submitting your complaint. We would like to inform you that your complaint with Ticket ID: <strong> {$ticket_id} </strong> has been received and is currently marked as <strong> Pending </strong></p>
            <p> We are committed to ensuring your issue is handled appropriately and will keep you informed of any progress. </p>
            <p> Thank you for your patience. </p>
            ",
    '3' =>  "<p>We wanted to let you know that your complaint with <strong> Ticket ID: {$ticket_id} </strong> is now being reviewed and is currently marked as <strong> In Progress </strong></p>
            <p>Our team is actively working on resolving your issue. We appreciate your patience and will keep you updated on any further developments.</p>
            <p> Best Regards </p>
            ",
    '4' =>  "<p>We’re pleased to inform you that your complaint with <strong> Ticket ID: {$ticket_id} </strong> has been marked as <strong> Resolved </strong></p>
            <p>Our team believes the issue has been successfully addressed. If you have any follow-up questions or if the issue persists, please do not hesitate to reach out.</p>
            <p> Best Regards </p>
            ",
    '5' =>  "<pWe’re writing to inform you that your complaint with <strong> Ticket ID: {$ticket_id} </strong> has been marked as <strong> Closed </strong></p>
            <p>No further action is required at this time. If you believe this is in error or need additional assistance, please do not hesitate to reach out.</p>
            <p> Best Regards </p>
            ",
    '6' =>  "<pWe’re writing to inform you that your complaint with <strong> Ticket ID: {$ticket_id} </strong> has been marked as <strong> Rejected </strong></p>
            <p>This means the complaint did not meet our criteria or lacked sufficient information. If you believe this was a mistake, please feel free to resubmit your complaint with more details.</p>
            <p> Best Regards </p>
            ",
    ];
}



if(Controller::post('complaintAction', 'valAddComplaint')){
    // global $staffResponse;
   ob_end_clean(); 
   
   $request = new Request;
 
    $submit_complaint = new Tb_submit_complaint;
    
    $user_input = trim(htmlspecialchars($request->userInput, ENT_QUOTES, 'UTF-8'));
    $user_input_auth = trim(htmlspecialchars($request->authUserID, ENT_QUOTES, 'UTF-8'));
    $title = trim(htmlspecialchars($request->title, ENT_QUOTES, 'UTF-8'));
    $description = trim(htmlspecialchars($request->description, ENT_QUOTES, 'UTF-8'));
    $complaint_status_code = '2';
    
    function complaint_ticket_id() {
        $letters = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3));
        $numbers = mt_rand(100000, 999999);
        return $letters .'-'. $numbers;
    }
    
        $ticket_id = complaint_ticket_id();
        
        
        $dateTime = date("Y-m-d H:i:s");
    
        $submit_complaint->complaint_by = $user_input;
        $submit_complaint->title = $title;
        $submit_complaint->description = $description;
        $submit_complaint->dateTime = $dateTime;
        $submit_complaint->created_at = $dateTime;
        $submit_complaint->complaint_ticket_id = $ticket_id;
        $submit_complaint->complaint_status = 'Pending';
        $submit_complaint->complaint_status_code = $complaint_status_code;
        $submit_complaint->lifetech_table_status = 1;
        $submit_complaint->lifetech_general_id = lifetech_general_id();
        
        if($user_input){
            $user = fetchUserId($user_input); //fetch user detail using matric no or username
        }else if($user_input_auth){
            $user = fetchUserById($user_input_auth); // fetch user detail using user login id 
        }
        
    if ($user){
        
        $recipient_name = ucwords(strtolower($user['lifetech_surname'])) ?? "User";
        $subject = "Complaint Submission Confirmation";
        $to = $user['lifetech_email'];
        $user_id = $user['lifetech_general_id'];
        $data = ['ticket_id' => $ticket_id];
        
        // fetching status message dynamically from feedbackStatusArr function
          $status_messages = feedbackStatusArr($ticket_id);
          $message = $status_messages[$complaint_status_code];
          

        if($_FILES['photo']['size'] > 0){
            
        
                 $dir_path = "lifemedia/complaint_photos";
                 $photo = $_FILES['photo']['name'];
                 $complaint_tmp_name = $_FILES['photo']['tmp_name'];
                 $complaint_image_size = $_FILES['photo']['size'];
                 $complaint_image_ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION)); //  using pahinfo php function to extract the file extension
                 $unique_id = $ticket_id.'_'.time();    //   Creating unique id by joining ticket id with current timestamp
                 $complaint_image_unique_name =$unique_id.".".$complaint_image_ext;  //   Creating unique name for the file by joining unique id with the file extension 
                 $complaint_image_path  = $dir_path.'/'. $complaint_image_unique_name;  // constructing file path for the file
                 $img_extension_array = ['jpg', 'jpeg', 'png'];    // Acceptable file extension

                 if (!is_dir($dir_path)) { /// to check if the directory exist, if not create new one
                        mkdir($dir_path, 0755, true); /// to create directory for image insertion
                    }
                    
                  if(in_array($complaint_image_ext, $img_extension_array)){ // checking if the image extension ($complaint_image_ext) is in img_extension_array

                        if ($complaint_image_size < 100000){ // 100KB = 100,000 bytes

                        if(move_uploaded_file($complaint_tmp_name, $complaint_image_path)){
                            
                                $submit_complaint->complaint_photo = $complaint_image_unique_name;
                                $submit_complaint->user_id = $user_id;

                                $submit_complaint->insert();
                                
                                sendMail($subject, $recipient_name, $to, $message);
                                
                                $response = Response::json($response_result= $submit_complaint->response_result, $response_code= $submit_complaint->response_code, $response_category= $submit_complaint->response_category, $response_data = $data);

                            }else{

                                $response = Response::json($response_result="Error Uploading File !!!", $response_code="105", $response_category="100");
                            }

                        }else{

                            $response = Response::json($response_result="File size! Image size must be below 100KB.", $response_code="108", $response_category="100");

                        }

                  }else{
                     $response = Response::json($response_result="Only jpg, png, jpeg files extension are allowed", $response_code="106", $response_category="100");

                 }
                 
        }else{
            
            $submit_complaint->user_id = $user_id;
            $submit_complaint->insert();
            sendMail($subject, $recipient_name, $to, $message);
            $response = Response::json($response_result= $submit_complaint->response_result, $response_code= $submit_complaint->response_code, $response_category= $submit_complaint->response_category, $response_data = $data);

            
        }

        
     }
     
     else{
         
         $response = Response::json($response_result="Sorry, Student info $user_input does not exist", $response_code="101", $response_category="100");
    }
    
    echo $response;
    
    exit();
    
}




if(Controller::post('searchTicketAction', 'valSearchValue')){

    ob_end_clean(); 

        $request = new Request;
 
        $complaint_response_instance = new Tb_submit_complaint;
        
        $searchTicket = trim(htmlspecialchars($request->searchInputValue, ENT_QUOTES, 'UTF-8'));
        $searchUser = trim(htmlspecialchars($request->userEmail, ENT_QUOTES, 'UTF-8'));
        
        // $queryUser = $registered_instance->select()->where('lifetech_email', '=', $searchUser)->get();
        
        $user = fetchUserId($searchUser);
        
        if($user){  ///  Checking if user record exist
            
            if($searchTicket == ''){  // if the user record exists, then check if ticket ID is not empty.
                
                $queryAllTicket = $complaint_response_instance->select()->where('user_id', '=', $user['lifetech_general_id'])->orderBy('complaint_status_code ASC')->get();   // If no Ticket ID is provided, fetch all tickets associated with this user.
                
                    if(count($queryAllTicket)){
                        
                        $response = Response::json($response_result="Record fetched", $response_code= $complaint_response_instance->response_code, $response_category= $complaint_response_instance->response_category, $response_data = $queryAllTicket);
                        
                    }else{
                        
                        $response = Response::json($response_result= "There is no complaint record for this user.", $response_code= $complaint_response_instance->response_code, $response_category= $complaint_response_instance->response_category);
         
                    }
                
                
            }else{
                
                $querySingleTicket = $complaint_response_instance->select()->where('complaint_ticket_id', '=', $searchTicket)->andWhere('user_id', '=', $user['lifetech_general_id'])->get(); // If the Ticket ID is provided, fetch tickets associated with this user baesd on the ticket ID.
                
                if(count($querySingleTicket) > 0){
                    $data = ['id' => $querySingleTicket[0]->lifetech_general_id, 'complaint_photo' =>$querySingleTicket[0]->complaint_photo, 'ticket_id' => $querySingleTicket[0]->complaint_ticket_id, 'complaint_status' => $querySingleTicket[0]->complaint_status, 'title' => $querySingleTicket[0]->title, 'user_id' => $querySingleTicket[0]->user_id, 'description' =>  $querySingleTicket[0]->description, 'created_at' =>  date("d-M-Y h:i a",strtotime($querySingleTicket[0]->created_at)) ];
                    $response = Response::json($response_result= 'Record fetched', $response_code= $complaint_response_instance->response_code, $response_category= $complaint_response_instance->response_category, $response_data = $data);
                }else{
                    
                    $response = Response::json($response_result= "Invalid Ticket ID", $response_code= $complaint_response_instance->response_code, $response_category= $complaint_response_instance->response_category);
     
                }
                
                
            }
            
        }else{
            
           $response = Response::json($response_result= "Invalid User Details", $response_code= $registered_instance->response_code);
        }

       echo $response;
       

    exit();
    

}


if(Controller::post('updateStatusAction', 'valEditStatus')){
    ob_end_clean();
    
      $request= new Request; 
        
      $submit_complaint = new Tb_submit_complaint;
        
      $complaint_ticket_id = $request->complaintID;
       
      $data = $submit_complaint->findId($complaint_ticket_id);
    
        $data = ['complaint_status' => $submit_complaint->response_result->complaint_status, 'complaint_status_code' => $submit_complaint->response_result->complaint_status_code];
      $response = Response::json($response_result = "Record Fetch", $response_code= $submit_complaint->response_code, $response_category= $submit_complaint->response_category, $response_data = $data);
       
      echo $response;
     
     exit();
}


// For Update
if(Controller::post('updateStatusAction', 'valUpdateStatus')){
    ob_end_clean();
    
      $request= new Request; 
        
      $submit_complaint = new Tb_submit_complaint;
        
      $complaint_general_id = trim(htmlspecialchars($request->complaintID, ENT_QUOTES, 'UTF-8'));
      $complaint_status_code = trim(htmlspecialchars($request->complaintStatusValue, ENT_QUOTES, 'UTF-8'));
      $complaint_status = trim(htmlspecialchars($request->complaintStatusText, ENT_QUOTES, 'UTF-8'));
      $submit_complaint->complaint_status_code = $complaint_status_code;
      $submit_complaint->complaint_status = $complaint_status;
      
      
      $query_complaint_details = $submit_complaint->select('user_id, complaint_ticket_id')->where('lifetech_general_id', '=', $complaint_general_id)->get()[0];  // fetching complaints details using $complaint_general_id
      
      $user_info = fetchUserById($query_complaint_details->user_id);
      
      if($user_info){

          $recipient_name = ucwords(strtolower($user_info['lifetech_surname'])) ?? "User";
          $to = $user_info['lifetech_email'];
          $ticket_id = $query_complaint_details->complaint_ticket_id;
          
          // fetching status message dynamically from feedbackStatusArr function
          $status_messages = feedbackStatusArr($ticket_id);
          $selected_message = $status_messages[$complaint_status_code];
          
          // fetching status subject dynamically from feedbackSubjectArr function
          $status_subject = feedbackSubjectArr($ticket_id);
          $selected_subject = $status_subject[$complaint_status_code];
          
          $submit_complaint->update('lifetech_general_id', '=', $complaint_general_id);
        
        if($submit_complaint->response_category == '200'){
            
            sendMail($selected_subject, $recipient_name, $to, $selected_message);
            $data = ['complaint_status' => $complaint_status, 'complaint_status_code' => $complaint_status_code];
            $response = Response::json($response_result = $submit_complaint->response_result, $response_code= $submit_complaint->response_code, $response_category= $submit_complaint->response_category, $response_data = $data);
       
        }else{
             $response = Response::json($response_result = $submit_complaint->response_result, $response_code= $submit_complaint->response_code, $response_category= $submit_complaint->response_category);
       
        }
          
          
      }
   
      echo $response;
    
     
     exit();
}

// for fetching summary

if(Controller:: post('fetchRecordAction', 'valFetchRecord')){
    ob_end_clean();
    global $lifetech_connect2db;
    
    $request= new Request; 
        
    $submit_complaint = new Tb_submit_complaint;
    
    $statusValue = trim(htmlspecialchars($request->statusValue, ENT_QUOTES, 'UTF-8'));
    
    if($statusValue == '0'){
        
        $sql = "SELECT * FROM tb_submit_complaint 
        WHERE complaint_status_code IN (?, ?, ?)
        ORDER BY complaint_status_code ASC
        ";
        $stmt = $lifetech_connect2db->prepare($sql);
        $stmt->execute(['1', '2', '3']);
        $submit_complaint_getValue = $stmt->fetchAll();
        
    }else{
        $submit_complaint_getValue = $submit_complaint->select()->where('complaint_status_code', '=', $statusValue)->get();
    }
    
    if(count($submit_complaint_getValue) > 0){
        
        $response = Response::json($response_result = 'Record Fetched', $response_code= '201', $response_category= '200', $response_data = $submit_complaint_getValue);
    }else{
         $response = Response::json($response_result = 'No Record Found', $response_code= '101', $response_category= '100');
    }
       
    
    echo $response;
    
    
    
    exit();
}

///  Fetch Ticket feedback
if(Controller::post('fetchTicketAction', 'fetchTicketHistory')){
    ob_end_clean();
    
        $request= new Request;
        
        $complaint_feedback_instance = new Tb_complaint_feedback;
        $registered_instance = new Tb_registrations;
        
        $complaint_ticket_id = trim(htmlspecialchars($request->ticketID, ENT_QUOTES, 'UTF-8'));
        
        $queryFeedback = $complaint_feedback_instance->select()->where('complaint_ticket_id', '=', $complaint_ticket_id)->orderBy('created_at ASC')->get();
        
       if(count($queryFeedback) > 0){
           
           $response = Response::json($response_result = 'Record Fetched', $response_code= '201', $response_category= '200', $response_data = $queryFeedback);
           
       }else{
           $response = Response::json($response_result = 'No Record Found', $response_code= '101', $response_category= '100');
       };
        
     echo $response;
    exit();
}

/// reply ticket feedback
if(Controller::post('replyAction', 'valAddReplyAction')){
    ob_end_clean();
    
    $request= new Request;
    $complaint_feedback_instance = new Tb_complaint_feedback;
    $submit_complaint = new Tb_submit_complaint;
    
    $complaint_ticket_id = trim(htmlspecialchars($request->ticketID, ENT_QUOTES, 'UTF-8'));
    $complaint_response = trim(htmlspecialchars($request->message, ENT_QUOTES, 'UTF-8'));
    $sender = trim(htmlspecialchars($request->sender, ENT_QUOTES, 'UTF-8'));
    $user_id = trim(htmlspecialchars($request->user_id, ENT_QUOTES, 'UTF-8'));
    
    $dateTime = date("Y-m-d H:i:s");
    
    $complaint_feedback_instance->complaint_response = $complaint_response;
    $complaint_feedback_instance->user_id = $user_id;
    $complaint_feedback_instance->complaint_ticket_id = $complaint_ticket_id;
    $complaint_feedback_instance->created_at = $dateTime;
    $complaint_feedback_instance->sender = $sender;
    $complaint_feedback_instance->lifetech_general_id = lifetech_general_id();
    
    if($sender === 'Admin'){
            $query_complaint_details = $submit_complaint->select('user_id')->where('complaint_ticket_id', '=', $complaint_ticket_id)->get()[0];  // fetching complaints details using $complaint_general_id
            $user_info = fetchUserById($query_complaint_details->user_id);
            
            if($user_info){
                $recipient_name = ucwords(strtolower($user_info['lifetech_surname'])) ?? "User";
                $to = $user_info['lifetech_email'];
                $subject = "Complaint Reply Notification";
                $message = "
                        <p>We would like to inform you that your complaint with <strong>Ticket ID: {$complaint_ticket_id} </strong> has received a new reply from our support team.</p>
                        <p><strong>Admin's Reply:</strong></p>
                        <blockquote style='background-color: #fff; padding: 15px; border-left: 4px solid #007bff;'> {$complaint_response}</blockquote>
                        <p>To view this message and any further responses, please visit the <strong>Search Complaint</strong> section on your student portal.</p>
                        ";
            }
    }
    
    $complaint_feedback_instance->insert();
    
    if($complaint_feedback_instance->response_category == '200'){
        if($sender === 'Admin'){
            sendMail($subject, $recipient_name, $to, $message);
        }
        $data = ['sender' => $sender, 'complaint_response' => $complaint_response,  'created_at' => $dateTime];
        $response = Response::json($response_result= $complaint_feedback_instance->response_result, $response_code= $complaint_feedback_instance->response_code, $response_category= $complaint_feedback_instance->response_category, $response_data = $data);

    }else{
        
        $response = Response::json($response_result = $complaint_feedback_instance->response_result, $response_code= $complaint_feedback_instance->response_code, $response_category= $complaint_feedback_instance->response_category);
       
    }
    
  echo $response;
    
    
    exit();
}



// fetch note ticket
if(Controller::post('notesTicketAction', 'fetchTicketNotes')){
    ob_end_clean();
    
        $request= new Request;
        
        $complaint_notes_instance = new Tb_complaint_notes;
        $registered_instance = new Tb_registrations;
        
        $complaint_ticket_id = trim(htmlspecialchars($request->ticketID, ENT_QUOTES, 'UTF-8'));
        
        $queryNotes = $complaint_notes_instance->select()->where('complaint_ticket_id', '=', $complaint_ticket_id)->orderBy('created_at ASC')->get();
        
        // $data = [];
        
       if(count($queryNotes) > 0){
           $allNotes = [];
           
           foreach($queryNotes as $data){
               $staff_id = $data->user_id;
               
               $queryFetchStudent = $registered_instance->select('lifetech_username')->where('user_id', '=', $staff_id)->get()[0];
               $allNotes[] = ['notes' => $data->complaint_note, 'created_at' => $data->created_at, 'username' => $queryFetchStudent->lifetech_username, 'complaint_ticket_id' => $data->complaint_ticket_id];
               
               $response = Response::json($response_result = 'Record Fetched', $response_code= '201', $response_category= '200', $response_data = $allNotes);
               
           }
           
       }else{
           $response = Response::json($response_result = 'No Record Found', $response_code= '101', $response_category= '100');
       };
        
     echo $response;
     
    exit();
}

// reply note ticket
if(Controller::post('noteAction', 'valAddNoteAction')){
    ob_end_clean();
    
    $request= new Request;
     $complaint_notes_instance = new Tb_complaint_notes;
     $registered_instance = new Tb_registrations;
    
    $complaint_ticket_id = trim(htmlspecialchars($request->ticketID, ENT_QUOTES, 'UTF-8'));
    $complaint_response = trim(htmlspecialchars($request->message, ENT_QUOTES, 'UTF-8'));
    $user_id = trim(htmlspecialchars($request->user_id, ENT_QUOTES, 'UTF-8'));
    
    $dateTime = date("Y-m-d H:i:s");
    
    $complaint_notes_instance->complaint_note = $complaint_response;
    $complaint_notes_instance->user_id = $user_id;
    $complaint_notes_instance->complaint_ticket_id = $complaint_ticket_id;
    $complaint_notes_instance->created_at = $dateTime;
    $complaint_notes_instance->lifetech_general_id = lifetech_general_id();
    
    $queryFetchUsername = $registered_instance->select('lifetech_username')->where('user_id', '=', $user_id)->get()[0];
    
    
    $complaint_notes_instance->insert(); 
    $data =  ['username' => $queryFetchUsername->lifetech_username, 'conplaint_note' => $complaint_response, 'complaint_ticket_id' => $complaint_ticket_id, 'created_at' => $dateTime];

    
     $response = Response::json($response_result= $complaint_notes_instance->response_result, $response_code= $complaint_notes_instance->response_code, $response_category= $complaint_notes_instance->response_category, $response_data = $data);

    echo $response;
    
    
    exit();
}

















?>
      
      
      
      
      
      
      
      
      
      
      
      
      
           
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      