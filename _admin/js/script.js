$('#objId').popover();
$('#objNom').popover();
$('#objJourCreation').popover();
$('#objHeureCreation').popover();
$('#propValeur1').popover();
$('#propValeur2').popover();
$('#propValeur4').popover();
$('#btEnregistrer').popover();

$('#objJourCreation .input-group.date').datepicker({
	format: "yyyy-mm-dd",
	todayBtn: "linked",
	clearBtn: true,
	language: "fr",
	autoclose: true,
	todayHighlight: true
});