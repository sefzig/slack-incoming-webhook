Slack Incoming Webhook
======================

Über

* Erlaubt das Senden einer Nachricht in einen bestimmten Kanal eines bestimmten Teams in Slack.
* Kann auf einem beliebigen Server mit PHP mit Curl verwendet werden.
* Kann als PHP eingebunden werden, Daten werden als URI-Parameter übergeben.
* Kann per Ajax angesprochen werden, Daten werden als URL-Parameter übergeben.

Inhalt

* incoming.php: Webservice in PHP, spricht mit Slack.
* index.php: Demonstration in jQuery, spricht mit Webservice.

Installation

* Webservice
** incoming.php irgendwo auf einem PHP-Server mit Curl-Erweiterung ablegen.
** Abschnitte "Konfiguration" und "Team-Konfiguration" anpassen.
** incoming.php als PHP einbinden oder mit Ajax aufrufen.
* Eingabe
** index.php umbenennen und irgendwo auf einem PHP-Server ablegen.
** Abschnitt "Konfiguration" anpassen.
** index.php nach belieben Anpassen und (mit URL-Parametern vorkonfiguriert) aufrufen.