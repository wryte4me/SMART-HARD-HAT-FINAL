<?php
// AES decryption function
function aes256_decrypt($data, $key, $iv) {
    $decodedData = base64_decode($data);
    return openssl_decrypt($decodedData, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// Tamang key at IV
$key = openssl_random_pseudo_bytes(32); // 32 bytes for AES-256
$iv = openssl_random_pseudo_bytes(16); 

// Encrypted na mensahe
$encryptedText = "mUYo+8wuOmqNuJLJNrKDq3NEUGxyL293WnFjZXNZTVVmRGJ5WWc9PQ==";

// Decrypt ang encrypted na mensahe
$decryptedText = aes256_decrypt($encryptedText, $key, $iv);

echo "Decrypted: " . $decryptedText . "\n";
?>
