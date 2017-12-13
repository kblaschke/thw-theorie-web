<div class="rubrik"><span>&nbsp;</span></div>
<h1>Statistiken</h1>

<p>Dies sind Ihre Gesamtstatistiken für diesen Besuch. Die Statistik enthält
sowohl die Zufallsfragen, als auch die Prüfungsbögen. Die Fragen
der Prüfungsbögen fließen in die Fragen-Statistik
mit ein. Wenn Sie die Statistiken löschen möchten, klicken
Sie bitte auf den Link "Zurücksetzen".</p>

<table class="fragebkg" cellspacing="1" cellpadding="4" border="0" style="width:300px;">
  <tr>
    <td>Fragen beantwortet:</td>
    <td>{fragenBisher}</td>
  </tr>
  <tr>
    <td class="korrekt">&nbsp;&nbsp;&nbsp;&nbsp;Davon Richtig:</td>
    <td class="korrekt">{fragenRichtig}</td>
  </tr>
  <tr>
    <td class="falsch">&nbsp;&nbsp;&nbsp;&nbsp;Davon Falsch:</td>
    <td class="falsch">{fragenFalsch}</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Quote:</td>
    <td>{fragenQuote}</td>
  </tr>
  <tr>
    <td>Fragebögen:</td>
    <td>{boegenBisher}</td>
  </tr>
  <tr>
    <td class="korrekt">&nbsp;&nbsp;&nbsp;&nbsp;Bestanden:</td>
    <td class="korrekt">{boegenRichtig}</td>
  </tr>  
  <tr>
    <td class="falsch">&nbsp;&nbsp;&nbsp;&nbsp;Nicht bestanden:</td>
    <td class="falsch">{boegenFalsch}</td>
  </tr>  
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Quote:</td>
    <td>{boegenQuote}</td>
  </tr>
  <tr>
</table>
<br/>
<form action="{scriptName}" method="get">
  <input type="hidden" name="show" value="stats" />
  <input type="hidden" name="resetstats" value="1" />
  <input type="submit" value="Zurücksetzen" />
</form>
