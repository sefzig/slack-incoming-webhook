<?php
 
 // ----------------------------------
 // Slack Incoming Webhook
 // ----------------------------------
 // Dieses PHP-Skript kann auf einem beliebigen Server mit PHP mit Curl verwendet werden.
 // Es erlaubt das Senden einer Nachricht in einen bestimmten Kanal eines bestimmten Teams in Slack.
 // Das Skript kann als PHP eingebunden werden, Daten werden dann als Konstanten übergeben (siehe unten: "Einbindung PHP").
 // Das Skript kann auch per Ajax angesprochen werden, Daten werden dann als URL-Parameter übergeben (siehe unten: "Einbindung jQuery").
 // Du musst das Skript einmal konfigurieren, um das Default-Verhalten festzulegen (siehe unten: "Konfiguration").
 // ----------------------------------
    
 // ----------------------------------
 // Konfiguration
 // ----------------------------------
    
    $config_user =         "Incoming Webhook";
    $config_emoji =        "ok_hand";
    $config_team =         "sefzig"; // unbedingt ersetzen
    $config_sdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php"; // unbedingt ersetzen
    $config_service =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh"; // unbedingt ersetzen
    $config_api =          "abcd-1234567890-1234567890-1234567890-abcdef"; // unbedingt ersetzen
    $config_kanaldefault = "test"; // unbedingt ersetzen
    $config_kanal =        ""; // Nutzer-Eingabe
    $config_text =         ""; // Nutzer-Eingabe
    $config_kommentar =    ""; // Nutzer-Eingabe
    $config_name =         ""; // Nutzer-Eingabe
    $config_link =         "http://%slackteam%.slack.com/messages/%slackkanal%/";
    $config_erfolg =       '{ status: "Erfolg", link: "%slacklink%" }';
    $config_fehler =       '{ status: "Fehler", link: "http://sefzig.net/sdn/webhook/slack/" }';
    
 // ----------------------------------
 // Variablen und Defaults
 // ----------------------------------
 
 // Allgemeine Variablen konfigurieren
    $slackuser         = $_REQUEST["user"];         if (!isset($slackuser))         { $slackuser =         SLACK_USERNAME;     } if ((!isset($slackuser))         || ($slackuser         == "undefined") || ($slackuser         == ""))   { $slackuser         = $config_user; }
    $slackemoji        = $_REQUEST["emoji"];        if (!isset($slackemoji))        { $slackemoji =        SLACK_EMOJI;        } if ((!isset($slackemoji))        || ($slackemoji        == "undefined") || ($slackemoji        == ""))   { $slackemoji        = $config_emoji; }
    $slackteam         = $_REQUEST["team"];         if (!isset($slackteam))         { $slackteam =         SLACK_TEAM;         } if ((!isset($slackteam))         || ($slackteam         == "undefined") || ($slackteam         == ""))   { $slackteam         = $config_team; }
    $slacksdn          = $_REQUEST["sdn"];          if (!isset($slacksdn))          { $slacksdn =          SLACK_SDN;          } if ((!isset($slacksdn))          || ($slacksdn          == "undefined") || ($slacksdn          == "") || ($slacksdn          == "http://sefzig.net/sdn/webhook/slack/incoming.php"))                              { $slacksdn          = $config_sdn; }
    $slackservice      = $_REQUEST["service"];      if (!isset($slackservice))      { $slackservice =      SLACK_SERVICE;      } if ((!isset($slackservice))      || ($slackservice      == "undefined") || ($slackservice      == "") || ($slackservice      == "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh")) { $slackservice      = $config_service; }
    $slackapi          = $_REQUEST["api"];          if (!isset($slackapi))          { $slackapi =          SLACK_APIKEY;       } if ((!isset($slackapi))          || ($slackapi          == "undefined") || ($slackapi          == "") || ($slackapi          == "abcd-1234567890-1234567890-1234567890-abcdef"))                                  { $slackapi          = $config_api; }
    $slackkanaldefault = $_REQUEST["kanaldefault"]; if (!isset($slackkanaldefault)) { $slackkanaldefault = SLACK_KANALDEFAULT; } if ((!isset($slackkanaldefault)) || ($slackkanaldefault == "undefined") || ($slackkanaldefault == ""))   { $slackkanaldefault = $config_kanaldefault; }
    
 // Laufzeit-Variablen übernehmen
    $slackkanal        = $_REQUEST["kanal"];        if (!isset($slackkanal))        { $slackkanal =        SLACK_KANAL;        } if ((!isset($slackkanal))        || ($slackkanal        == "undefined")                                ) { $slackkanal        = $slackkanaldefault; }
    $slacktext         = $_REQUEST["text"];         if (!isset($slacktext))         { $slacktext =         SLACK_TEXT;         } if ((!isset($slacktext))         || ($slacktext         == "undefined")                                ) { $slacktext         = $config_text; }
    $slackkommentar    = $_REQUEST["kommentar"];    if (!isset($slackkommentar))    { $slackkommentar =    SLACK_KOMMENTAR;    } if ((!isset($slackkommentar))    || ($slackkommentar    == "undefined") || ($slackkommentar    == '""')) { $slackkommentar    = $config_kommentar; }
    $slackname         = $_REQUEST["name"];         if (!isset($slackname))         { $slackname =         SLACK_NAME;         } if ((!isset($slackname))         || ($slackname         == "undefined")                                ) { $slackname         = $config_name; }
    
 // Interne Variablen errechnen
    $slacklink         = $_REQUEST["link"];         if (!isset($slacklink))         { $slacklink =         SLACK_LINK;         } if ((!isset($slacklink))         || ($slacklink         == "undefined") || ($slacklink         == ""))   { $slacklink         = $config_link;   } $slacklink =   str_replace("%slackkanal%", $slackkanal, $slacklink); $slacklink = str_replace("%slackteam%",  $slackteam,  $slacklink);
    $slackerfolg       = $_REQUEST["erfolg"];       if (!isset($slackerfolg))       { $slackerfolg =       SLACK_ERFOLG;       } if ((!isset($slackerfolg))       || ($slackerfolg       == "undefined") || ($slackerfolg       == ""))   { $slackerfolg       = $config_erfolg; } $slackerfolg = str_replace("%slacklink%",  $slacklink,  $slackerfolg);
    $slackfehler       = $_REQUEST["fehler"];       if (!isset($slackfehler))       { $slackfehler =       SLACK_FEHLER;       } if ((!isset($slackfehler))       || ($slackfehler       == "undefined") || ($slackfehler       == ""))   { $slackfehler       = $config_fehler; } $slackfehler = str_replace("%slacklink%",  $slacklink,  $slackfehler);
    
 // ----------------------------------
 // PHP-Funktion aufrufen
 // ----------------------------------
 
 // Wenn Slack-Webhook erfolgreich
    if (slackhook($slackuser, $slackemoji, $slackteam, $slackservice, $slackapi, $slackkanaldefault, $slackkanal, $slacktext, $slackkommentar, $slackkommentar, $slackname, $slacklink, $slackerfolg, $slackfehler) == "ok") {
    
    // Erfolgsmeldung antwoten
       echo $slackerfolg;
    }
    
 // Wenn Slack-Webhook nicht erfolgreich
    else {
    
    // Fehlermeldung antwoten
       echo $slackfehler; /*
       echo "<ul>";
       echo   "<li> slacktext: ".$slacktext."</li>";
       echo   "<li> slackkanal: ".$slackkanal."</li>";
       echo   "<li> slackemoji: ".$slackemoji."</li>";
       echo   "<li> slackuser: ".$slackuser."</li>";
       echo   "<li> slackname: ".$slackname."</li>";
       echo   "<li> slackkommentar: ".$slackkommentar."</li>";
       echo "</ul>"; */
    }
    
 // ----------------------------------
 // PHP-Funktion der Integration
 // ----------------------------------
 
 // CURL-Webhooks an Slack
    function slackhook($slackuser, $slackemoji, $slackteam, $slackservice, $slackapi, $slackkanaldefault, $slackkanal, $slacktext, $slackkommentar, $slackkommentar, $slackname, $slacklink, $slackerfolg, $slackfehler) {
    
    // Fallbacks für Kanal und Botname
       $slackkanal = ($slackkanal) ? $slackkanal : $slackkanaldefault;
       $slackuser =   ($slackuser)   ? $slackuser   : $slackuser." (!)";
       
    // Wenn Kommentar und Name angegeben wurden
       if ((isset($slackname)) && ($slackname != "") && (isset($slackkommentar)) && ($slackkommentar != "") && ($slackkommentar != '""')) {

       // Kommentar und Name übernehmen
          $nachricht = "".$slackname.": ".$slackkommentar."";
          $title = $slackkommentar;
          $value = $slackname;
       }
       
    // Wenn nur ein Kommentar eingegeben wurde
       else if ((isset($slackkommentar)) && ($slackkommentar != "")) {
       
       // Kommentar übernehmen
          $nachricht = $slackkommentar;
          $value = $slackkommentar;
       }
       
    // Wenn nur der Name angegeben wurde
       else if ((isset($slackname)) && ($slackname != "")) {
       
       // Name übernehmen
          $nachricht = $slackname;
          $value = $slackname;
       }
       
    // Wenn Kommentar und-oder Name angegeben wurden
       if ((isset($nachricht)) && ($nachricht != "")) {
       
       // Slack-Message-Anhang-Feld setzen
          $feld = array([
             "title"       =>  $title,
             "value"       =>  $value,
             "short"       =>  false 
          ]);
       
       // Slack-Message-Anhang setzen 
          $anhang = array([
             "fallback"    =>  $nachricht,
          // "pretext"     =>  $nachricht,
             "color"       => "silver",
             "fields"      =>  $feld
          ]);
       }
       
    // Slack-Message setzen 
       $data = array(
          "token"          =>  $slackapi,
          "channel"        => "#".$slackkanal,
          "username"       =>  $slackuser,
          "text"           =>  $slacktext,
          "icon_emoji"     => ":".$slackemoji.":",
          "attachments"    =>  $anhang,
          "mrkdwn"         =>  true
       );
       
    // Slack-Message Json-encodieren
       $data = json_encode($data);
       
    // Slack-Service mit Curl aufrufen
       $ch = curl_init($slackservice);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       
    // Slack-Service schreiben
       $result = curl_exec($ch);
       
    // Slack-Service schließen
       curl_close($ch);
    
    // Webservice-Antwort ausgeben
       return $result;
    }
    
 // ----------------------------------
 // Einbindung PHP
 // ----------------------------------
 
 /* Slack-Integration: Konfiguration
    define( 'SLACK_USERNAME',     'Slack-Integration' );
    define( 'SLACK_EMOJI',        'ghost' );
    define( 'SLACK_TEAM',         'sefzig' );
    define( 'SLACK_SDN',          'http://sefzig.net/sdn/webhook/slack/incoming.php' );
    define( 'SLACK_SERVICE',      'https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh' );
    define( 'SLACK_APIKEY',       'abcd-1234567890-1234567890-1234567890-abcdef' );
    define( 'SLACK_KANALDEFAULT', 'test' );
                
 // Slack-Integration: Laufzeit
    define( 'SLACK_KANAL',        '' ); // Wird im Zweifel Default
    define( 'SLACK_TEXT',         '' );
    define( 'SLACK_KOMMENTAR',    '' );
    define( 'SLACK_NAME',         '' );
    
 // Slack-Integration: Oberfläche
    define( 'SLACK_LINK',         'http://%slackteam%.slack.com/messages/%slackkanal%/' ); // Kann %slackteam% und %slackkanal% enthalten
    define( 'SLACK_ERFOLG',       '{ status: "Erfolg", link: "%slacklink%" }' ); // Kann %slacklink% enthalten
    define( 'SLACK_FEHLER',       '{ status: "Fehler", link: "http://sefzig.net/sdn/webhook/slack/" }' ); // Kann %slacklink% enthalten
                
 // Slack-Integration: Sdn Webook Slack Incoming
    require_once('/www/htdocs/.../sdn/webhook/slack/incoming.php');
 */                
 
 // ----------------------------------
 // Einbindung jQuery
 // ----------------------------------
 /*
 // Ajax vorbereiten
    var par = "";
    var cachebreaker = Math.floor((Math.random() * 999999) + 1);
    
 // Allgemeine Variablen
    var url =          $("#sdn").val();
    var sdn =          $("#sdn")         .val(); var par = par+"&sdn="         +sdn;
    var service =      $("#service")     .val(); var par = par+"&service="     +service;
    var api =          $("#api")         .val(); var par = par+"&api="         +api;
    var kanaldefault = $("#kanaldefault").val(); var par = par+"&kanaldefault="+kanaldefault;
    
 // Nutzer-Eingaben
    var user =         $("#user")        .val(); var par = par+"&user="        +user;
    var emoji =        $("#emoji")       .val(); var par = par+"&emoji="       +emoji;
    var team =         $("#team")        .val(); var par = par+"&team="        +team;
    
 // Laufzeit-Variablen
    var kanal =        $("#kanal")       .val(); var par = par+"&kanal="       +kanal;
    var text =         $("#text")        .val(); var par = par+"&text="        +text;
    var kommentar =    $("#kommentar")   .val(); var par = par+"&kommentar="   +kommentar;
    var name =         $("#name")        .val(); var par = par+"&name="        +name;
    
 // Interne Variablen
    var link =         $("#link")        .val(); var par = par+"&link="        +link;
    var erfolg =       $("#erfolg")      .val(); var par = par+"&erfolg="      +erfolg;
    var fehler =       $("#fehler")      .val(); var par = par+"&fehler="      +fehler;
    
 // Ajax-URL zusammensetzen
    url = url+"?cachebreaker="+cachebreaker+""+par;
    
 // Skript mit Ajax ansprechen
    $.get(url, function(data) {
    // alert( "jQuery.get(): "+data );
    })
    .done(function(data) {
    // Ajax erfolgreich
       $("#ausgabe").html("Antwort: "+data).show();
    })
    .fail(function(data) {
    // Ajax fehlerhaft
       $("#ausgabe").html("Antwort: "+data).show();
    });
  */
  
?>