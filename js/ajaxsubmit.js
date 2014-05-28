function trim(str){
return (str.replace(/^\s\s*/, '').replace(/\s\s*$/, ''));}
function totalEncode(str){
var s=escape(trim(str));
s=s.replace(/\+/g,"+");
s=s.replace(/@/g,"@");
s=s.replace(/\//g,"/");
s=s.replace(/\*/g,"*");
return(s);
}
function connect(url,params)
{
var connection;  // The variable that makes Ajax possible!
try{// Opera 8.0+, Firefox, Safari
connection = new XMLHttpRequest();}
catch (e){// Internet Explorer Browsers
try{
connection = new ActiveXObject("Msxml2.XMLHTTP");}
catch (e){
try{
connection = new ActiveXObject("Microsoft.XMLHTTP");}
catch (e){// Something went wrong
return false;}}}
connection.open("POST", url, true);
connection.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
connection.setRequestHeader("Content-length", params.length);
connection.setRequestHeader("connection", "close");
connection.send(params);
return(connection);
}
function validateForm(frm){
	var errors='';
	var str=trim(document.frm.name.value);
	if (str.length > 100){
		errors+='post name must be within 20 characters.\n'; 
	}
	var str=trim(document.frm.comment.value);
	if (str.length > 100){
	errors+='post name must be within 100 characters.\n'; }
	
	if (errors){
		alert('The following error(s) occurred:\n'+errors);
		return false; 
	}
	return true;
}

function submitForm(frm){
	if(validateForm(frm)){
		document.getElementById('feedback'+document.frm.comment.value).innerHTML='';
		var url = "http://localhost/ishare/isharephal/tree/first";
		var params = "name=" + totalEncode(document.frm.name.value ) + "&comment="+totalEncode(document.frm.comment.value );
		var connection=connect(url,params);
		
		connection.onreadystatechange = function(){
			if(connection.readyState == 4){
			 	document.getElementById('feedback'+document.frm.comment.value).innerHTML=connection.responseText;
			}
			if((connection.readyState == 2)||(connection.readyState == 3)){
			 	document.getElementById('feedback'+document.frm.comment.value).innerHTML = '<span style="color:green;">Sending request....</span>';
			}
		}
	}
}
