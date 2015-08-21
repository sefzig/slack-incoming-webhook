<!DOCTYPE html><html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Nachricht in Slack senden</title>
    <!-- Diese Datei dient der Demonstration der Slack-Integration in "incoming.php" via jQuery/Ajax -->
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, height=device-height, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" /> 
    <link rel="apple-touch-icon" href="img/ios_favicon.png">
    <link rel="apple-touch-startup-image" href="img/ios_startup.png">
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
          margin-top: 5px;
          margin-bottom: 5px;
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
        hier kannst Du es <a href="http://sefzig.net/sdn/webhook/slack/incoming.zip">als Zip herunterladen</a>. 
        Das Skript in "index.php" ruft per jQuery.get den Webservice "incoming.php" auf und gibt dessen Antwort aus.
        <a href="javascript:preventDefault()" onclick="$('#mehrlink').show(); $('#mehr').hide();">Weniger...</a>
      </span>
      <h2>Nachricht</h2>
      Text der Nachricht
      <p><input id="text"          type="text"   value="Mein Text" /></p>
      Optionaler Anhang: Kommentar und Name
      <p><input id="kommentar"     type="text"   value="" /></p>
      <p><input id="name"          type="text"   value="" /></p>
      <h2>Erscheinungsbild</h2>
      Name und Emoticon des Bots
      <p><input id="user"          type="text"   value="Incoming Webhook" /></p>
      <p><input id="emoji"         type="text"   value="ok_hand" /></p>
      <h2>Slack-Integration</h2>
      Ziel-Team und -Kanal
      <p><input id="team"          type="text"   value="sefzig" /></p>
      <p><input id="kanal"         type="text"   value="test" /></p>
      Service-URL und API-Key der <a href="https://my.slack.com/services/new/incoming-webhook/" target="_blank">Integration</a>
      <p><input id="service"       type="text"   value="https://hooks.slack.com/services/123456789/abcdefghihklmnopqrstuvwxyzabcdefgh" /></p>
      <p><input id="api"           type="text"   value="abcd-1234567890-1234567890-1234567890-abcdef" /></p>
      <p><input id="kanaldefault"  type="hidden" value="test" /></p>
      URL des Webhook-Skripts
      <p><input id="sdn"           type="text"   value="http://sefzig.net/sdn/webhook/slack/incoming.php" /></p>
      <h2>Absenden</h2>
      Die Nachricht in Slack senden
      <input id="link"             type="hidden" value="http://%slackteam%.slack.com/messages/%slackkanal%/" /><!-- Kann %slackteam% und %slackkanal% enthalten -->
      <input id="erfolg"           type="hidden" value='{ status: "Erfolg", link: "%slacklink%" }' /><!-- Kann %slacklink% enthalten -->
      <input id="fehler"           type="hidden" value='{ status: "Fehler", link: "http://sefzig.net/sdn/webhook/slack/" }' /><!-- Kann %slacklink% enthalten -->
      <p><input id="absenden"      type="button" value="In Slack senden" onclick="absenden()" /></p>
    </div>
    <div id="antworten">
      <div id="eingabe"></div>
      <div id="ausgabe"></div>
    </div>
    <script>
    
    // Webhook-Plugin einbinden
       function absenden() {
       	  
       // Ajax vorbereiten
       	  var url =    $("#sdn").val();
       	  var cachebreaker = Math.floor((Math.random() * 999999) + 1);
       	  var par =   "";
       	  
       // Allgemeine Variablen
       	  var user =         $("#user").val();         var par = par+"&user="+        user;
       	  var emoji =        $("#emoji").val();        var par = par+"&emoji="+       emoji;
       	  var team =         $("#team").val();         var par = par+"&team="+        team;
       	  var sdn =          $("#sdn").val();          var par = par+"&sdn="+         sdn;
       	  var service =      $("#service").val();      var par = par+"&service="+     service;
       	  var api =          $("#api").val();          var par = par+"&api="+         api;
       	  var kanaldefault = $("#kanaldefault").val(); var par = par+"&kanaldefault="+kanaldefault;
       	  
       // Laufzeit-Variablen
       	  var kanal =        $("#kanal").val();        var par = par+"&kanal="+       kanal;
       	  var text =         $("#text").val();         var par = par+"&text="+        text;
       	  var kommentar =    $("#kommentar").val();    var par = par+"&kommentar="+   kommentar;
       	  var name =         $("#name").val();         var par = par+"&name="+        name;
       	  
       // Interne Variablen
       	  var link =         $("#link").val();         var par = par+"&link="+        link;
       	  var erfolg =       $("#erfolg").val();       var par = par+"&erfolg="+      erfolg;
       	  var fehler =       $("#fehler").val();       var par = par+"&fehler="+      fehler;
       	  
       // Ajax-URL zusammensetzen
       	  url = url+"?cachebreaker="+cachebreaker+""+par;
          $("#eingabe").html("Frage: "+url).show();
       
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
       }
    
    </script>
  </body>
</html>