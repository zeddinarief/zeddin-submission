<!doctype html>
<html>
<head lang="en">
<meta charset="utf-8">
<title>Zeddin Submission</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h1><a href="#" target="_blank">Zeddin Submission</a></h1>
				<hr> 
				<form id="form" action="" method="post" enctype="multipart/form-data">
					<input id="uploadImage" type="file" accept="image/*" name="image" />
					<!-- <div id="preview"><img src="filed.png" /></div><br> -->
					<input class="btn btn-success" type="submit" value="Upload">
				</form>
				<div id="preview"><img src="" /></div><br>
				<h3 id="caption"></h3>
			    <hr>
			</div>
		</div>
	</div>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function (e) {
		 $("#form").on('submit',(function(e) {
		  e.preventDefault();
		  $.ajax({
		         url: "phpQS.php",
		   type: "POST",
		   data:  new FormData(this),
		   contentType: false,
		         cache: false,
		   processData:false,
		   beforeSend : function()
		   {
		    $("#err").fadeOut();
		   },
		   success: function(data)
		      {
		    if(data=='invalid')
		    {
		     // invalid file format.
		     $("#err").html("Invalid File !").fadeIn();
		    }
		    else
		    {
		     // view uploaded file.
		     console.log(data);
		     $("#preview").html("<img src='"+data+"' />").fadeIn();
		     processImage(data);
		     $("#form")[0].reset(); 
		    }
		      },
		     error: function(e) 
		      {
		    $("#err").html(e).fadeIn();
		      }          
		    });
		 }));
		});
		function processImage(data) {
	        // Replace <Subscription Key> with your valid subscription key.
	        var subscriptionKey = "402b27ad0c0440c489abdb23ec66c74a";
	 
	        var uriBase =
	            "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
	 
	        // Request parameters.
	        var params = {
	            "visualFeatures": "Description",
	            "details": "",
	            "language": "en",
	        };
	 
	        // Make the REST API call.
	        $.ajax({
	            url: uriBase + "?" + $.param(params),
	 
	            // Request headers.
	            beforeSend: function(xhrObj){
	                xhrObj.setRequestHeader("Content-Type","application/json");
	                xhrObj.setRequestHeader(
	                    "Ocp-Apim-Subscription-Key", subscriptionKey);
	            },
	 
	            type: "POST",
	 
	            // Request body.
	            data: '{"url": ' + '"' + data + '"}',
	        })
	 
	        .done(function(data) {
	            // Show formatted JSON on webpage.
	           
	            $('h3#caption').html(JSON.stringify(data.description.captions[0].text, null, 2));
	        })
	 
	        .fail(function(jqXHR, textStatus, errorThrown) {
	            // Display error message.
	            var errorString = (errorThrown === "") ? "Error. " :
	                errorThrown + " (" + jqXHR.status + "): ";
	            errorString += (jqXHR.responseText === "") ? "" :
	                jQuery.parseJSON(jqXHR.responseText).message;
	            alert(errorString);
	        });
	    };
	</script>
</html>