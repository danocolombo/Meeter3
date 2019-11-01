<?php 
//use this to see if we can get any token information.

$code = $_GET['code'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>AWS SDK for JavaScript - Sample Application</title>
    
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.12.min.js"></script>
</head>
<body>
	<h2>chkInfo - here we go!!!</h2>
    <input type="file" id="file-chooser" />
    <button id="upload-button" style="display:none">Upload to S3</button>

	<script type="text/javascript">
//     	var myCredentials = new AWS.CognitoIdentityCredentials({IdentityPoolId:'IDENTITY_POOL_ID'});
        var myConfig = new AWS.Config({
          credentials: myCredentials, region: 'us-east-1'
        });

        
    </script>

</body>
</html>