<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     
$(function(){
    


//// function to pop up modal

function controlModal(modalId, type){
    if(type == 'show'){
    let myModal = new bootstrap.Modal(document.getElementById(modalId));
        
        myModal.show();
    }else if(type == 'hide'){
        let myModalEl = document.getElementById(modalId);
        let modal = bootstrap.Modal.getInstance(myModalEl);
        modal.hide();
    }
}
        
function scrollToBottom() {
    //  Auto-scroll to latest reply after appending
    let chatBox = document.getElementById("repliesSection");
    chatBox.scrollTop = chatBox.scrollHeight;
}
        
 function formatTime (timeString){
     return new Date(timeString).toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
 } 
 
 
 $(document).on('change', '#picture', function(event){
    const previewContainer = document.getElementById("previewContainer");
    const imagePreview = document.getElementById("imagePreview");

    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            previewContainer.style.display = "block"; // Show the preview section
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = "";
        previewContainer.style.display = "none"; // Hide preview if invalid or no file
    }
 })

 
 $(document).on('click', '#complaintSubmit', function(e){
     e.preventDefault();

let button = $(this);
button.html(`<div class="loader"></div>`);     
                     
 let userInput = document.querySelector('#userInput');
 let authUserID = document.querySelector('#authUserID');
 let complaintTitle = document.querySelector('#title').value;
 let textarea = document.querySelector('#description').value.trim();   //
 
 
 if(userInput){
      if(userInput.value === ''){
         Swal.fire('Notice!!!', 'Please enter your username, or matric number.', 'warning').then(function(){
             button.html(`Submit Complaint`);
         });
         return;
     }
 }
 
 if(authUserID){
      if(authUserID.value === ''){
         Swal.fire('Notice!!!', 'Please log in before submitting your complaint.', 'warning').then(function(){
             button.html(`Submit Complaint`);
         });
         return;
     }
 }

 
 if(complaintTitle === ''){
     Swal.fire('Notice!!!', 'Please enter your complaint title', 'warning').then(function(){
         button.html(`Submit Complaint`);
     });
     return;
 }
 
 if(textarea === ''){
     Swal.fire('Notice!!!', `Sorry, you can't submit an empty complaint.`, 'warning').then(function(){
         button.html(`Submit Complaint`);
     });
     return;
 }
 
 let formData = new FormData(document.getElementById('myForm'));
 formData.append('complaintAction', 'valAddComplaint');
 
     $.ajax({
         method:"POST",
         data: formData,
         dataType: "JSON",
         contentType: false,
         processData: false,
         success: function(response){
             let responseCode = response.response_code;
             let responseCategory = response.response_category;
             let responseResult = response.response_result;
             let responseData = response.response_data;
             
             if(responseCategory == '200'){
                 
                 Swal.fire({ title: 'Bravo', html: `Your complaint has been submitted successfully. <br> <b>Ticket ID: ${responseData.ticket_id} </b>`, icon: 'success', draggable: true }).then(function(){
                     document.getElementById('myForm').reset();
                     document.getElementById("wordCount").textContent = `${0} / 100 words`;
                     button.html(`Submit Complaint`);
                     document.getElementById("previewContainer").style.display = "none";
                 })
                
             }else{
                 
                 Swal.fire('Notice!!!', responseResult , 'warning').then(function(){
                     button.html(`Submit Complaint`);
                     
                 });
             }
         },
         error:function(error){
             console.error(`Ajax Error: ${error}`);
             button.html(`Submit Complaint`);
         }
      })
 })
 
 
 
$(document).on('click', '#search_button_student', function(e) {
            e.preventDefault();
            let button = $(this);
            button.html(`<div class="loader"></div>`);
            const searchInputValue = $('#search_input').val();
            const userEmail = $('#email').val();
            
            if( searchInputValue == ''){
                Swal.fire('Notice', 'Enter a value in the search box to begin your search.', 'warning').then(function(){
                    
                    button.html(`<i class="bi bi-search"></i> Search`);
                });
                    return;
            }
            if( userEmail == ''){
                Swal.fire('Notice', 'Kindly enter your Matric No or Email.', 'warning').then(function(){
                    
                        button.html(`<i class="bi bi-search"></i> Search`);
                });
                    return;
            }
            
            $.ajax({
                method:"POST",
                data:{searchInputValue, userEmail, 'searchTicketAction': "valSearchValue"},
                dataType: "JSON",
                success: function(response){
                    const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;
                    
                    if(responseCategory == '200'){
                         $('#complaintID').html(`<span> <span class="fw-bold">Ticket ID: </span>  ${responseData.ticket_id} </span>`);
                         $('#complaintStatus').html(`<span> <span class="fw-bold">Complaint Status: </span> ${responseData.complaint_status} </span>`);
                         $('#user_id').val(responseData.user_id);
                         let imgPath = (responseData.complaint_photo) ? `complaint_photos/${responseData.complaint_photo}` : "no_image.jpg";
                    
                        let tableBody = $('#example tbody');
    
                        // Remove "No data available" row if present
                        let emptyRow = tableBody.find('tr td');
                        if (emptyRow.length > 0) {
                            tableBody.html(''); // Remove all rows if empty message exists
                        }
        
                        let counter = tableBody.find('tr').length + 1;;
                          let newRow = `
                                <tr>
                                    <td>${counter}</td>
                                    <td>${responseData.ticket_id}</td>
                                    <td>${responseData.title}</td>
                                    <td>${responseData.description}</td>
                                    <td>${responseData.complaint_status}</td>
                                    <td>${responseData.created_at}</td>
                                    <td>
                                        <img src="{!lifetech_media_path()!}/${imgPath}" alt="logo" width="80" height="80"; style="border-radius: 10px; cursor: pointer;" title="Click to preview image" data-path="${imgPath}" id="previewImage">
                                    </td>
                                     <td>
                                      <button type="button" class="btn btn-warning mt-1" id="searchTicketResponse" data-id = "${responseData.ticket_id}" title="Click here to provide feedback on the complaint"><i class="bi bi-chat-dots"></i> Feedback</button>
                                     </td>
                                </tr>
                          `;
                          
                        tableBody.append(newRow);
                        
                        $('#displayComplaint')
                                .removeClass('d-none') // Ensure it's visible
                                .css('opacity', 0)      // Start with opacity 0
                                .slideDown(800)         // Slide down smoothly
                                .animate({ opacity: 1 }, { queue: false, duration: 1200 }); // Fade in
                        button.html(`<i class="bi bi-search"></i> Search`);
                    }else{
                        Swal.fire('Oops!!!', responseResult, 'warning').then(function(){
                            button.html(`<i class="bi bi-search"></i> Search`);
                        })
                    }
                    
                   
                },
                error: function (error){
                    console.error(`Ajax Error: ${error}`);
                    button.html(`<i class="bi bi-search"></i> Search`);
                }
            })
    
        })
 
$(document).on('click', '#search_button', function(e) {
    e.preventDefault();
    let button = $(this);
    button.html(`<div class="loader"></div>`);
    const userEmail = $('#email').val();

    if( userEmail == ''){
        Swal.fire('Notice', 'Kindly enter your Matric No or Username.', 'warning').then(function(){
            
                button.html(`<i class="bi bi-search"></i> Search`);
            return;
        });
    }
    
    $.ajax({
        method:"POST",
        data:{userEmail, 'searchTicketAction': "valSearchValue"},
        dataType: "JSON",
        success: function(response){
            const responseData = response.response_data;
            const responseCategory = response.response_category;
            const responseResult = response.response_result;
            
            if(responseCategory == '200'){
                
                
                let table = $('#example').DataTable();
                table.clear();
            
                $.each(responseData, function (index, data) {
                    let imgPath = (data.complaint_photo) ? `complaint_photos/${data.complaint_photo}` : "no_image.jpg";
                    table.row.add([
                        index + 1,
                        data.complaint_ticket_id,
                        data.title,
                        data.description,
                        data.created_at,
                        data.complaint_status,
                        `<img src="{!lifetech_media_path()!}/${imgPath}" alt="logo" width="80" height="80"; style="border-radius: 10px; cursor:pointer" title="Click to preview image" data-path="${imgPath}" id="previewImage">`,
                        `
                        <button type="button" class="btn btn-primary" id="editStatus" data-id = "${data.lifetech_general_id}" title="Click here to update complaint status"><i class="bi bi-pen"></i> Update</button>
                        <button type="button" class="btn btn-secondary" id="searchTicketNote" data-id = "${data.complaint_ticket_id}" title="Click here to add notes"><i class="bi bi-journal-text"></i> Notes</button>
                        <button type="button" class="btn btn-warning mt-1" id="searchTicketResponse" data-id = "${data.complaint_ticket_id}" title="Click here to provide feedback on the complaint"><i class="bi bi-chat-dots"></i> Feedback</button>
                        
                        `
                    ]);
                });
                
            
                table.draw();
                
                 $('#displayComplaint')
                        .removeClass('d-none') // Ensure it's visible
                        .css('opacity', 0)      // Start with opacity 0
                        .slideDown(800)         // Slide down smoothly
                        .animate({ opacity: 1 }, { queue: false, duration: 1200 }); // Fade in
                        $('#email').val('');
                button.html(`<i class="bi bi-search"></i> Search`);
                
            }else{
                Swal.fire('Oops!!!', responseResult, 'warning').then(function(){
                    button.html(`<i class="bi bi-search"></i> Search`);
                })
            }
            
           
        },
        error: function (error){
            console.error(`Ajax Error: ${error}`);
            button.html(`<i class="bi bi-search"></i> Search`);
        }
    })

})
     

$(document).on('click', '.summary', function(){
    let button = $(this);
    let currentText = button.find('.status-text').text();
    button.find('.status-text').html(`<div class="spinner-border spinner-border-sm"></div>`);
    
    const statusValue = button.data('id');
    
    $.ajax({
        method: "POST",
        data: {statusValue, 'fetchRecordAction' : 'valFetchRecord'},
        dataType: "JSON",
        success: function(response){
            const responseData = response.response_data;
            const responseCategory = response.response_category;
            
            if(responseCategory == '200'){
            
            let table = $('#example').DataTable();
            table.clear();
            
                $.each(responseData, function (index, data) {
                     let imgPath = (data.complaint_photo) ? `complaint_photos/${data.complaint_photo}` : "no_image.jpg";
                    table.row.add([
                        index + 1,
                        data.complaint_ticket_id,
                        data.title,
                        data.description,
                        data.created_at,
                        data.complaint_status,
                        `<img src="{!lifetech_media_path()!}/${imgPath}" alt="logo" width="80" height="80"; style="border-radius: 10px" title="Click to preview image" data-path="${imgPath}" id="previewImage">`,
                        `
                        <button type="button" class="btn btn-primary" id="editStatus" data-id = "${data.lifetech_general_id}" title="Click here to update complaint status"><i class="bi bi-pen"></i> Update</button>
                        <button type="button" class="btn btn-secondary" id="searchTicketNote" data-id = "${data.complaint_ticket_id}" title="Click here to add notes"><i class="bi bi-journal-text"></i> Notes</button>
                        <button type="button" class="btn btn-warning mt-1" id="searchTicketResponse" data-id = "${data.complaint_ticket_id}" title="Click here to provide feedback on the complaint"><i class="bi bi-chat-dots"></i> Feedback</button>
                        
                        `
                    ]);
                });
                
            
                table.draw();
               button.find('.status-text').text(currentText);                     
            }else{
                Swal.fire('Oops!!!', responseResult, 'warning').then(function(){
                    button.find('.status-text').text(currentText);
                })
            }
            
            
        },
        error: function(error){
            console.error (`Ajax Error: ${error}`);
            button.find('.status-text').text(currentText);
        }
    })
    
})    
        
    // Edit Complaint Status
  $(document).on('click', '#editStatus', function(){
             
     let button = $(this);
     let complaintID =button.data('id');
     
     $.ajax({
         method:"POST",
         data:{complaintID, 'updateStatusAction': 'valEditStatus'},
         dataType:"JSON",
         success: function(response){
                const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;
                
                if(responseCategory == '200'){
                    $('#complaintStatus').val(responseData.complaint_status_code);
                    $('#complaint_updateID').val(complaintID);
                    // $('#updateModal').modal('show');
                    
                    controlModal('updateModal', 'show');
                    
                }else{
                    swal('Oops!!!', responseResult, 'warning');
                }
         },
         error: function(error){
             console.error(`Ajax Error: ${error}`);
         }
     })

  })
          
          
          
///// Update complaint status 
$(document).on('click', '#btnUpdateComplaint', function(){
  let button = $(this);
  
  let complaintID = $('#complaint_updateID').val();
  
  let complaintStatusValue = $('#complaintStatus option:selected').val();
  let complaintStatusText = $('#complaintStatus option:selected').text();
  
  $.ajax({
      method:"POST",
      data: {
          complaintID,
          complaintStatusValue,
          complaintStatusText,
          "updateStatusAction": "valUpdateStatus"
      },
      dataType: "JSON",
      success: function(response){
          const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;
            
            if(responseCategory == '200'){
                Swal.fire('Bravo!!!', `Complaint Status updated to ${responseData.complaint_status} successfully`, 'success').then(function(){
                    
                    let row = $('#example tbody').find(`button.btn.btn-primary[data-id*="${complaintID}"]`).closest('tr');
                        row.find('td:eq(5)').text(responseData.complaint_status);    
                    
                    $('.btn-close').trigger('click');
                    
                    //  controlModal('updateModal', 'hide');
                })
            }else{
                 Swal.fire('Oops!!!', responseResult, 'warning');
            }
            
            
      },
      error: function(error){
          console.error(`Ajac Error: ${error}`);
      }
  })
              
})
  
  
///////////////     FEEDBACK AND NOTES  EVENT ///////////////////////      
        
    // Fetch ticket Feedback       
$(document).on('click', '#searchTicketResponse', function(){
      
      let button = $(this);   
      
      button.html(`<div class="loader"></div>`);
      
      let ticketID = button.data('id');
      $('#ticket_id').val(ticketID);
      
      $.ajax({
          method:'POST',
          data:{ticketID, 'fetchTicketAction': 'fetchTicketHistory'},
          dataType:"JSON",
          success: function(response){
              
              const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;
              
              if(responseCategory == '200'){
                  
                  // Display replies in a chat format
                    var repliesHtml = '';
                    responseData.forEach(reply => {
                        let alignment = reply.sender === 'Admin' ? 'admin-message' : 'student-message';
                            repliesHtml += `
                                <div class="chat-message ${alignment}">
                                    <small>${reply.sender} - ${formatTime(reply.created_at)}</small>
                                    <p>${reply.complaint_response}</p>
                                </div>
                            `;
                        });
                  
                  $('#repliesSection').html(repliesHtml);
                  
                  button.html(`<i class="bi bi-chat-dots"></i> Feedback`);
              }else{
                  $('#repliesSection').html('<p>No replies yet.</p>');
                  button.html(`<i class="bi bi-chat-dots"></i> Feedback`);
              }
              $('.reply').text('Reply');
              $('.reply').attr('id', 'btnAddReply');
              $('#myModalLabel').text('Feedback');
              controlModal('responseModal', 'show');

          },
          error: function(error){
              console.error(`Ajax Error: ${error}`);
              
              button.html(`<i class="bi bi-chat-dots"></i> Feedback`);
          }
          
      })
      

  })
  
//   Add reply to the feedback
  
$(document).on('click', '#btnAddReply', function(e){
      e.preventDefault();
      let button = $(this);
      button.html(`<div class="loader"></div>`);
      
      let user_id = $('#user_id').val();
      let message = $('#description').val().trim();
      let sender = $('#user_id').data('sender'); // Or 'Admin' based on form
      let ticketID = $('#ticket_id').val(); // Or 'Admin' based on form
      
       if(message === ''){
             Swal.fire('Notice!!!', `Sorry, you can't submit an empty complaint.`, 'warning').then(function(){
                 button.html(`<span>Reply</span>`);
             });
             return;
         }
         if(user_id == '0'){
             Swal.fire('Notice!!!', `Sorry, you can't reply without user ID`, 'warning').then(function(){
                  button.html(`<span>Add Note</span>`);
             });
             return;
         }

      
      $.ajax({
          method:"POST",
          data:{user_id, message, sender, ticketID, 'replyAction': 'valAddReplyAction'},
          dataType:"JSON",
          success: function(response){
              
              const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;

              if(responseCategory == '200'){
                  let alignment = responseData.sender === 'Admin' ? 'admin-message' : 'student-message';
                  let repliesHtml = `
                        <div class="chat-message ${alignment}">
                            <small>${responseData.sender} - ${formatTime(responseData.created_at)}</small>
                            <p>${responseData.complaint_response}</p>
                        </div>
                    `;
                    
                    button.html(`<span>Reply</span>`);
                    
                    // removing the No replies yet text before appending the new message
                    if ($('#repliesSection').html().trim() === '<p>No replies yet.</p>') {
                            $('#repliesSection').html(repliesHtml);
                        }else{
                            $('#repliesSection').append(repliesHtml);
                            scrollToBottom();  // calling auto scroll function after appending the new replies
                        }
                    
                    $('#description').val('');
               }else{
                  
                  Swal.fire('Notice!!!', responseResult, 'warning').then(function(){
                     button.html(`<span>Reply</span>`);
                 });
                  
               }
          },
          error: function(error){
              console.error(`Ajax Error: ${error}`);
              button.html(`<span>Reply</span>`);
          }
      })
      
  })
  
      /// Fetch ticket Note
$(document).on('click', '#searchTicketNote', function(){
      
      let button = $(this);   
      
      button.html(`<div class="loader"></div>`);
      
      
      let ticketID = button.data('id');
      $('#ticket_id').val(ticketID);
 
      $.ajax({
          method:'POST',
          data:{ticketID, 'notesTicketAction': 'fetchTicketNotes'},
          dataType:"JSON",
          success: function(response){
              
              const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;
              
                  let repliesHtml = '';
              if(responseCategory == '200'){
                  // Display replies in a chat format
                    responseData.forEach(reply => {
 
                            repliesHtml += `
                                <div class="chat-message admin-message">
                                    <small>${reply.username} - ${formatTime(reply.created_at)}</small>
                                    <p>${reply.notes}</p>
                                </div>
                            `;
                        });
                  
                  $('#repliesSection').html(repliesHtml);
                  
                  button.html(`<i class="bi bi-journal-text"></i> Notes`);
              }else{
                  $('#repliesSection').html('<p>No notes yet.</p>');
                  button.html(`<i class="bi bi-journal-text"></i> Notes`);
              }
              $('.reply').text('Add Note');
              $('.reply').attr('id', 'btnReplyNote');
              $('#myModalLabel').text('Notes');
              controlModal('responseModal', 'show');

          },
          error: function(error){
              console.error(`Ajax Error: ${error}`);
              
              button.html(`<i class="bi bi-journal-text"></i> Notes`);
          }
          
      })
      

  })
     
        // Add Note Reply
$(document).on('click', '#btnReplyNote', function(e){
      e.preventDefault();
      let button = $(this);
      button.html(`<div class="loader"></div>`);
      
      let user_id = $('#user_id').val();
      let message = $('#description').val().trim();
      let ticketID = $('#ticket_id').val(); // Or 'Admin' based on form
      
       if(message === ''){
             Swal.fire('Notice!!!', `Sorry, you can't submit an empty Note.`, 'warning').then(function(){
                  button.html(`<span>Add Note</span>`);
             });
             return;
         }
       if(user_id == '0'){
             Swal.fire('Notice!!!', `Sorry, you can't reply without user ID, kindly login to add note.`, 'warning').then(function(){
                  button.html(`<span>Add Note</span>`);
             });
             return;
         }

      $.ajax({
          method:"POST",
          data:{user_id, message, ticketID, 'noteAction': 'valAddNoteAction'},
          dataType:"JSON",
          success: function(response){
              
              const {response_result:responseResult, response_code:responseCode, response_category:responseCategory, response_data:responseData} = response;

              if(responseCategory == '200'){
                  let repliesHtml = `
                        <div class="chat-message admin-message">
                            <small>${responseData.username} - ${formatTime(responseData.created_at)}</small>
                            <p>${responseData.conplaint_note}</p>
                        </div>
                    `;
                    
                    button.html(`<span>Add Note</span>`);
                    
                    // removing the No notes yet text before appending the new message
                    if ($('#repliesSection').html().trim() === '<p>No notes yet.</p>') {
                            $('#repliesSection').html(repliesHtml);
                        }else{
                            $('#repliesSection').append(repliesHtml);
                            scrollToBottom();  // calling auto scroll function after appending the new replies
                        }
                    
                    $('#description').val('');
               }else{
                  
                  Swal.fire('Notice!!!', responseResult, 'warning').then(function(){
                     button.html(`<span>Add Note</span>`);
                 });
                  
               }
          },
          error: function(error){
              console.error(`Ajax Error: ${error}`);
               button.html(`<span>Add Note</span>`);
          }
      })
      
  })
 
 
///////////////     FEEDBACK AND NOTES  EVENT ///////////////////////  

$(document).on('click', '#previewImage', function(){
    let imagePath = $(this).data('path');
    const basePath = "{!lifetech_media_path()!}"; 
    const filePath = `${basePath}/${imagePath}`;
    window.open(filePath, '_blank');
}) 
 
 
    
$(document).on('input', '#description', function(){
    
    let textarea = document.getElementById("description");
    let wordCount = document.getElementById("wordCount");

    let words = textarea.value.trim().split(/\s+/).filter(Boolean);
    let wordLength = words.length;

    // Update word count display
    wordCount.textContent = `${wordLength} / 100 words`;

    if (wordLength >= 100) {
        // wordCount.classList.add("limit-exceeded");
        textarea.value = words.slice(0, 100).join(" "); // Trim extra words
        Swal.fire('Notice!!!', "Text limit exceeded. The maximum word count is 100", 'warning');
    }
    
})
    
    
})
     
 
     
 </script>     
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      