<div class="rubrik"><span>&nbsp;</span></div>
<h1>Zufallsfragen üben</h1>
<h2>Sie haben alle Fragen beantwortet!</h2>
<p>Sie haben alle Fragen des gewählten Kataloges beantwortet. Hier sehen Sie nun
    eine Zusammenfassung über richtig bzw. falsch beantwortete Fragen und ob
    Sie mit der Fehlerquote einen Testbogen bestanden hätten.</p>
<div height="10"></div>

<form name="neu" action="{scriptName}?show=fragen" method="post">
  <input type="hidden" name="action" value="neu" />
</form>

<table class="fragebkg" cellspacing="1" cellpadding="4" border="0" width="100%">
  <tr>
    <td>Insgesamt beantwortete Fragen:</td>
    <td><b>{anzFragen}</b></td>
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
    <td><input type="button" value="Neuer Fragenkatalog" onClick="neu.submit();" /></td>
  </tr>
</table>