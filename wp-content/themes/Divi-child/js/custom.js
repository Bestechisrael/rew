panelCoverage = new Array
	(
	32,
	36,
	40,
	44,
	48,
	52,
	56,
	60,
	64
	);
	
function validateTextBox(theBox,errorMsg) {
	theBoxObj = eval("document.MainForm." + theBox);
	if (theBoxObj.value.length == 0) {
		alert(errorMsg);
		theBoxObj.focus();
		return(false);
	} else {
		return(true);
	}
}

function validateInput() {
	if (!validateTextBox("email","Please enter your email address here.")) { return(false); }

	atSign = document.MainForm.email.value.indexOf("@");
	lastPeriod = document.MainForm.email.value.lastIndexOf(".");
	if ((atSign < 1) | (lastPeriod < (atSign + 1)) | (lastPeriod >= (document.MainForm.email.value.length - 1)) | ((lastPeriod - atSign) < 2)) {
		alert("Please enter a valid email address here.");
		document.MainForm.email.select();
		document.MainForm.email.focus();
		return(false);
	}
}	

function getSquareFootage(){
	// get the square foot value...
	squareFootage = parseInt(document.MainForm.panelarea.value);
	if (isNaN(squareFootage)){
		document.MainForm.panelarea.value = "0";
		squareFootage = 0;
		}
	// update output to lose junk values...
	document.MainForm.panelarea.value = squareFootage;
	}	

function updatePanelsOutput(){
	// get the selected panel type...
	for (iLoop=0;iLoop<9;iLoop++){
		if (document.MainForm.size[iLoop].checked){
			panelCoverageValue = panelCoverage[iLoop];}
		}
	getSquareFootage();
	// calculate needed panels
	numPanelsNecessary = squareFootage / panelCoverageValue;
	if (Math.floor(numPanelsNecessary) != numPanelsNecessary){
		numPanelsRoundedUp = Math.floor(numPanelsNecessary) + 1;
		}else{
		numPanelsRoundedUp = numPanelsNecessary;}
	// update output...
	document.MainForm.totalpanels.value = numPanelsRoundedUp;
	}
	
function getSquareFootage(){
	// get the square foot value...
	squareFootage = parseInt(document.MainForm.panelarea.value);
	if (isNaN(squareFootage)){
		document.MainForm.panelarea.value = "0";
		squareFootage = 0;}
	// update output to lose junk values...
	document.MainForm.panelarea.value = squareFootage;
	}	
	
function updateJointTapeOutput() {
	// get the selected treatment type...
	treatmentMultiplierValue = 0.37;
	treatmentSuffixValue = " ft.";
	// get the square foot value...
	getSquareFootage();
	// calculate needed treatment
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	// update output...
	document.MainForm.jointtape.value = String(amtTreatment);
	document.MainForm.hid_jointtape.value = String(amtTreatment) + treatmentSuffixValue;
	}
	
 

function updateDurabondOutput()	{
	treatmentMultiplierValue = 0.0725;
	treatmentSuffixValue = " lb.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.durabond.value = String(amtTreatment);
	document.MainForm.hid_durabond.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updateEasySandOutput() {
	treatmentMultiplierValue = 0.0525;
	treatmentSuffixValue = " lb.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.easysand.value = String(amtTreatment);
	document.MainForm.hid_easysand.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updateReadyMixedOutput() {
	treatmentMultiplierValue = 0.14;
	treatmentSuffixValue = " lb.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.readymixed.value = String(amtTreatment);
	document.MainForm.hid_readymixed.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updatePlus3Output() {
	treatmentMultiplierValue = 0.0095;
	treatmentSuffixValue = " gal.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.plus3.value = String(amtTreatment);
	document.MainForm.hid_plus3.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updatePaintOutput() {
	treatmentMultiplierValue = 0.003;
	treatmentSuffixValue = " gal.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment){
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.paint.value = String(amtTreatment);
	document.MainForm.hid_paint.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updateNailsOutput() {
	treatmentMultiplierValue = 2.00;
	treatmentSuffixValue = " nails.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.nails.value = String(amtTreatment);
	document.MainForm.hid_nails.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updateScrewsOutput() {
	treatmentMultiplierValue = 1.25;
	treatmentSuffixValue = " screws.";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.screws.value = String(amtTreatment);
	document.MainForm.hid_screws.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updateAdhesiveOutput() {
	treatmentMultiplierValue = 0.0067;
	treatmentSuffixValue = " ( 29 oz.) tubes";
	getSquareFootage();
	amtTreatment = squareFootage * treatmentMultiplierValue;		
	if (Math.floor(amtTreatment) != amtTreatment) {
		amtTreatment = Math.floor(amtTreatment) + 1;}	
	document.MainForm.adhesive.value = String(amtTreatment);
	document.MainForm.hid_adhesive.value = String(amtTreatment) + treatmentSuffixValue;
	}	
	
function updateOutput() {
	updatePanelsOutput();
	updateJointTapeOutput();
//	updateJointCompoundsOutput();
	updateDurabondOutput();
	updateEasySandOutput();
	updateReadyMixedOutput();
	updatePlus3Output();
	updatePaintOutput();
	updateNailsOutput();
	updateScrewsOutput();
	updateAdhesiveOutput();
	}
	
function checkForm() {
	if (!(validateEmail(document.MainForm.email.value))) {
		alert("Please enter a valid email address.");
		document.MainForm.email.focus();
		return false;
	}
	return true;
}

areaSqFt = new Array ("80","96","112","100","120","140","160","144","168","192","240","224","280","308","364","256","288","320","384","448","324","360","432","504","576","400","480","484","576");
WallMold10ft = new Array ("4","4","5","4","5","5","6","5","6","6","7","6","7","8","8","7","7","8","8","9","8","8","9","10","10","8","9","9","10");
panel24 = new Array ("10","12","14","13","15","18","20","18","21","24","30","32","35","39","46","32","36","40","48","56","41","45","54","63","72","50","60","61","72");
panel22 = new Array ("20","24","28","25","30","35","40","36","42","48","60","56","70","77","91","64","72","80","96","112","81","90","108","126","144","100","120","121","144");
shrt12ftMain = new Array ("2","2","3","3","2","4","3","2","4","3","4","4","5","7","9","4","7","6","7","8","8","6","8","9","11","7","9","11","10");
shrt4ct = new Array ("9","9","11","10","12","14","16","15","18","20","25","24","30","33","39","28","32","35","42","59","36","40","48","56","64","45","54","55","66");
shrt2ct = new Array ("12","12","12","14","10","15","15","12","18","18","24","28","28","35","42","24","32","32","40","48","27","36","45","54","63","40","50","44","60");
long12ftMain = new Array ("2","2","2","3","2","5","5","3","5","5","4","6","8","8","9","6","8","6","6","8","8","9","10","12","14","7","8","11","10");
long4ct = new Array ("8","10","12","12","15","18","21","15","18","24","27","28","36","35","42","28","32","36","44","52","36","41","50","59","68","45","55","55","66");
long2ct = new Array ("5","6","12","14","18","20","30","12","14","16","30","31","39","33","39","24","27","40","48","50","27","30","36","42","48","40","48","44","60");

function calcValues()
	{
	//alert(document.mainform.dimen.selectedIndex);
	document.mainform.totalsqft.value = areaSqFt[document.mainform.dimen.selectedIndex];
	document.mainform.moldingneeded.value = WallMold10ft[document.mainform.dimen.selectedIndex];
	
	if (document.mainform.tees[0].checked)
		{
		document.mainform.teesneeded.value = long12ftMain[document.mainform.dimen.selectedIndex];
		if (document.mainform.psize[0].checked)
			{
			document.mainform.crosstees2ft.value = "N/A";
			document.mainform.crosstees4ft.value = long4ct[document.mainform.dimen.selectedIndex];
			document.mainform.panelsneeded.value = panel24[document.mainform.dimen.selectedIndex];
			}
		else 
			{
			document.mainform.crosstees2ft.value = long2ct[document.mainform.dimen.selectedIndex];
			document.mainform.crosstees4ft.value = long4ct[document.mainform.dimen.selectedIndex];
			document.mainform.panelsneeded.value = panel22[document.mainform.dimen.selectedIndex];
			}
		}
	else 
		{
		document.mainform.teesneeded.value = shrt12ftMain[document.mainform.dimen.selectedIndex];
		if (document.mainform.psize[0].checked)
			{
			document.mainform.panelsneeded.value = panel24[document.mainform.dimen.selectedIndex];
			document.mainform.crosstees2ft.value = "N/A";
			document.mainform.crosstees4ft.value = shrt4ct[document.mainform.dimen.selectedIndex];
			}
		else	
			{
			document.mainform.panelsneeded.value = panel22[document.mainform.dimen.selectedIndex];
			document.mainform.crosstees2ft.value = shrt2ct[document.mainform.dimen.selectedIndex];
			document.mainform.crosstees4ft.value = shrt4ct[document.mainform.dimen.selectedIndex];
			}
		}
	}

	//functions for product_index pages
	function MM_openBrWindow(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
	}




function validateEmail(str) {
	var re = new RegExp
	re = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/
	return re.test(str)
}
 (function($) {
    $.fn.simpleStickyHeader = function(options) {
        var that = this;
        var headerOffsetTop = that.offset().top;

        var settings = $.extend({
            class: "sticky-header"
        }, options);

        var toggleFixedClass = (function toggleFixed() {
           console.log(headerOffsetTop);
          
            that.toggleClass(settings.class, $(window).scrollTop() > headerOffsetTop);

            return toggleFixed;
        })();

     $(window).scroll(toggleFixedClass);

        return this;
    };
}(jQuery));
jQuery(function() {
            jQuery("#sticky-header").simpleStickyHeader();
			jQuery(".popup-search").click(function()
			{
				jQuery(".search-form-popup").show();
				return false;
			});
			jQuery(".close-search-popup").click(function()
			{
				jQuery(".search-form-popup").hide();
				return false;
			});
			
			
			
        });
		





// When the user scrolls down 20px from the top of the document, show the button
