<?php

$message="";

if(isset($_POST['generate']))
{

$password=$_POST['password'];

if(empty($password))
{
$message="Enter Password!";
}
else
{

/* EXACT OPENSSL STYLE CONFIG */

$config = array(
"private_key_bits" => 2048,
"private_key_type" => OPENSSL_KEYTYPE_RSA,
"digest_alg" => "sha256"
);


/* CREATE KEY PAIR */

$res = openssl_pkey_new($config);


/* EXPORT PRIVATE KEY (PASSWORD PROTECTED) */

openssl_pkey_export(
$res,
$privateKey,
$password
);


/* EXTRACT PUBLIC KEY */

$details = openssl_pkey_get_details($res);

$publicKey = $details['key'];


/* SAVE FILES */

file_put_contents("private.key",$privateKey);

file_put_contents("public.key",$publicKey);

$message="Keys Generated Successfully (OpenSSL Compatible)!";

}

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Generate Keys</title>

<style>

body{
font-family:Arial;
background:linear-gradient(135deg,#4facfe,#00f2fe);
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.box{

width:500px;
background:white;
padding:30px;
border-radius:15px;
text-align:center;
box-shadow:0px 10px 30px gray;

}

input{

width:90%;
padding:10px;
margin-top:10px;
border-radius:6px;
border:2px solid #4facfe;

}

button{

margin-top:15px;
padding:12px 25px;
background:#4facfe;
color:white;
border:none;
border-radius:8px;
cursor:pointer;

}

.success{
color:green;
font-weight:bold;
}

</style>

</head>

<body>

<div class="box">

<h2>Generate OpenSSL RSA Keys</h2>

<form method="POST">

<input type="password"
name="password"
placeholder="Enter Password for Private Key">

<br>

<button name="generate">

Generate Key Pair

</button>

</form>

<br>

<p class="success">

<?php echo $message; ?>

</p>


<?php if(file_exists("private.key")){ ?>

<a href="private.key" download>

<button>Download Private Key</button>

</a>

<br><br>

<?php } ?>


<?php if(file_exists("public.key")){ ?>

<a href="public.key" download>

<button>Download Public Key</button>

</a>

<?php } ?>


<br><br>

<a href="index.php">

<button>Back Home</button>

</a>

</div>

</body>
</html>