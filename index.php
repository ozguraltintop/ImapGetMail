﻿<?php 
set_time_limit(4000); 
 
// Connect to gmail
$imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'xxxx@gmail.com';
$password = 'xxxx';
 
// try to connect 
$inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
 
   /* ALL - return all messages matching the rest of the criteria
    ANSWERED - match messages with the \\ANSWERED flag set
    BCC "string" - match messages with "string" in the Bcc: field
    BEFORE "date" - match messages with Date: before "date"
    BODY "string" - match messages with "string" in the body of the message
    CC "string" - match messages with "string" in the Cc: field
    DELETED - match deleted messages
    FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
    FROM "string" - match messages with "string" in the From: field
    KEYWORD "string" - match messages with "string" as a keyword
    NEW - match new messages
    OLD - match old messages
    ON "date" - match messages with Date: matching "date"
    RECENT - match messages with the \\RECENT flag set
    SEEN - match messages that have been read (the \\SEEN flag is set)
    SINCE "date" - match messages with Date: after "date"
    SUBJECT "string" - match messages with "string" in the Subject:
    TEXT "string" - match messages with text "string"
    TO "string" - match messages with "string" in the To:
    UNANSWERED - match messages that have not been answered
    UNDELETED - match messages that are not deleted
    UNFLAGGED - match messages that are not flagged
    UNKEYWORD "string" - match messages that do not have the keyword "string"
    UNSEEN - match messages which have not been read yet*/
 
// search and get unseen emails, function will return email ids
$emails = imap_search($inbox,'UNSEEN');
 
$output = '';
 
foreach($emails as $mail) {
   

    $headerInfo = imap_headerinfo($inbox,$mail);
    
    $output .= $headerInfo->toaddress.'<br/>';
    $output .= $headerInfo->date.'<br/>';
    $output .= $headerInfo->fromaddress.'<br/>';
    $output .= $headerInfo->reply_toaddress.'<br/>';
    $emailStructure = imap_fetchstructure($inbox,$mail);
    //$output .= imap_body($inbox, $mail, FT_PEEK);
    $output  = var_dump(quoted_printable_decode($output));
    $body    = imap_fetchbody($inbox, $mail,1);
    $output .= var_dump(quoted_printable_decode($body)); 
    $output .= "<hr>";
     echo $output;
     //

     
     if (stripos(strtolower($body), 'tanim1') !== false) {
      echo "<b style='color:green'>tanim1 bulundu -> yönlendirildi.</b><br>";
      }
      else if(stripos(strtolower($body), 'tanim2') !== false) 
      {
      echo "<b style='color:green'tanim2 bulundu -> yönlendirildi.</b><br>";
      }
      else
      {
       //UNREAD YAZ
      echo "<b style='color:red'> bulunamadı</b><br>";
      }



     //
     $output = '';
}
 
// colse the connection
imap_expunge($inbox);
imap_close($inbox);
?>