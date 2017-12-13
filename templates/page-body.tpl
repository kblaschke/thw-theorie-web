<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
    <title>THW Basisausbildung: Die Theorieprüfung (Stand {catalogYear})</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta name="author" content="Kai Blaschke" />
    <meta name="description" content="Online-Fragebogen zum Üben der Theoriefragen zur Basisausbildung I (ehem. Grundausbildung) des Technischen Hilfswerks" />
    <meta name="keywords" content="THW,Technisches Hilfswerk,Theorie,Prüfung,Basisausbildung,Ausbildung,Fragebogen,Online-Prüfung" />

    <meta property="og:title" content="THW-Basisausbildung: Die Theorieprüfung" />
    <meta property="og:description" content="Online-Fragebogen zum Üben der Theoriefragen der Basisausbildung I des Technischen Hilfswerks" />
    <meta property="og:image" content="/img/og_thumbnail.png" />

    <base href="{baseUrl}" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
    {extraStyleSheet}
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="socialshareprivacy/jquery.js"></script>
</head>
<body>
<a name="top"></a>
<table cellspacing="0" cellpadding="0" border="0" class="layout">
  <tr>
    <td class="randlinks"><img src="img/clear.gif" alt="" width="12" height="20" /></td>
    <td class="navspalte"><img src="img/clear.gif" alt="" width="196" height="20" /></td>
    <td id="service">
        <a href="barrierefreiheit.html" title="Barrierefreiheit" ><span>Barrierefreiheit</span></a> |
        <a href="datenschutz.html" title="Datenschutz" ><span>Datenschutz</span></a> |
        <a href="impressum.html" title="Impressum" ><span>Impressum</span></a>
    </td>
  </tr>
  <tr>
    <td class="randlinks"></td>
    <td class="navspalte"><a href="http://www.thw.de/" name="anfang" id="title" title="THW Homepage" width="196" height="78"><img src="img/Logo.gif" alt="THW Homepage" /></a></td>
    <td>
      <table cellspacing="0" cellpadding="0" border="0" class="identitaet">
        <tr>
          <td class="thema"><img src="img/banner.gif" width="380" height="78" alt="THW - Die Theorie" /></td>
          <td class="logo"><img src="img/thwlogo.gif" width="188" height="78" alt="Technisches Hilfswerk" /></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td></td>
    <td class="navvor"><img src="img/default.gif" alt="" width="1" height="20" /></td>
    <td id="breadcrumb">
      <span>&nbsp;&raquo;&nbsp;</span><a href="index.html" title="Home" ><span>Home</span></a>{|Breadcrumb}{|Breadcrumb*Link}<span>&nbsp;&raquo;&nbsp;</span><a href="{scriptName}?show={page}"><span>{pageTitle}</span></a>{|Breadcrumb*Link}{|Breadcrumb}
    </td>
  </tr>
  <tr>
    <td class="randlinks"></td>  
    <td valign="top">

        <div class="nav">
            <ul id="navlist"><li><a id="{navZufall}" href="fragen.html" title="Eine bestimmte Anzahl Fragen in zuf&auml;lliger Reihenfolge &uuml;ben">Zuf&auml;llige Fragen &uuml;ben</a>
                    {|NavZufall}{|NavZufall*Sublinks}
                    <ul id="navlist"><li><a id="{navZufallNeu}" href="fragen.html?action=neu" title="Neue Fragen ausw&auml;hlen">Neue Fragen ausw&auml;hlen</a></li></ul>
                    {|NavZufall*Sublinks}{|NavZufall}
                </li></ul>
            <ul id="navlist"><li><a id="{navBogen}" href="bogen.html" title="Einen kompletten Fragebogen (40 Fragen) in einer bestimmten Zeit &uuml;ben">Pr&uuml;fungsbogen &uuml;ben</a>
                    {|NavBogen}{|NavBogen*Sublinks}
                    <ul id="navlist"><li><a id="{navBogenNeu}" href="bogen.html?action=neu" title="Neuer Fragebogen">Neuer Fragebogen</a></li></ul>
                    {|NavBogen*Sublinks}{|NavBogen}
                </li></ul>
            <ul id="navlist"><li><a id="{navAntworten}" href="loesung.html" title="Aufl&ouml;sungen zu allen Fragen anzeigen">Aufl&ouml;sungen</a>
                    {|NavAntworten}{|NavAntworten*Sublinks}
                    <ul id="navlist"><li><a id="{navAntwortenAbschnitt}" href="loesung/abschnitt-{abschnittNr}.html" title="{abschnittName}">Themenabschnitt {abschnittNr}</a></li></ul>
                    {|NavAntworten*Sublinks}{|NavAntworten}
                </li></ul>
            <ul id="navlist"><li><a id="{navOrdnung}" href="ordnung.html" title="Die offizielle THW-Pr&uuml;fungsvorschrift zum Nachlesen">Pr&uuml;fungsvorschrift</a></li></ul>
            <ul id="navlist"><li><a id="{navStats}" href="stats.html" title="Ihre Gesamtstatistik aufrufen">Gesamtstatistik</a></li></ul>
            <ul id="navlist"><li><a id="{navOffline}" href="downloads.html" title="Offline-Version herunterladen">Offline-Version</a></li></ul>
            <ul id="navlist"><li><a href="https://www.facebook.com/thwtheorie" title="Facebook-Community besuchen">THW-Theorie auf Facebook</a></li></ul>
        </div>

    </td>
    <td valign="top" class="content">
      <table border="0" style="max-width: 1000px;">
        <tr>
          <td class="contentspalte">
{~pageContent}
{~topLine}
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

</body>
</html>
