<?php 
//use this to see if we can get any token information.

$code = $_GET['code'];

?>

<html>
<head>

<script>
	var CID = "<?php echo $code ?>";
    var data = { UserPoolId : 'us-east-1_R5oqHdFWB',
        ClientId : "<?php echo $code ?>"
    };
    var userPool = new AmazonCognitoIdentity.CognitoUserPool(data);
    var cognitoUser = userPool.getCurrentUser();
    
    if (cognitoUser != null) {
        cognitoUser.getSession(function(err, session) {
            if (err) {
                alert(err);
                return;
            }
            console.log('session validity: ' + session.isValid());
        });
    }
</script>
</head>
<body>
<h2>chkInfo - here we go!!!</h2>

</body>
</html>