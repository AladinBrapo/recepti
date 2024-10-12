<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

session_start();

use Google\Client;  // Use the Client class from Google API Client
use Google\Service\OAuth2; // Use the OAuth2 class if needed for user authentication

// Google OAuth 2.0 configuration
$client = new Google_Client();
$client->setClientId('955852252624-jh0s4v7jhu1me00v61nn0u3c8ul0rrcv.apps.googleusercontent.com'); // Replace with your Google Client ID
$client->setClientSecret('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'); // Replace with your Google Client Secret
$client->setRedirectUri('https://yummies.jayram.eu/callback.php'); // Redirect URL
$client->addScope('email');
$client->addScope('profile');

if (isset($_POST['credential'])) {
    $token = $_POST['credential'];  // Get the token from the Google login

    try {
        // Verify the token
        $payload = $client->verifyIdToken($token);
        if ($payload) {
            // Get user information from the token
            $email = $payload['email'];
            $googleId = $payload['sub'];
            $firstName = $payload['given_name'];
            $lastName = $payload['family_name'];

            // Connect to your database
            require_once 'baza.php';

            // Check if the user exists
            $sql = "SELECT * FROM uporabniki WHERE google_id = ? OR email = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param('ss', $googleId, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User exists, log them in
                $user = $result->fetch_assoc();
                $_SESSION['im'] = $user['ime'];
                $_SESSION['pr'] = $user['priimek'];
                $_SESSION['log'] = true;
                $_SESSION['vrsta_up'] = $user['vrsta_up_id'];
                $_SESSION['uporabnik_id'] = $user['id'];

                // Redirect to the homepage
                header('Location: index.php');
            } else {
                // New user, insert them into the database
                $sql = "INSERT INTO uporabniki (ime, priimek, email, google_id, vrsta_up_id) VALUES (?, ?, ?, ?, ?)";
                
                // Ensure vrsta_up_id exists (default to 1)
                $defaultRole = 1; // You can dynamically retrieve this ID if needed
                $stmt = $link->prepare($sql);
                $stmt->bind_param('ssssi', $firstName, $lastName, $email, $googleId, $defaultRole);
                $stmt->execute();

                $_SESSION['im'] = $firstName;
                $_SESSION['pr'] = $lastName;
                $_SESSION['log'] = true;
                $_SESSION['vrsta_up'] = $defaultRole; // Default user role
                $_SESSION['uporabnik_id'] = $link->insert_id;

                header('Location: index.php');
                exit();
            }
        } else {
            // Invalid token
            echo "Invalid Google login token.";
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
} else {
    echo "No token received.";
}
