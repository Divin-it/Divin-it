<?php

/**
 * Konfiguration 
 *
 * Bitte passen Sie die folgenden Werte an, bevor Sie das Script benutzen!
 * 
 * Das Skript bitte in UTF-8 abspeichern (ohne BOM).
 */
 
// An welche Adresse sollen die Mails gesendet werden?
$zieladresse = 'info@vib-schlimper.com';

// Welche Adresse soll als Absender angegeben werden?
// (Manche Hoster lassen diese Angabe vor dem Versenden der Mail ueberschreiben)
$absenderadresse = 'info@vib-schlimper.com';

// Welcher Absendername soll verwendet werden?
$absendername = 'Mitteilung von der Vermessungs- und Ingenieurbüro Schlimper GmbH Webseite';

// Welchen Betreff sollen die Mails erhalten?
$betreff = 'Mitteilung';

// Zu welcher Seite soll als "Danke-Seite" weitergeleitet werden?
// Wichtig: Sie muessen hier eine gueltige HTTP-Adresse angeben!
$urlDankeSeite = 'http://www.vib-schlimper.com/danke.html';

// Welche(s) Zeichen soll(en) zwischen dem Feldnamen und dem angegebenen Wert stehen?
$trenner = ":\t"; // Doppelpunkt + Tabulator

/**
 * Ende Konfiguration
 */

require_once "Swift-5.0.1/lib/swift_required.php"; // Swift initialisieren

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $message = Swift_Message::newInstance(); // Ein Objekt für die Mailnachricht.

    $message
        ->setFrom(array($absenderadresse => $absendername))
        ->setTo(array($zieladresse)) // alternativ existiert setCc() und setBcc()
        ->setSubject($betreff);

    $mailtext = "";

    foreach ($_POST as $name => $wert) {
        if (is_array($wert)) {
                foreach ($wert as $einzelwert) {
                $mailtext .= $name.$trenner.$einzelwert."\n";
            }
        } else {
            $mailtext .= $name.$trenner.$wert."\n";
        }
    }

    $message->setBody($mailtext, 'text/plain');

    $mailer = Swift_Mailer::newInstance(Swift_MailTransport::newInstance());
    $result = $mailer->send($message);

    if ($result == 0) {
        die("Mail konnte nicht versandt werden.");
    }

    header("Location: $urlDankeSeite");
    exit;
}

header("Content-type: text/html; charset=utf-8");

?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
    <head>
        <title>Einfacher PHP-Formmailer</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <h1>Kontaktformular</h1>
        <form action="" method="post">
            <!-- Hier die eigentlichen Formularfelder eintragen. Die folgenden sind Beispielangaben. --><!--
            <dl>
                <dt>Ihr Name:</dt>
                <dd><input type="text" name="Versender" /></dd>
                <dt>Ihre E-Mail:</dt>
                <dd><input type="text" name="E-Mail" /></dd>
                <dt>Sie können:</dt>
                <dd><input type="checkbox" name="kannwas[]" value="HTML" />HTML <input type="checkbox" name="kannwas[]" value="PHP" />PHP</dd>
                <dt>Sie sind:</dt>
                <dd><input type="radio" name="sexus" value="M" />Mann <input type="radio" name="sexus" value="Frau" />Frau</dd>
                <dt>Sie mögen:</dt>
                <dd><select name="Browser"><option value="Opera">Opera</option><option value="Mozilla">Mozilla</option></select></dd>
                <dt>Bemerkungen:</dt>
                <dd><textarea name="Bemerkungen" rows="3" cols="20">Bemerkungen</textarea></dd>
            </dl>
            <!-- Ende der Beispielangaben --><!--
            <p>
            <input type="submit" value="Senden" />
            <input type="reset" value="Zurücksetzen" />
            </p>
        </form>
    </body>
</html>
