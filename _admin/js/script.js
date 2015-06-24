$('#objId').popover();
$('#objNom').popover();
$('#objJourCreation').popover();
$('#objHeureCreation').popover();
$('#propValeur1').popover();
$('#propValeur2').popover();
$('#propValeur4').popover();
$('#btEnregistrer').popover();

$(function() {
    $( "#objJourCreation" ).datepicker();
  });
  
 $(function() {
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height:140,
      modal: true,
      buttons: {
        "Delete all items": function() {
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });