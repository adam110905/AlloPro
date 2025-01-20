<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

header('Content-Type: text/html; charset=utf-8');

function envoi_mail($from_name, $from_email, $service, $phone, $subject, $message) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alloprocm@gmail.com';
    $mail->Password = 'yafyeasgvfisffqn';
    $mail->Port = 465;

    $mail->setFrom($from_email, $from_name);
    $mail->addAddress('alloprocm@gmail.com', 'Adam Bouali');

    $mail->isHTML(true);
    $mail->Subject = $subject;
   
    $message_body = "
    <p><strong>Service demandé :</strong> " . htmlspecialchars($service) . "</p>
    <p><strong>Nom du client :</strong> " . htmlspecialchars($from_name) . "</p>
    <p><strong>Email :</strong> " . htmlspecialchars($from_email) . "</p>
    <p><strong>Téléphone :</strong> " . htmlspecialchars($phone) . "</p>
    <p><strong>Sujet :</strong> " . htmlspecialchars($subject) . "</p>
    <p><strong>Message :</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";

    $mail->Body = $message_body;
    $mail->setLanguage('fr');

    return $mail->send();
}

if (isset($_POST['name'], $_POST['email'], $_POST['service'], $_POST['phone'], $_POST['subject'], $_POST['message'])) {
    if (envoi_mail(
        $_POST['name'],
        $_POST['email'],
        $_POST['service'],
        $_POST['phone'],
        $_POST['subject'],
        $_POST['message']
    )) {
        echo "
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                backdrop-filter: blur(5px);
            }
            .modal-content {
                background: rgb(17, 24, 39);
                padding: 2rem;
                border-radius: 1rem;
                width: 90%;
                max-width: 400px;
                text-align: center;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
                animation: fadeIn 0.3s ease-in-out;
                font-family: 'Poppins', sans-serif;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .modal-content h2 {
                font-size: 1.5em;
                margin-bottom: 1rem;
                color: #EAB308;
                font-weight: bold;
            }
            .modal-content p {
                font-size: 1em;
                color: #9CA3AF;
                margin-bottom: 1.5rem;
            }
            .modal-content button {
                padding: 0.75rem 2rem;
                background-color: #EAB308;
                color: white;
                font-size: 1em;
                border-radius: 0.5rem;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                transition: all 0.3s ease;
                border: none;
                outline: none;
            }
            .modal-content button:hover {
                background-color: #CA8A04;
                transform: translateY(-2px);
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>

        <div class='modal-overlay'>
            <div class='modal-content'>
                <h2>Message Envoyé !</h2>
                <p>Votre message a été envoyé avec succès. Nous vous recontacterons dans les plus brefs délais.</p>
                <button onclick='window.location.href=\"../PHP/index2.html\"'>Retour à l'accueil</button>
            </div>
        </div>";
        exit;
    } else {
        echo "<div class='modal-overlay'>
                <div class='modal-content'>
                    <h2>Erreur</h2>
                    <p>Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer.</p>
                    <button onclick='window.history.back()'>Retour</button>
                </div>
            </div>";
    }
} else {
    echo "<div class='modal-overlay'>
            <div class='modal-content'>
                <h2>Erreur</h2>
                <p>Veuillez remplir tous les champs du formulaire.</p>
                <button onclick='window.history.back()'>Retour</button>
            </div>
        </div>";
}
?>