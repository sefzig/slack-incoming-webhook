<?php

 // ----------------------------------
 // Konfiguration
 // ----------------------------------
    
 // Dienst
    $config_service =      "https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh"; // unbedingt ersetzen
    $config_api =          "abcd-1234567890-1234567890-1234567890-abcdef"; // unbedingt ersetzen
    $config_sdn =          "http://sefzig.net/sdn/webhook/slack/incoming.php";
    $config_kanaldefault = "test"; // unbedingt ersetzen
    
 // Zielslack
    $config_team =         "sefzig";
    $config_kanal =        ""; // Nutzer-Eingabe
    
 // Absender
    $config_user =         "Andreas Sefzig";
    $config_emoji =        "sefzig";
    
 // Nachricht
    $config_text =         ""; // Nutzer-Eingabe
    $config_kommentar =    ""; // Nutzer-Eingabe
    $config_name =         ""; // Nutzer-Eingabe
    
 // Antwort
    $config_link =         "http://%slackteam%.slack.com/messages/%slackkanal%/"; // Dienst-URL
    $config_erfolg =       '{ status: "Erfolg", link: "%slacklink%" }'; // String beliebigen Formats
    $config_fehler =       '{ status: "Fehler", link: "http://sefzig.net/sdn/webhook/slack/" }'; // String beliebigen Formats
    
 // Automatisch senden
    $config_senden =       "nein"; // ja
    
 // ----------------------------------
 // URL-Parameter
 // ----------------------------------
    
 // Dienst
    $slackservice      = saubern($_REQUEST["service"]);
    $slackapi          = saubern($_REQUEST["api"]);
    $slacksdn          = saubern($_REQUEST["sdn"]);
    $slackkanaldefault = saubern($_REQUEST["kanaldefault"]);
    
 // Zielslack
    $slackteam         = saubern($_REQUEST["team"]);
    $slackkanal        = saubern($_REQUEST["kanal"]);
    
 // Absender
    $slackuser         = saubern($_REQUEST["user"]);
    $slackemoji        = saubern($_REQUEST["emoji"]);
    
 // Nachricht
    $slacktext         = saubern($_REQUEST["text"]);
    $slackkommentar    = saubern($_REQUEST["kommentar"]);
    $slackname         = saubern($_REQUEST["name"]);
    
 // Absender
    $slacklink         = saubern($_REQUEST["link"]);
    $slackerfolg       = saubern($_REQUEST["erfolg"]);
    $slackfehler       = saubern($_REQUEST["fehler"]);
    
 // Automatisch senden
    $slacksenden       = saubern($_REQUEST["senden"]);
    
 // ----------------------------------
 // Defaults
 // ----------------------------------
    
 // Dienst
    if ((!isset($slackservice))      || ($slackservice      == "undefined") || ($slackservice      == ""))   { $slackservice      = $config_service; }
    if ((!isset($slackapi))          || ($slackapi          == "undefined") || ($slackapi          == ""))   { $slackapi          = $config_api; }
    if ((!isset($slacksdn))          || ($slacksdn          == "undefined") || ($slacksdn          == ""))   { $slacksdn          = $config_sdn; }
    if ((!isset($slackkanaldefault)) || ($slackkanaldefault == "undefined") || ($slackkanaldefault == ""))   { $slackkanaldefault = $config_kanaldefault; }
    
 // Absender
    if ((!isset($slackuser))         || ($slackuser         == "undefined") || ($slackuser         == ""))   { $slackuser         = $config_user; }
    if ((!isset($slackemoji))        || ($slackemoji        == "undefined") || ($slackemoji        == ""))   { $slackemoji        = $config_emoji; }
    
 // Nutzer-Eingaben
    if ((!isset($slackteam))         || ($slackteam         == "undefined") || ($slackteam         == ""))   { $slackteam         = $config_team; }
    if ((!isset($slackkanal))        || ($slackkanal        == "undefined") || ($slackkanal        == ""))   { $slackkanal        = $slackkanaldefault; }
    if ((!isset($slacktext))         || ($slacktext         == "undefined") || ($slacktext         == ""))   { $slacktext         = $config_text; }
    if ((!isset($slackkommentar))    || ($slackkommentar    == "undefined") || ($slackkommentar    == '""')) { $slackkommentar    = $config_kommentar; }
    if ((!isset($slackname))         || ($slackname         == "undefined") || ($slackname         == ""))   { $slackname         = $config_name; }
    
 // Absender
    if ((!isset($slacklink))         || ($slacklink         == "undefined") || ($slacklink         == ""))   { $slacklink         = $config_link; }
    if ((!isset($slackerfolg))       || ($slackerfolg       == "undefined") || ($slackerfolg       == ""))   { $slackerfolg       = $config_erfolg; }
    if ((!isset($slackfehler))       || ($slackfehler       == "undefined") || ($slackfehler       == ""))   { $slackfehler       = $config_fehler; }
    
 // Automatisch senden
    if ((!isset($slacksenden))       || ($slacksenden       == "undefined") || ($slacksenden       == ""))   { $slacksenden       = $config_senden; }
    
 // ----------------------------------
 // Demo-Parameter defaulten
 // ----------------------------------
    
    if ($slackservice      == "https://hooks.slack.com/services/123456789/123456789/123456789012345678901234") { $slackservice = $config_service; }
    if ($slackapi          == "abcd-1234567890-1234567890-1234567890-123456")                                  { $slackapi =     $config_api; }
    if ($slacksdn          == "sefzig.net")                                                                    { $slacksdn =     $config_sdn; }
    
 // ----------------------------------
 // URL-Parameter säubern
 // ----------------------------------
    
    function saubern($text)
    {
    // $text = str_replace("%raute%", "#", $text);
       return $text;
    }
    
 // ----------------------------------
 // Ausgabe
 // ----------------------------------
    
?><!DOCTYPE html><html>
  <head>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Nachricht in Slack senden</title>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, height=device-height, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    
    <link rel="shortcut icon" type="image/x-icon" href="../../../../../cdn/sefzignet/img/ios_favicon.png" /> 
    <link rel="apple-touch-icon" href="../../../../../cdn/sefzignet/img/ios_favicon.png">
    <link rel="apple-touch-startup-image" href="../../../../../cdn/sefzignet/img/ios_startup.png">
    
    <style>
    
       body, p, input { 
          font-family: "Helvetica Neue", Arial, sans-serif;
          font-size: 12px;
       }
       p { 
          margin-top: 5px;
          margin-bottom: 5px;
       }
       input { 
          width: 100%;
       }
       #antworten { 
          margin-top: 10px;
          margin-bottom: 10px;
       }
       #antworten > div { 
          display: none;
          margin: 5px;
          padding: 5px;
          background: black;
          font-family: "Courier New", Times, serif;
          color: white;
       }
    
    </style>
    
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script> $(document).ready(function() { if ("<?=$slacksenden?>" == "ja") { $("#absenden").trigger("click"); } }); </script>
    
  </head>
  <body>
      
    <div id="inhalt">
        
      <h1>Nachricht in Slack senden</h1>
      
      Hier kannst Du eine Nachricht in einen bestimmten Kanal eines bestimmten Teams in Slack senden.
      <a id="mehrlink" href="javascript:preventDefault()" onclick="$('#mehr').show(); $(this).hide();">Mehr...</a>
      
      <span id="mehr" style="display: none;">
        Nachrichten und Anhänge können Markdown enthalten (<a href="https://api.slack.com/docs/formatting" target="_blank">siehe Dokumentation</a>).
        Das Skript verwendet die Slack-Integration <a href="https://my.slack.com/services/new/incoming-webhook/" target="_blank">Incoming Webhooks</a>, 
        die zu dem Kanal/Team hinzugefügt sein muss. 
        Du kannst das Skript auf Deinem eigenen Server hosten und-oder mit Deinem eigenen Dienst (in PHP oder Javascript/Ajax) verwenden -
        Du kannst es <a href="incoming.zip">als Zip herunterladen</a> oder <a href="https://github.com/sefzig/slack-incoming-webhook" target="_blank">auf Github forken</a>. 
        Das Skript in "index.php" - diese Seite - ruft per jQuery.get() den Webservice "incoming.php", welcher mit Slack spricht, auf und gibt dessen Antwort aus.
        Wie so oft stellen URL-Parameter-Zeichen ein Problem dar, weshalb "#" als "%raute%" geschrieben werden muss.
        <a href="javascript:preventDefault()" onclick="$('#mehrlink').show(); $('#mehr').hide();">Weniger...</a>
      </span>
      
      <h2>Ziel-Slack</h2>
      Team und Kanal
      <p><input id="team"          type="text"   value="<?=$slackteam?>" /></p>
      <p><input id="kanal"         type="text"   value="<?=$slackkanal?>" /></p>
      
 <!-- <h2>Dienst</h2> -->
 <!-- Service-URL und API-Key der <a href="https://my.slack.com/services/new/incoming-webhook/" target="_blank">Integration</a> -->
 <!-- <p><input id="sdn"           type="hidden" value="<?=$slacksdn?>" /></p> -->
 <!-- <p><input id="service"       type="hidden" value="<?=$slackservice?>" /></p> -->
 <!-- <p><input id="api"           type="hidden" value="<?=$slackapi?>" /></p> -->
 <!-- <p><input id="kanaldefault"  type="hidden" value="<?=$slackkanaldefault?>" /></p> -->
 
      <h2>Absender</h2>
      Name und Emoticon
      <p><input id="user"          type="text"   value="<?=$slackuser?>" /></p>
      <p><input id="emoji"         type="text"   value="<?=$slackemoji?>" /></p>
      
      <h2>Nachricht</h2>
      Nachricht
      <p><input id="text"          type="text"   value="<?=$slacktext?>" /></p>
      Optional: Kommentar und Name
      <p><input id="kommentar"     type="text"   value="<?=$slackkommentar?>" /></p>
      <p><input id="name"          type="text"   value="<?=$slackname?>" /></p>
      
 <!-- <h2>Antwort</h2> -->
      <input id="link"             type="hidden" value="<?=$config_link?>" /><!--   Kann %slackteam% und %slackkanal% enthalten -->
      <input id="erfolg"           type="hidden" value='<?=$config_erfolg?>' /><!-- Kann %slacklink% enthalten -->
      <input id="fehler"           type="hidden" value='<?=$config_fehler?>' /><!-- Kann %slacklink% enthalten -->
      
      <h2>Absenden</h2>
      Die Nachricht in Slack senden
      <p><input id="absenden"      type="button" value="In Slack senden" onclick="absenden()" /></p>
      
    </div>
    
<!--<h2>Antwort ausgeben</h2> -->
    <div id="antworten">
      <div id="eingabe"></div>
      <div id="ausgabe"></div>
    </div>
    
    <script>
    
    // Webhook einbinden
       function absenden() {
       	  
       // ----------------------------
       // Formular-Eingaben
          var par =   "";
       // ----------------------------
 
       // Zielslack
          var team =         $("#team").val();         var par = par+"&team="+        team;
          var kanal =        $("#kanal").val();        var par = par+"&kanal="+       kanal;
       // Dienst
       // var sdn =          $("#sdn").val();          var par = par+"&sdn="+         sdn;
       // var service =      $("#service").val();      var par = par+"&service="+     service;
       // var api =          $("#api").val();          var par = par+"&api="+         api;
       // var kanaldefault = $("#kanaldefault").val(); var par = par+"&kanaldefault="+kanaldefault;
       // Absender
       	  var user =         $("#user").val();         var par = par+"&user="+        user;
       	  var emoji =        $("#emoji").val();        var par = par+"&emoji="+       emoji;
       // Nachricht
       	  var text =         $("#text").val();         var par = par+"&text="+        text;
       	  var kommentar =    $("#kommentar").val();    var par = par+"&kommentar="+   kommentar;
       	  var name =         $("#name").val();         var par = par+"&name="+        name;
       // Antwort
       	  var link =         $("#link").val();         var par = par+"&link="+        link;
       	  var erfolg =       $("#erfolg").val();       var par = par+"&erfolg="+      erfolg;
       	  var fehler =       $("#fehler").val();       var par = par+"&fehler="+      fehler;
       	  
       // ----------------------------
       // Webservice aufrufen
          var url = "";
       // ----------------------------
 
       // Webservice-URL
          var url = url+"<?=$config_sdn?>";
          var cachebreaker = Math.floor((Math.random() * 999999) + 1);
       	  url = url+"?cachebreaker="+cachebreaker+""+par;
          $("#eingabe").html(""+url).show();
       	  
       // Ajax
       	  $.get(url, function(data) {
          // $("#ausgabe").html("jQuery.get: "+data).show();
          })
          
       // ----------------------------
       // Webservice-Antwort
       // ----------------------------
 
       // Ajax erfolgreich
          .done(function(data) {
             $("#ausgabe").html(""+data).show();
          })
          
       // Ajax fehlerhaft
          .fail(function(data) {
             $("#ausgabe").html("Fehler: "+data).show();
          });
       }
    
    </script>
    
  </body>
</html>