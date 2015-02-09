<html>
<head>
<title>Skyscanner Api</title>
<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<style>



.flight, {
    float: left;
    clear: both;
    width: 100%;
    background: white;
    border: 1px solid silver;
    margin: 0 0 13px;
    padding-bottom: 15px;
}
.flight u{
    background: url(../images/privacy_strip.png);  font-size: 26PX;  font-weight: bold;  color: white;  background-repeat: no-repeat;  background-position: left;  padding: 5px;  float: left;  width: 95%;
}
.flight b, {
    float: left;  width: 100%;  margin: 3px 0;  border-bottom: 1px solid silver;  padding-bottom: 3px;
}
 
 
 
 
 .f-prime{ float:left; width:49%}
 .f-prime h1{
    font-size: 20px;
    float: left;
    color: #575656;
}
 .f-prime h2{
    padding: 0;
    float: right;
    font-size: 20px !important;
    color: #575656;
}
 .f-prime h2 img{}
 .f-prime ul{
    float: left;
    width: 100%;
}
 .f-prime ul li{
    width: 100%;
    float: left;
}
 .f-prime ul li span{
    float: left;
    width: auto;
    padding: 4px 0;
    margin: 0;
    margin-right: 10px;
}
 .f-prime ul li u{
    background: none;
    color: #899E2B;
    float: left;
    width: auto;
    font-size: 22px;
    padding: 0;
    margin: 0;
}
  .f-prime label{
    color: #333;
    float: left;
    margin: 0 14px 0 0;
    min-width: 115px;
}
 .f-prime input{
    padding: 6px 10px;
    border: 1px solid silver;
    width: 100%;
    text-transform: capitalize !important;
}
 .f-prime span{
    float: left;
    width: 97%;
    margin-top: 15px;
    color: #333;
    margin-left: 3%;
}
.f-prime form{
    float: right;
    width: 52%;
}

 .f-secondary{float:right; width:49%}
 .f-secondary big{
    color: #575656;
    float: left;
    width: 100%;font-weight: bold;
	padding-top: 10px;
	font-size: 18px;
}
.f-secondary form{
    float: right;  width: 52%;
}
 .f-secondary label{      width: 130px;
          color: #575656;  float: left;  margin: 0 14px 0 0;  min-width: 115px;
}
 .f-secondary input{    
    padding: 6px 10px;  border: 1px solid silver;  width: 100%;  text-transform: capitalize !important;
    float: right;
}
 .f-secondary span{
    float: left;  
    width: 97%;  
    margin-top: 15px;
}
.f-secondary a{
	background: #a7ba51;
color: white;
padding: 5px 10px;
clear: both;
width: 127px;
text-align: center;

	margin: 20px 3% 1px 0;
float: right;
border-radius: 4px;
	}
	.f-secondary i{
    text-decoration: underline;
    float: right;
    clear: both;
    margin-right: 3%;
    font-style: normal;
}
.f-prime span:nth-child(3){
    border-top: 1px solid silver;
    padding: 10px 0;
}
.f-prime span:nth-child(4){
    border-top: 1px solid silver;
    padding: 10px 0;
}

</style>
</head>
<body>
<script type="text/javascript">
function skytest1(oa)
{
	//code for lower div
	var list2= new Array();
	
	$.ajax(
	{
		type: "POST",
		url: "skytest1.php",
		data:'info='+oa,
		async:false,
		success: function(result)
		{
			//alert(result);
			var objct = JSON.parse(result);
			$.each(objct, function (k,v)
			{
			
				list2.push(v);
				
			});
			
		}
	});
	var tt2=' ';
	//console.log(list2);
	var low2= Math.min.apply(Math, list2);
	//console.log(low2);
	tt2=low2;
	$('#lastprice').show();	
	$('#lastprice1').html(tt2);
	
	//showcities1(oa,low2);
	//code close for lower div
}

function myfunct()
{
	setTimeout(function (){myFunction1();}, 2000);

}
function myFunction1()
{
	var Tags= new Array();
	var myarr=new Array();
	var originplace1=document.getElementById('originplace1').value;
		
	var string = originplace1;
	$.ajax(
	{
		type: "POST",
		url: "getplaces.php",
		data:'info='+string,
		async:false,
		success: function(result)
		{   
			var obj = JSON.parse(result);
			$.each(obj, function (k,v)
			{
					
				Tags.push(v);
				
			});
			
		}
	});
	//console.log(Tags);
	
	for(var k = 0 ;k<Tags.length; k++)
	{	
		myarr.push({idx:Tags[k],label:Tags[k+1]});
		k++;
	}
	//console.log(myarr);
		
	$("#originplace1" ).autocomplete(
	{
        
		source: myarr,
		select: function(event, ui) 
		{
			//alert(ui.item.idx);
            $('#flightloader').show();	 
			$('#myid').val(ui.item.idx);
			$('#mylabel').val(ui.item.label);
			getresult1(ui.item.idx,ui.item.label);
		}
	});
}
    
function getresult1(myval,b)
{ 
	var list= new Array();
	//console.log('----'+oa);
	$.ajax(
	{
		type: "POST",
		url: "skytest1.php",
		data:'info='+myval,
		async:false,
		success: function(result)
		{
			//console.log(result);
			var objct = JSON.parse(result);
			$.each(objct, function (k,v)
			{
			
				list.push(v);
				
			});
			
		}
	});
	var tt=' ';
	//console.log(list);
	var low= Math.min.apply(Math, list);
	//console.log(low);
	tt=low;
	$('#curprice').show();	
	$('#curprice1').html(tt);
    $('#flightloader').hide();	
	//showcities1(myval,low);
}    
</script>
<div class="flight" >
		<b><u>Flights</u></b>
        <div class="overlay" id="flightloader" style='display:none'>
        <img id="upimg1" style='top: 5%;' alt="Loading please wait..." src="http://www.muzenly.com/skin/frontend/default/mobileshoppe/images/flight-loader.GIF" />
        </div>
		<div class="f-prime">
			<span>
				<label>Select from Auto suggest</label>
				<form name="form" id="form">
					<input type="text" name="originplace1" id="originplace1" onkeyup="myfunct()">
				</form>
			</span>		  
			<span>
				<label>To</label>
				<form name="form" id="form">
					<input type="text" name="destinationplace" id="destinationplace" value="Goa">
				</form>
			</span>
			<i>Search chepest flight price by:- <img src="http://d6tizftlrpuof.cloudfront.net/live/resources/image/skyscanner_logo.png" alt="Sky Scanner"></i>
			<span>
				<h1 id="cities"></h1> 
				<h2 > <b id="per"></b>
				<ul>
					<li><span>This week</span><u id="curprice" style="display:none;">Rs. </u><u id="curprice1"></u></li>
				</ul>
			</span>
		</div><!--f-prime close-->
	</div><!--flight close-->
</body>
</html>
