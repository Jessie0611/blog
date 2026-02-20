<?php //Custom Hashing (Salt + Pepper + SHA-256)
//To protect non-password sensitive data (like emails, usernames) before storing in a DB.
$sensitiveData = "username";
$salt = bin2hex(random_bytes(16)); //gen randon str
$pepper = "ASecretPepperStr";

$dataToHash = $sensitiveData . $salt . $pepper;
$hash = hash("sha256", $dataToHash);

echo "<br>" . $hash;

//password hashing

$pwd = "example";
$options = [
    'cost' => 12
];
$hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
$pwdLogin = "example";
password_verify($pwdLogin, $hashedPwd);

if (password_verify($pwdLogin, $hashedPwd)) {
    echo "The passwords are the same.";
}
