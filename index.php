 <html>
<head>
<title>Title of the document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
function recognice(){
var recognition = new webkitSpeechRecognition();
recognition.continuous = false;
recognition.lang = "es-ES";
recognition.interimResults = false;
recognition.onresult = function(event) { 
var result = event.results[0][0];
//console.log(event.results[0][0]);
	if(result.confidence>0.7){
//console.log(result.transcript);
		$.ajax({
  		  dataType: "json",
		  url: "guess.php",
		  data: "data="+result.transcript,
		  success: function(item){
			var response ={};
		     for(var i=0;i<item.length;i++){
			if(item[i].type=="action"){
				response.action=item[i].action;
			}else{
				response[item[i].kind]=item[i].kind;
			}			
		     }

			console.log(response);
			eval(response.action);

		  }
		});
	}
}
recognition.onspeechstart = function() { 
  console.log("STARTED");
}
recognition.onspeechend = function() { 
  console.log("STOPPED")
}
recognition.start();
}
</script>
</head>

<body>
<div id="cont"></div>
The content of the document......
<button type="button" onclick="recognice()">escuchar</button>
</body>

</html> 


