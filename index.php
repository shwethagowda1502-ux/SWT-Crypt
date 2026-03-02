<!DOCTYPE html>
<html>
<head>

<title>SWT-Crypt</title>

<style>

body{
font-family:Arial;
margin:0;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

/* MAIN CONTAINER */

.container{
display:flex;
min-height:100vh;
}


/* LEFT SIDE */

.left{
width:50%;
padding:20px;
box-sizing:border-box;
color:white;
}


/* SWT TITLE */

.title{
font-size:50px;
font-weight:bold;
margin-bottom:20px;
letter-spacing:5px;
}

.brown{color:#5a3a1a;}

.white{
color:white;
text-shadow:2px 2px 5px black;
}


/* BOXES */

.box{
background:white;
color:black;
padding:15px;
border-radius:10px;
margin-bottom:15px;
box-shadow:0px 3px 10px black;
}


/* INTRO */

.intro{
font-size:14px;
line-height:1.5;
}


/* INSTRUCTIONS */

.instructions{
font-size:13px;
line-height:1.4;
}


/* STEP */

.stepRow{
display:flex;
gap:15px;
margin-bottom:15px;
}


/* TEXT */

.stepText{
width:60%;
}


/* DEMO */

.demo{
width:40%;
background:#f2f2f2;
padding:8px;
border-radius:8px;
font-size:12px;
}


/* INPUT */

.demo input{
width:95%;
padding:4px;
margin:4px 0;
font-size:12px;
}


/* BUTTON */

.demo button{
width:100%;
padding:5px;
background:#0077ff;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
font-size:12px;
}


.status{
display:none;
color:green;
margin-top:3px;
}



/* RIGHT SIDE */

.right{
width:50%;
background:#f5f9ff;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
}



/* BUTTONS */

.btn{
width:280px;
padding:15px;
margin:15px;
border:none;
border-radius:10px;
font-size:16px;
background:linear-gradient(135deg,#4facfe,#0077ff);
color:white;
cursor:pointer;
}

/* FOOTER */

.footer{

margin-top:40px;        /* More space below buttons */

padding-top:15px;       /* Space inside footer */

text-align:center;

font-size:15px;

color:#333;

line-height:1.8;

border-top:2px solid #ddd;   /* Clean separator line */

width:80%;

}
</style>

</head>

<body>

<div class="container">


<!-- LEFT SIDE -->

<div class="left">


<div class="title">

<span class="brown">S</span>
<span class="white">W</span>
<span class="brown">T</span>
<span class="white">-</span>
<span class="brown">C</span>
<span class="white">R</span>
<span class="brown">Y</span>
<span class="white">P</span>
<span class="brown">T</span>

</div>



<!-- INTRO BOX -->

<div class="box intro">

<b>INTRODUCTION</b>

<br><br>

SWT-Crypt is a secure web-based cryptographic system implementing RSA asymmetric encryption with OpenSSL-compatible key pair generation, providing a reliable mechanism for secure message encryption and decryption.
</div>



<!-- INSTRUCTIONS BOX -->

<div class="box instructions">

<b>INSTRUCTIONS (Demo)</b>

<br><br>


<!-- STEP 1 -->

<div class="stepRow">

<div class="stepText">

<b>Step 1 : Generate Key Pair</b>

<br><br>

• Receiver generates keys

<br>

• public.key → shared

<br>

• private.key → secret

<br><br>

Public key encrypts

<br>

Private key decrypts

</div>


<div class="demo">

Password

<input value="mypassword">

<button onclick="s1()">Generate</button>

<div id="ok1" class="status">

✔ Keys Ready

</div>

</div>

</div>



<!-- STEP 2 -->

<div class="stepRow">

<div class="stepText">

<b>Step 2 : Encrypt Message</b>

<br><br>

• Upload public.key

<br>

• Type secret message

<br>

• Click Encrypt

<br>

• Download .bin file

<br>

• Send to receiver

<br><br>

Only receiver can decrypt.

</div>


<div class="demo">

public.key

<input value="public.key">

Message

<input value="Hello Client">

<button onclick="s2()">Encrypt</button>

<div id="ok2" class="status">

✔ BIN Ready

</div>

</div>

</div>



<!-- STEP 3 -->

<div class="stepRow">

<div class="stepText">

<b>Step 3 : Decrypt Message</b>

<br><br>

• Upload private.key

<br>

• Enter password

<br>

• Upload .bin file

<br>

• Click Decrypt

<br><br>

Original message appears.

</div>


<div class="demo">

private.key

<input value="private.key">

Password

<input value="******">

<button onclick="s3()">Decrypt</button>

<div id="ok3" class="status">

✔ Message Visible

</div>

</div>

</div>


</div>

</div>



<!-- RIGHT SIDE -->

<div class="right">


<a href="keypair.php">
<button class="btn">
Generate Key Pair
</button>
</a>



<a href="encrypt.php">
<button class="btn">
Encrypt / Decrypt Message
</button>
</a>



<div class="footer">

<b>Developed by SHWETHA</b>

<br>

<b>Powered by TALFOR</b>

</div>


</div>


</div>



<script>

function s1(){
document.getElementById("ok1").style.display="block";
}

function s2(){
document.getElementById("ok2").style.display="block";
}

function s3(){
document.getElementById("ok3").style.display="block";
}

</script>


</body>
</html>