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
    
 // Default-Absender
    $config_user =         "Buh";
    $config_emoji =        "ghost";
    
 // Default-Zielslack
    $config_team =         "sefzig";
    $config_kanal =        "test";
    
 // Default-Dienst
    $config_offen =        "nein"; // ja
    $config_sdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
    $config_service =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh";
    $config_api =          "abcd-1234567890-1234567890-1234567890-abcdef";
    $config_kanaldefault = "test";
    
 // Default-Antworten
    $config_link =         "http://%slackteam%.slack.com/messages/%slackkanal%/"; // Dienst-URL
    $config_erfolg =       '{ status: "Erfolg", link: "%slacklink%" }'; // String beliebigen Formats
    $config_fehler =       '{ status: "Fehler", link: "http://sefzig.net/sdn/webhook/slack/" }'; // String beliebigen Formats
    
 // Fehlermeldung
    $config_text =         "Fehler";
    $config_kommentar =    "Die Einbindung ist falsch konfiguriert.";
    $config_name =         "incoming.php";
    
 // Fehlerbehebung
    $debug_request =       "PHP Request aus URL:";
    
 // ----------------------------------
 // URL-Parameter (ohne Dienst)
 // ----------------------------------
    
 // Absender
    $slackuser         = saubern($_REQUEST["user"]);      $debug_request .= "<br />slackuser:      ".$slackuser."";         
    $slackemoji        = saubern($_REQUEST["emoji"]);     $debug_request .= "<br />slackemoji:     ".$slackemoji."";        
    
 // Zielslack
    $slackteam         = saubern($_REQUEST["team"]);      $debug_request .= "<br />slackteam:      ".$slackteam."";         
    $slackkanal        = saubern($_REQUEST["kanal"]);     $debug_request .= "<br />slackkanal:     ".$slackkanal."";        
    
 // Nachricht
    $slacktext         = saubern($_REQUEST["text"]);      $debug_request .= "<br />slacktext:      ".$slacktext."";         
    $slackkommentar    = saubern($_REQUEST["kommentar"]); $debug_request .= "<br />slackkommentar: ".$slackkommentar."";    
    $slackname         = saubern($_REQUEST["name"]);      $debug_request .= "<br />slackname:      ".$slackname."";         
    
 // Antwort
    $slacklink         = saubern($_REQUEST["link"]);      $debug_request .= "<br />slacklink:      ".$slacklink."";         
    $slackerfolg       = saubern($_REQUEST["erfolg"]);    $debug_request .= "<br />slackerfolg:    ".$slackerfolg."";       
    $slackfehler       = saubern($_REQUEST["fehler"]);    $debug_request .= "<br />slackfehler:    ".$slackfehler."";       
    
 // ----------------------------------
 // Demo-Parameter zu Default
 // ----------------------------------
 
    if (($slacksdn     == "http://sefzig.net/sdn/webhook/slack/incoming.php"))                              { $slacksdn     = $config_sdn; }
    if (($slackservice == "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh")) { $slackservice = $config_service; }
    if (($slackapi     == "abcd-1234567890-1234567890-1234567890-abcdef"))                                  { $slackapi     = $config_api; }
    
 // ----------------------------------
 // URL-Parameter säubern
 // ----------------------------------
    
    function saubern($text)
    {
       $text = str_replace("%raute%", "#", $text);
       $text = str_replace("%zeilenumbruch%", "\n", $text);
       return $text;
    }
    
 // ----------------------------------
 // Team-Konfigurationen
 // ----------------------------------
 
    if ($slackteam == "sefzig")
    {
       $slackteam =         "sefzig";
       $slackservice =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh";
       $slackapi =          "abcd-1234567890-1234567890-1234567890-abcdef";
       $slacksdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
       $slackkanaldefault = "test";
    }
    else if ($slackteam == "OnlineWerbung")
    {
       $slackteam =         "onlinewerbung";
       $slackservice =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh";
       $slackapi =          "abcd-1234567890-1234567890-1234567890-abcdef";
       $slacksdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
       $slackkanaldefault = "allgemein";
    }
    else if ($slackteam == "SocialMedia")
    {
       $slackteam =         "publicissocial";
       $slackservice =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh";
       $slackapi =          "abcd-1234567890-1234567890-1234567890-abcdef";
       $slacksdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
       $slackkanaldefault = "allgemein";
    }
    else if ($slackteam == "GoldIdeen")
    {
       $slackteam =         "goldideen";
       $slackservice =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh";
       $slackapi =          "abcd-1234567890-1234567890-1234567890-abcdef";
       $slacksdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
       $slackkanaldefault = "allgemein";
    }
    else // Defaults
    {
       $slackteam =         $config_team;
       $slackservice =      $config_service;
       $slackapi =          $config_api;
       $slacksdn =          $config_sdn;
       $slackkanaldefault = $config_kanaldefault;
    }
    
 // ----------------------------------
 // Dienst-Konfig per URL 
 // ----------------------------------
    
    if ($config_offen == "ja")
    {
       $slackteam         = saubern($_REQUEST["team"]);         $debug_request .= "<br />slackteam:         ".$slackteam."";          
       $slacksdn          = saubern($_REQUEST["sdn"]);          $debug_request .= "<br />slacksdn:          ".$slacksdn."";          
       $slackapi          = saubern($_REQUEST["api"]);          $debug_request .= "<br />slackapi:          ".$slackapi."";          
       $slackservice      = saubern($_REQUEST["service"]);      $debug_request .= "<br />slackservice:      ".$slackservice."";      
       $slackkanaldefault = saubern($_REQUEST["kanaldefault"]); $debug_request .= "<br />slackkanaldefault: ".$slackkanaldefault."";
    }
    
 // ----------------------------------
 // Defaults?
 // ----------------------------------
    
 // Dienst
    if ((!isset($slacksdn))          || ($slacksdn          == "undefined") || ($slacksdn          == ""))   { $slacksdn          = $config_sdn; }
    if ((!isset($slackservice))      || ($slackservice      == "undefined") || ($slackservice      == ""))   { $slackservice      = $config_service; }
    if ((!isset($slackapi))          || ($slackapi          == "undefined") || ($slackapi          == ""))   { $slackapi          = $config_api; }
    if ((!isset($slackkanaldefault)) || ($slackkanaldefault == "undefined") || ($slackkanaldefault == ""))   { $slackkanaldefault = $config_kanaldefault; }
    
 // Absender
    if ((!isset($slackuser))         || ($slackuser         == "undefined") || ($slackuser         == ""))   { $slackuser         = $config_user; }
    if ((!isset($slackemoji))        || ($slackemoji        == "undefined") || ($slackemoji        == ""))   { $slackemoji        = $config_emoji; }
    
 // Nutzer-Eingaben
    if ((!isset($slackteam))         || ($slackteam         == "undefined") || ($slackteam         == ""))   { $slackteam         = $config_team; }
    if ((!isset($slackkanal))        || ($slackkanal        == "undefined"))                                 { $slackkanal        = $slackkanaldefault; }
    if ((!isset($slacktext))         || ($slacktext         == "undefined"))                                 { $slacktext         = $config_text; }
    if ((!isset($slackkommentar))    || ($slackkommentar    == "undefined") || ($slackkommentar    == '""')) { $slackkommentar    = $config_kommentar; }
    if ((!isset($slackname))         || ($slackname         == "undefined"))                                 { $slackname         = $config_name; }
    
 // Antwort
    if ((!isset($slacklink))         || ($slacklink         == "undefined") || ($slacklink         == ""))   { $slacklink         = $config_link;   } 
    if ((!isset($slackerfolg))       || ($slackerfolg       == "undefined") || ($slackerfolg       == ""))   { $slackerfolg       = $config_erfolg; } 
    if ((!isset($slackfehler))       || ($slackfehler       == "undefined") || ($slackfehler       == ""))   { $slackfehler       = $config_fehler; } 
    
 // ----------------------------------
 // Antworten ausfüllen
 // ----------------------------------
    
    $slacklink =   str_replace("%slackkanal%", $slackkanal, $slacklink); 
    $slacklink =   str_replace("%slackteam%",  $slackteam,  $slacklink);
    
    $slackerfolg = str_replace("%slacklink%",  $slacklink,  $slackerfolg);
    $slackfehler = str_replace("%slacklink%",  $slacklink,  $slackfehler);
    $slackerfolg = str_replace("%slackkanal%", $slackkanal, $slackerfolg); 
    $slackfehler = str_replace("%slackkanal%", $slackkanal, $slackfehler); 
    
 // ----------------------------------
 // Slackhook aufrufen
 // ----------------------------------
 
 // Funktion aufrufen
    $slackwebhook = slackhook(
       $slackteam, 
       $slackkanal, 
       $slackservice, 
       $slackapi, 
       $slackkanaldefault, 
       $slackuser, 
       $slackemoji, 
       $slacktext, 
       $slackkommentar, 
       $slackname, 
       $slacklink, 
       $slackerfolg, 
       $slackfehler, 
       $debug_request);
    
 // Wenn Slack-Webhook erfolgreich
    if ($slackwebhook == "ok") {
    
    // Erfolgsmeldung antwoten
       echo $slackerfolg; 
    // echo "<br /><br />"; 
    // echo $debug_request; 
    }
    
 // Wenn Slack-Webhook nicht erfolgreich
    else {
    
    // Fehlermeldung antworten
       echo $slackfehler;
       echo "<br /><br />";
       echo "Debug Request:<br />";
       echo $debug_request;
       echo "<br /><br />";
       echo "Nutzer-Eingaben";
       echo "<ul>";
       echo   "<li> slacktext: ".$slacktext."</li>";
       echo   "<li> slackkanal: ".$slackkanal."</li>";
       echo   "<li> slackemoji: ".$slackemoji."</li>";
       echo   "<li> slackuser: ".$slackuser."</li>";
       echo   "<li> slackname: ".$slackname."</li>";
       echo   "<li> slackkommentar: ".$slackkommentar."</li>";
       echo "</ul>";
    }
    
 // ----------------------------------
 // Webhook-Funktion
 // ----------------------------------
 
    function slackhook($slackteam, 
       $slackkanal, 
       $slackservice, 
       $slackapi, 
       $slackkanaldefault, 
       $slackuser, 
       $slackemoji, 
       $slacktext, 
       $slackkommentar, 
       $slackname, 
       $slacklink, 
       $slackerfolg, 
       $slackfehler,
       $slackdebug) {
    
    // -------------------------------
    // Fallbacks
    // -------------------------------
 
       $slackkanal = ($slackkanal) ? $slackkanal : $slackkanaldefault;
       $slackuser =  ($slackuser)  ? $slackuser  : $slackuser." (!)";
       
    // -------------------------------
    // Nachrichten-Anhang
    // -------------------------------
 
    // Wenn Kommentar und Name angegeben wurden
       if ((isset($slackname)) 
          && ($slackname != "") 
          && (isset($slackkommentar)) 
          && ($slackkommentar != "") 
          && ($slackkommentar != '""')) {

       // Kommentar und Name übernehmen
          $nachricht = "".$slackname.": ".$slackkommentar."";
          $title = $slackkommentar;
          $value = $slackname;
       }
       
    // Wenn nur ein Kommentar eingegeben wurde
       else 
       if ((isset($slackkommentar)) 
          && ($slackkommentar != "")) {
       
       // Kommentar übernehmen
          $nachricht = $slackkommentar;
          $value = $slackkommentar;
       }
       
    // Wenn nur der Name angegeben wurde
       else 
       if ((isset($slackname)) 
          && ($slackname != "")) {
       
       // Name übernehmen
          $nachricht = $slackname;
          $value = $slackname;
       }
       
    // -------------------------------
    // Nachricht-Bestandteile zu Array
    // -------------------------------
 
    // Wenn Kommentar und-oder Name angegeben wurden
       if ((isset($nachricht)) && ($nachricht != "")) {
       
       // Anhang-Feld
          $feld = array([
             "title"       =>  $title,
             "value"       =>  $value,
             "short"       =>  false 
          ]);
       
       // Anhang
          $anhang = array([
             "fallback"    =>  $nachricht,
          // "pretext"     =>  $nachricht,
             "color"       => "silver",
             "fields"      =>  $feld
          ]);
       }
       
    // Nachricht
       $data = array(
          "token"          =>  $slackapi,
          "channel"        => "#".$slackkanal,
          "username"       =>  $slackuser,
          "text"           =>  $slacktext,
          "icon_emoji"     => ":".$slackemoji.":",
          "attachments"    =>  $anhang,
          "mrkdwn"         =>  true
       );
       
    // Nachricht Json-encodieren
       $data = json_encode($data);
       
    // -------------------------------
    // Dienst mit Curl ansprechen
    // -------------------------------
 
    // Slack-Service aufrufen
       $ch = curl_init($slackservice);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       
    // Slack-Service schreiben
       $result = curl_exec($ch);
       
    // Slack-Service schließen
       curl_close($ch);
    
    // -------------------------------
    // Antwort
    // -------------------------------
 
    // Antwort ausgeben
       return $result;
    }
    
 // ----------------------------------
 // Einbindung PHP
 /* ----------------------------------
    
 // Dienst
    $config_sdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
 // $config_service =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh";
 // $config_api =          "abcd-1234567890-1234567890-1234567890-abcdef";
 // $config_kanaldefault = "test";
    
 // Zielslack
    $config_team =         "sefzig";
    $config_kanal =        "test";
    
 // Absender
    $config_user =         "Buh";
    $config_emoji =        "ghost";
    
 // Nachricht
    $config_text =         "Titel: Der Text";
    $config_kommentar =    "Der Kommentar.";
    $config_name =         "Der Name";
    
 // Antworten
    $config_link =         'http://%slackteam%.slack.com/messages/%slackkanal%/'; // Dienst-URL
    $config_erfolg =       '{ status: "Erfolg", link: "%slacklink%" }'; // String beliebigen Formats
    $config_fehler =       '{ status: "Fehler", link: "http://sefzig.net/sdn/webhook/slack/" }'; // String beliebigen Formats
    
 // Slack-URI
    $uri = $config_sdn;
    $uri = $uri."?user="        .$config_user;
    $uri = $uri."&emoji="       .$config_emoji;
    $uri = $uri."&team="        .$config_team;
    $uri = $uri."&sdn="         .$config_sdn;
    $uri = $uri."&service="     .$config_service;
    $uri = $uri."&api="         .$config_api;
    $uri = $uri."&kanaldefault=".$config_kanaldefault;
    $uri = $uri."&link="        .$config_link;
    $uri = $uri."&erfolg="      .$config_erfolg;
    $uri = $uri."&fehler="      .$config_fehler;
    $uri = $uri."&text="        .$config_text;
    $uri = $uri."&kommentar="   .$config_kommentar;
    $uri = $uri."&name="        .$config_name;
    
 // Slack-Integration
    require_once($uri); */
 
 // ----------------------------------
 // Einbindung jQuery
 // ----------------------------------
 /*
 // Ajax vorbereiten
    var url = "http://sefzig.net/sdn/webhook/slack/incoming.php";
    var par = "";
    
 // Zielslack
    var team =         $("#team")        .val(); var par = par+"?team="        +team;
    var kanal =        $("#kanal")       .val(); var par = par+"&kanal="       +kanal;
    
 // Dienst
 // var service =      $("#service")     .val(); var par = par+"&service="     +service;
 // var api =          $("#api")         .val(); var par = par+"&api="         +api;
 // var sdn =          $("#sdn")         .val(); var par = par+"&sdn="         +sdn;
 // var kanaldefault = $("#kanaldefault").val(); var par = par+"&kanaldefault="+kanaldefault;
    
 // Absender
    var user =         $("#user")        .val(); var par = par+"&user="        +user;
    var emoji =        $("#emoji")       .val(); var par = par+"&emoji="       +emoji;
    
 // Nachricht
    var text =         $("#text")        .val(); var par = par+"&text="        +text;
    var kommentar =    $("#kommentar")   .val(); var par = par+"&kommentar="   +kommentar;
    var name =         $("#name")        .val(); var par = par+"&name="        +name;
    
 // Antwort
    var link =         $("#link")        .val(); var par = par+"&link="        +link;
    var erfolg =       $("#erfolg")      .val(); var par = par+"&erfolg="      +erfolg;
    var fehler =       $("#fehler")      .val(); var par = par+"&fehler="      +fehler;
    
 // Ajax-URL zusammensetzen
    var cachebreaker = Math.floor((Math.random() * 999999) + 1);
    url = url+"?c="+cachebreaker+""+par;
    
 // Webservice
    $.get(url, function(data) {
    // alert( "jQuery.get(): "+data );
    })
    
 // Ajax erfolgreich
    .done(function(data) {
       $("#ausgabe").html(""+data).show();
    })
    
 // Ajax fehlerhaft
    .fail(function(data) {
       $("#ausgabe").html("Fehler: "+data).show();
    });
  */
  
?>