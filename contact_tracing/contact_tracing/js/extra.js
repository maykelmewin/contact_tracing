 $(document).ready(function(){
   
  $("#modal_trigger").click(function(){
      $(".modal").fadeIn();
  });
  $(".close").click(function(){
      $(".modal").fadeOut();
  });
  $("#event").click(function(){
      window.location.replace("event.php");
  });
  $("#guest").click(function(){
      window.location.replace("guest.php");
  });
  $("#trace").click(function(){
      window.location.replace("trace.php");
  });
  $("#logoIcon").click(function(){
      window.location.replace("index.php");
  });

  $("#openNav").click(function(){
    $(".hideEditEvent").fadeOut();
    document.getElementById("mySidenavEditEvent").style.width = "0";
    document.getElementById("mySidenav").style.width = "300px";

  });

  $("#addGuest").click(function(){
    document.getElementById("mySidenavEditGuest").style.width = "0";
    document.getElementById("mySidenav").style.width = "300px";
  });
  
  $("#addGuestAttendance").click(function(){
    document.getElementById("mySidenav").style.width = "300px";
  });
  
  $("#back").click(function(){
    window.location.replace("index.php");
  });

  $("#guest_add_blank").click(function(){
    window.open('guest.php', '_blank');
  });

  $("#myInputGuest").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#searchDiv *").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
  });

  $("#myInputEventsFilter").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
  });

  $("#saveNewEvent").click(function(){

    var en = $("#eventName").val();
    var ls = $("#eventLocationS").val();
    var lb = $("#eventLocationB").val();
    var lm = $("#eventLocationM").val();
    var lp = $("#eventLocationP").val();
    var ed = $("#eventDate").val();

    if( en && ls && lb && lm && lp && ed){
      $.post("php/ajax.php",
      {
        request: "addEvent",
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
    } else{
      alert("Failed, Please Fill up the whle form");
    }

  });

  $("#saveNewGuest").click(function(){
    var fn = $("#guestNameF").val();
    var mn = $("#guestNameM").val();
    var ln = $("#guestNameL").val();
    var as = $("#guestAdrS").val();
    var ab = $("#guestAdrB").val();
    var am = $("#guestAdrM").val();
    var ap = $("#guestAdrP").val();
    var cn = $("#guestCNo").val();
    var em = $("#guestEmail").val();
    var bd = $("#guestBday").val();

    if( fn && ln && as && ab && am && ap && cn && em && bd){
      $.post("php/ajax.php",
      {
        request: "addGuest",
        firstName: fn,
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
    } else{
      alert("Failed, Please Fill up the whle form");
    }
  });

  $("#tracingLine").hover(
    function() {
      $("#tracedLine").addClass("traced");
    }, function() {
      $("#tracedLine").removeClass("traced");
    }
  );

});

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}


function closeNavs() {
  document.getElementById("mySidenavEditGuest").style.width = "0";
}

function closeNavsEditEvent() {
  
  $(".hideEditEvent").fadeOut();
  document.getElementById("mySidenavEditEvent").style.width = "0";
}

//auto complete
function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
          /*check if the item starts with the same letters as the text field value:*/
          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
          }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
          currentFocus++;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 38) { //up
          /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
          currentFocus--;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 13) {
          /*If the ENTER key is pressed, prevent the form from being submitted,*/
          e.preventDefault();
          if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
          }
        }
    });
    function addActive(x) {
      /*a function to classify an item as "active":*/
      if (!x) return false;
      /*start by removing the "active" class on all items:*/
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      /*add class "autocomplete-active":*/
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      /*a function to remove the "active" class from all autocomplete items:*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });

}

