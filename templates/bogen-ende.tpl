<div class="rubrik"><span>&nbsp;</span></div>
<h1>Prüfungsbogen üben</h1>
<h2>Fragenbogen beantwortet</h2>
<p>Sie haben alle Fragen des Prüfungsbogens beantwortet. Hier sehen Sie nun
   eine Zusammenfassung über richtig bzw. falsch beantwortete Fragen und ob
   Sie mit der Fehlerquote die Prüfung bestanden hätten.</p>
<div height="10"></div>

<form name="neu" action="{scriptName}?show=bogen" method="post">
<input type="hidden" name="create" value="1" />
</form>

<table class="fragebkg" cellspacing="1" cellpadding="4" border="0" width="100%">
  <tr>
    <td>Insgesamt beantwortete Fragen:</td>
    <td><b>{anzFragen}</b></td>
  </tr>
  <tr>
    <td>Benötigte Zeit:</td>
    <td><b>{zeit}</b></td>
  </tr>
  <tr>
    <td><font class="korrekt">Richtig beantwortete Fragen:</font></td>
    <td><b>{fragenRichtig}</b></td>
  </tr>
  <tr>
    <td style="padding-left: 20px">Prozentualer Anteil:</td>
    <td><b>{fragenRichtigQuote}</b></td>
  </tr>
  <tr>
    <td><font class="falsch">Falsch beantwortete Fragen:</font></td>
    <td><b>{fragenFalsch}</b></td>
  </tr>
  <tr>
    <td style="padding-left: 20px">Prozentualer Anteil:</td>
    <td><b>{fragenFalschQuote}</b></td>
  </tr>
  <tr>
    <td colspan="2" align="center">Mit dieser Fehlerqoute hätten Sie die Prüfung
    {|Bestanden}{|Bestanden*Ja}<font class="korrekt">bestanden</font>{|Bestanden*Ja}{|Bestanden*Nein}<font class="falsch">nicht bestanden</font>{|Bestanden*Nein}{|Bestanden}.</td>
  </tr>
</table>
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td align="center"><input type="button" value="Neuer Fragenbogen" onClick="neu.submit();" /></td>
  </tr>
</table>

<div>&nbsp;</div>

<h2>Auflösung</h2>
<p>Hier sehen Sie nocheinmal sämtliche Fragen aufgeführt. Die
farblichen Kennzeichnungen entsprechen den richtigen bzw. falschen Antworten.
Die Häkchen dahinter entsprechen Ihren Antworten. So können Sie
schnell und übersichtlich vergleichen, wo Sie Fehler gemacht haben und
noch üben müssen.</p>
<p>Die mit <img src="img/richtig.gif" width="20" height="20" alt="Richtig" />
gekennzeichneten Fragen haben Sie korrekt beantwortet, die mit
<img src="img/falsch.gif" width="20" height="20" alt="Falsch" />
gekennzeichneten haben Sie falsch beantwortet.</p>

{|Aufloesung}
{|Aufloesung*Antwort}
<div>&nbsp;</div>
<table class="fragebkg" cellspacing="1" cellpadding="4" border="0" width="100%">
  <colgroup>
    <col width="5%">
    <col width="30%">
    <col width="55%">
    <col width="5%">
    <col width="5%">
  </colgroup>
  <tr>
    <td rowspan="{rowCnt}" valign="top"><b>{abschnittNr}.{frageNr}</b>{|BogenStatus}
    {|BogenStatus*BR}<br /><br />{|BogenStatus*BR}
    {|BogenStatus*Richtig}<img src="img/richtig.gif" width="20" height="20" alt="Richtig" />{|BogenStatus*Richtig}
    {|BogenStatus*Falsch}<img src="img/falsch.gif" width="20" height="20" alt="Falsch" />{|BogenStatus*Falsch}
    {|BogenStatus}</td>
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
{|Aufloesung*Antwort}
{|Aufloesung*Topline}
<ul id="seitenanfang">
<li class="left"> </li>
<li class="right"><a href="#top" title="Nach Oben" alt="Nach Oben">
<img src="img/oben.gif" alt="Oben" border="0" title="Oben"/></a></li>
</ul>
{|Aufloesung*Topline}
{|Aufloesung}