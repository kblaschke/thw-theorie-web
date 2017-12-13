<div class="rubrik"><span>&nbsp;</span></div>
<h1>Auflösungen</h1>
<p class="no-print">&laquo; <a href="{scriptName}?show=loesung" title="Zurück zur Auswahl">Zurück
zur Themenabschnittsauswahl</a></p>
<p><b>{abschnittName}</b></p>

{|Antworten}
{|Antworten*Row}
<table class="fragebkg" cellspacing="1" cellpadding="4" border="0" width="100%">
  <colgroup>
    <col width="5%">
    <col width="30%">
    <col width="55%">
    <col width="5%">
    <col width="5%">
  </colgroup>
  <tr>
    <td rowspan="{rowCnt}" valign="top"><b>{abschnittNr}.{frageNr}</b></td>
    <td rowspan="{rowCnt}" valign="top">{frageText}</td>
    <td ><font class="{antwort1Status}">{Antwort1}</font></td>
    <td align="center">A</td>
    <td align="center">{|A1L}{|A1L*Haken}<img src="img/haken.gif" width="16" height="16" alt="X">{|A1L*Haken}{|A1L}&nbsp;</td>
  </tr>
  <tr>
    <td><font class="{antwort2Status}">{Antwort2}</font></td>
    <td align="center">B</td>
    <td align="center">{|A2L}{|A2L*Haken}<img src="img/haken.gif" width="16" height="16" alt="X">{|A2L*Haken}{|A2L}&nbsp;</td>
  </tr>
{|ThreeRows}{|ThreeRows*Row}
  <tr>
    <td><font class="{antwort3Status}">{Antwort3}</font></td>
    <td align="center">C</td>
    <td align="center">{|A3L}{|A3L*Haken}<img src="img/haken.gif" width="16" height="16" alt="X">{|A3L*Haken}{|A3L}&nbsp;</td>
  </tr>
{|ThreeRows*Row}{|ThreeRows}
</table>
{|Antworten*Row}
{|Antworten*Topline}
<ul class="seitenanfang">
<li class="left"> </li>
<li class="right"><a href="#top" title="Nach Oben" alt="Nach Oben">
<img src="img/oben.gif" alt="Oben" border="0" title="Oben"/></a></li>
</ul>
{|Antworten*Topline}
{|Antworten}