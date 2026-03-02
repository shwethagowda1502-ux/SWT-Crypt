<?php
$encryptedText = "";
$decryptedText = "";
$error = "";
$success = "";

// ENCRYPTION
if (isset($_POST['encrypt'])) {

    $message = $_POST['message'];

    // SERVER-SIDE 300 WORD LIMIT CHECK
    $wordCount = str_word_count($message);
    if($wordCount > 300){
        $error = "Message too long! Maximum 300 words allowed.";
    }
    elseif (empty($message)) {
        $error = "Enter your message!";
    } 
    elseif ($_FILES['pubkey']['error'] != 0) {
        $error = "Upload a public.key file!";
    } 
    else {
        $fileName = $_FILES['pubkey']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExt != "key") {
            $error = "Only .key files are allowed!";
        } 
        else {
            $keyFile = $_FILES['pubkey']['tmp_name'];
            $publicKey = file_get_contents($keyFile);
            $pubKey = openssl_pkey_get_public($publicKey);

            if (!$pubKey) {
                $error = "Invalid Public Key!";
            } 
            else {
                if (openssl_public_encrypt($message, $encrypted, $pubKey, OPENSSL_PKCS1_PADDING)) {
                    file_put_contents("encrypted.bin", $encrypted);
                    $encryptedText = base64_encode($encrypted);
                    $success = "Encryption Successful! 'encrypted.bin' created.";
                } 
                else {
                    $error = "Encryption Failed!";
                }
            }
        }
    }
}

// DECRYPTION
if (isset($_POST['decrypt'])) {

    if ($_FILES['privkey']['error'] != 0) {
        $error = "Upload a private.key file!";
    } 
    elseif ($_FILES['encfile']['error'] != 0) {
        $error = "Upload an encrypted.bin file!";
    } 
    else {
        $privFile = $_FILES['privkey']['tmp_name'];
        $privateKey = file_get_contents($privFile);

        // Use passphrase if provided
        $passphrase = !empty($_POST['passphrase']) ? $_POST['passphrase'] : null;

        $privKey = openssl_pkey_get_private($privateKey, $passphrase);

        if (!$privKey) {
            $error = "Invalid Private Key or Incorrect Passphrase!";
        } 
        else {
            $encFile = $_FILES['encfile']['tmp_name'];
            $encryptedData = file_get_contents($encFile);

            if (openssl_private_decrypt($encryptedData, $decrypted, $privKey, OPENSSL_PKCS1_PADDING)) {
                $decryptedText = $decrypted;
                $success = "Decryption Successful!";
            } 
            else {
                $error = "Decryption Failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>RSA Encrypt / Decrypt (OpenSSL Compatible)</title>
<style>
body{
    font-family: Arial;
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding-top:30px;
}
.container{
    width:650px;
    padding:30px;
    background:white;
    border-radius:15px;
    box-shadow:0px 10px 30px gray;
    text-align:center;
}
h2{ margin-bottom:20px; }
textarea{
    width:95%;
    height:100px;
    padding:10px;
    border-radius:8px;
    border:2px solid #4facfe;
    background:#f0f8ff;
    resize:none;
    font-size:14px;
}
#encryptedBox, #decryptedBox{
    background:#e8fff0;
    border:2px solid green;
}
input[type=password]{
    width:95%;
    padding:8px;
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
    font-size:15px;
}
button:hover{ background:#0077ff; }
.success{ color:green; font-weight:bold; font-size:18px; margin-top:15px; }
.error{ color:red; font-weight:bold; margin-top:15px; }
hr{ margin:30px 0; border:1px solid #ddd; }
</style>
</head>
<body>
<div class="container">

<h2>Encrypt Message</h2>

<!-- ENCRYPTION FORM -->
<h3></h3>
<form method="POST" enctype="multipart/form-data">
    <textarea name="message" placeholder="Enter message to encrypt (max 300 words)" required oninput="checkWordLimit(this)"></textarea>
    <br><br>
    <label><b>Public.key</b></label><br>
    <input type="file" name="pubkey" accept=".key" required><br><br>
    <button type="submit" name="encrypt">Encrypt Message</button>
</form>

<?php if($success!="" && isset($_POST['encrypt'])) { ?>
<p class="success"><?php echo $success; ?></p>
<?php } ?>
<?php if($encryptedText!=""){ ?>
<h4>Encrypted Message </h4>
<textarea id="encryptedBox" readonly><?php echo $encryptedText; ?></textarea>
<br>
<button onclick="copyText('encryptedBox')">Copy Encrypted</button>
<br><br>
<a href="encrypted.bin" download><button>Download BIN File</button></a>
<?php } ?>

<hr>

<!-- DECRYPTION FORM -->
<h3>Decrypt Message</h3>
<form method="POST" enctype="multipart/form-data">
<label><b>Private.key</b></label><br>
    <input type="file" name="privkey" accept=".key" required><br><br>
    <input type="password" name="passphrase" placeholder="Private Key Passphrase (if any)"><br><br>
    <input type="file" name="encfile" accept=".bin" required><br><br>
    <button type="submit" name="decrypt">Decrypt Message</button>
</form>

<?php if($success!="" && isset($_POST['decrypt'])) { ?>
<p class="success"><?php echo $success; ?></p>
<?php } ?>
<?php if($decryptedText!=""){ ?>
<h4>Decrypted Message</h4>
<textarea id="decryptedBox" readonly><?php echo $decryptedText; ?></textarea>
<br>
<button onclick="copyText('decryptedBox')">Copy Decrypted</button>
<?php } ?>

<?php if($error!=""){ ?>
<p class="error"><?php echo $error; ?></p>
<?php } ?>
<br><br>

<a href="index.php">
<button>Back Home</button>
</a>

</div>

<script>
// CLIENT-SIDE 300 WORD LIMIT
function checkWordLimit(textarea){
    let words = textarea.value.trim().split(/\s+/);
    if(words.length > 300){
        alert("Maximum 300 words allowed!");
        textarea.value = words.slice(0,300).join(" ");
    }
}

// COPY FUNCTION
function copyText(id){
    var box = document.getElementById(id);
    box.select();
    document.execCommand("copy");
    alert("Copied!");
}
</script>
</body>
</html>