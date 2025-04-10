
Complaint Ticket System

Overview
The Complaint Ticket System allows Complainants to submit complaints and receive a ticket ID. An admin can manage, respond, and edit/update those complaints status. Both parties can reply in a chat-style format, and the system supports email notifications and ticket history tracking.

Complainant:
1.	Complaint Creation (Complainant): The complaint form allows Complainants (both authenticated and anonymous) to submit new complaints into the system. The form collects essential details such as Username/Matric no (Anonymous), subject, message content, and optional file attachment
   For Submission:
i.	Complainant fills in the complaint form. Anonymous users must provide a valid, unique identifier.
ii.	The form data is validated
iii.	Upon successful submission.
•	A ticket ID is generated.
•	The complaint is saved to the database.
•	An email confirmation (with ticket ID) is sent to the Complainant.
•	Complainant is shown a confirmation message.
 
 

2.	Complainant Search Ticket & Reply: This content allows Complainants to retrieve the history of a previously submitted complaint using their credentials (Username/Matric no and Complaints Ticket Id).
Complainant can:
i.	Search by username/matric no and ticket id
ii.	Reply with more info

 

Admin:
1.	Admin View Complaints:  This content enables admin users to manage submitted complaints efficiently. It provides tools for filtering, while keeping Complainants informed via email notifications.
 	   Admin (including moderators and support staff) can: 
i.	View all complaint tickets
ii.	Filter by Status
iii.	Gives Feedback to any complaint
iv.	Change ticket status (e.g., Pending, In Progress, Resolved)
v.	Admin can leave internal notes not visible to Complainants. Useful for collaboration
vi.	Every admin reply generates an automatic email notification to the Complainant.

 
 
 
2.	Admin View Individual Complainant Complaint:  This Content allows admins to quickly locate and review all complaint tickets associated with a particular Complainant using their username or matric no.

 



Reply Mechanism (Chat-like Interface):
Replies are stored in a tb_complaint_feedback table.
Replies show in chat view, with:
i.	Admin messages aligned left
ii.	Complainant messages aligned right
iii.	Timestamp and sender type (Admin or Complainant) displayed
iv.	Support text reply

 


Email Notifications
i.	Complaint Created → Complainant receives ticket ID
ii.	Admin Reply → Complainant receives reply notification
iii.	Admin update status → Complainant receives notification for status update

