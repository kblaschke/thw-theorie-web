<div class="rubrik"><span>&nbsp;</span></div>
<h1>Zufallsfragen üben</h1>

{|Kopf}{|Kopf*Content}
<p><b>Frage Nr. {aktuelleFrage} von {fragenCnt}</b></p>
<p><b>Lernabschnitt {abschnittNr}:</b> {abschnitt}</p>
{|Kopf*Content}{|Kopf}

<form name="neu" action="{scriptName}?show=fragen" method="post">
<input type="hidden" name="action" value="neu" />
</form>

<form id="aufloesungFormular" action="{scriptName}?show=fragen" method="post">

{|Status}
{|Status*Richtig}<p><font class="korrekt">Sie haben diese Frage <b>richtig</b> beantwortet!</font></p>{|Status*Richtig}
{|Status*Falsch}<p><font class="falsch">Sie haben diese Frage <b>falsch</b> beantwortet!</font></p>{|Status*Falsch}
{|Status}

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
<div>&nbsp;</div>

<table cellspacing="0" cellpadding="4" border="0" width="100%">
  <tr>
    <td align="left"><input type="button" value="Neuer Fragenkatalog" onClick="neu.submit()" /></td>
    <td align="right"><input type="submit" value="{submitText}" /></td>
  </tr>
</table>

</form>

<div class="rubrik"><span>Fehlerquote</span></div>
<table cellspacing="0" cellpadding="4" border="0">
  <tr><td>Fragen bisher:</td><td><b>{aktuelleFrage}</b></td></tr>
  <tr><td>Davon <b>richtig</b> beantwortet:</td><td><b>{fragenRichtig}</b></td></tr>
  <tr><td>Davon <b>falsch</b> beantwortet:</td><td><b>{fragenFalsch}</b></td></tr>
  <tr><td>Fehlerquote (20% für Bestehen max.):</td><td><b>{fragenQuote}</b></td></tr>
</table>

<script type="application/javascript">
    $(document).keypress(function(event) {
        if (event.keyCode == 13 || event.charCode == 32)
        {
            $('#aufloesungFormular').submit();
            event.stopPropagation();
            return false;
        }
    });
</script>