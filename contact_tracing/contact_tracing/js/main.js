$(window).on( "load",function() {
   $(".loader").fadeOut();
});
function showGuest(x){
    $.post("php/changeGuest.php",
    {
       currentID: x
    },
    function(data,status) {
       if (status == "success") {
          try {
               console.log(status);
               console.log(data);
             eval(data);
          } catch (e) {
             if (e instanceof SyntaxError) {
                alert(e.message);
             }
          }
       }
    });
    location.reload(true);
}

function showTrace(x){
   $.post("php/changeTrace.php",
   {
      currentTraceID: x
   },
   function(data,status) {
      if (status == "success") {
         try {
              console.log(status);
              console.log(data);
            eval(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
   location.reload(true);
}

function showAttendance(x){
   $.post("php/changeAttendance.php",
   {
      currentAttID: x
   },
   function(data,status) {
      if (status == "success") {
         try {
              console.log(status);
              console.log(data);
            eval(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
   location.reload(true);
}

function showEvent(x){
   $.post("php/ChangeEvent.php",
   {
      currentEventID: x
   },
   function(data,status) {
      if (status == "success") {
         try {
              console.log(status);
              console.log(data);
            eval(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }
   });
   location.reload(true);
}

function deleteGuest(x){
   var r = confirm("Are you sure, want to Delete?");
   if (r == true) {
      $.post("php/ajax.php",
      {
         request: "deleteGuest",
         id: x
      },
      function(data,status) {
         if (status == "success") {
            try {
               console.log(status);
               console.log(data);
               eval(data);
            } catch (e) {
               if (e instanceof SyntaxError) {
                  alert(e.message);
               }
            }
         }
      });
   }
}

function deleteEvent(x){
   var r = confirm("Are you sure, want to Delete?");
   if (r == true) {
      $.post("php/ajax.php",
      {
         request: "deleteEvent",
         id: x
      },
      function(data,status) {
         if (status == "success") {
            try {
               console.log(status);
               console.log(data);
               eval(data);
            } catch (e) {
               if (e instanceof SyntaxError) {
                  alert(e.message);
               }
            }
         }
      });
      
      showEvent(0);
   }
}

function editGuest(){
   document.getElementById("mySidenav").style.width = "0";
   document.getElementById("mySidenavEditGuest").style.width = "300px";
}

function editEvent(){
   var date = $('#dateEvent').text();
   var ToDate = new Date();
   if (new Date(date).setHours(0,0,0,0) < ToDate.setHours(0,0,0,0)) {
      $(".hideEditEvent").fadeIn();
   }
   document.getElementById("mySidenav").style.width = "0";
   document.getElementById("mySidenavEditEvent").style.width = "300px";
}

function saveEditGuest(x){
   var id = x;
   var fn = $("#EguestNameF").val();
   var mn = $("#EguestNameM").val();
   var ln = $("#EguestNameL").val();
   var as = $("#EguestAdrS").val();
   var ab = $("#EguestAdrB").val();
   var am = $("#EguestAdrM").val();
   var ap = $("#EguestAdrP").val();
   var cn = $("#EguestCNo").val();
   var em = $("#EguestEmail").val();
   var bd = $("#EguestBday").val();

   if( fn && ln && as && ab && am && ap && cn && em && bd && id){
     $.post("php/ajax.php",
     {
       request: "editGuest",
       firstName: fn,
       id: id,
       middleName: mn,
       lastName: ln,
       street: as,
       barangay: ab,
       municipality: am,
       province: ap,
       cNumber: cn,
       email: em,
       bday: bd
     },
     function(data,status) {
         if (status == "success") {
           try {
             console.log(status);
             console.log(data);
             eval(data);
           } catch (e) {
             // if (e instanceof SyntaxError) {
             //   alert(e.message);
             // }
           }
         }
     });
   } else {
     alert("Failed, Please Fill up the whle form");
   }
}

function saveEditEvent(x){
   var id = x;
   var en = $("#EeventName").val();
   var ls = $("#EeventLocationS").val();
   var lb = $("#EeventLocationB").val();
   var lm = $("#EeventLocationM").val();
   var lp = $("#EeventLocationP").val();
   var ed = $("#EeventDate").val();

   if( en && ls && lb && lm && lp && ed && id){
      $.post("php/ajax.php",
      {
        request: "editEvent",
        id: id,
        name: en,
        street: ls,
        barangay: lb,
        municipality: lm,
        province: lp,
        date: ed
      },
      function(data,status) {
        if (status == "success") {
          try {
            console.log(status);
            console.log(data);
            eval(data);
          } catch (e) {
            // if (e instanceof SyntaxError) {
            //   alert(e.message);
            // }
          }
        } 
      });
   }
}

function attendance(x){
   showAttendance(x);
   window.location.replace("attendance.php");
}

function trace(x){
   showTrace(x);
   window.location.replace("trace.php");
}

function tracing(){
   var str = $("#myInputTrace").val();
   var res = str.split(" - ");
   var gid = res[1];
   
   
   if(allGuest.includes(str)){
      if( str == "+ Create New Guest"){
         window.open('guest.php', '_blank');
      } else {
         trace(gid);
      }
   }else{
      alert("Unknown Pariticipant")
   }
}

function guest(x){
   var r = confirm("Goto Guest?");
      if (r == true) {
      showGuest(x);
      window.location.replace("guest.php");
   }
}

function gotoEvent(x){
   var r = confirm("Goto Event?");
      if (r == true) {
      showEvent(x);
      window.location.replace("event.php");
   }
}

function deleteParticipant(gid,eid){

   var r = confirm("Are you sure, want to Delete?");
   if (r == true) {
      $.post("php/ajax.php",
      {
         request: "deleteParticipant",
         gid: gid,
         eid,eid
      },
      function(data,status) {
         if (status == "success") {
            try {
               console.log(status);
               console.log(data);
               eval(data);
            } catch (e) {
               if (e instanceof SyntaxError) {
                  alert(e.message);
               }
            }
         }
      });
   }

}

function addParticipantEdit(eventId, comment){

   var str = $("#myInputParticipantEdit").val();
   var res = str.split(" - ");
   var guestId = res[1];
   
   if(allGuest.includes(str)){
      if( str == "+ Create New Guest"){
         window.open('guest.php', '_blank');
      } else {
         $.post("php/ajax.php",
         {
         request: "addParticipant",
         eid: eventId,
         gid: guestId,
         rem: comment
         },
         function(data,status) {
         if (status == "success") {
            try {
               console.log(status);
               console.log(data);
               eval(data);
            } catch (e) {
               // if (e instanceof SyntaxError) {
               //   alert(e.message);
               // }
            }
         } 
         });
      }
   }else{
      alert("Unknown Pariticipant")
   }
   
}

function addParticipant(eventId, comment){
   
   var str = $("#myInputParticipant").val();
   var res = str.split(" - ");
   var guestId = res[1];
   
   if(allGuest.includes(str)){
      if( str == "+ Create New Guest"){
         window.open('guest.php', '_blank');
      } else {
         $.post("php/ajax.php",
         {
         request: "addParticipant",
         eid: eventId,
         gid: guestId,
         rem: comment
         },
         function(data,status) {
         if (status == "success") {
            try {
               console.log(status);
               console.log(data);
               eval(data);
            } catch (e) {
               // if (e instanceof SyntaxError) {
               //   alert(e.message);
               // }
            }
         } 
         });
      }
   }else{
      alert("Unknown Pariticipant");
   }
   
}