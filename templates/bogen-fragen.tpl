<h1>Prüfungsbogen üben</h1>
<p><strong>Beantworten Sie alle 40 Fragen innerhalb der Prüfungszeit.</strong></p>
<p class="no-print">Sie haben mit diesem Fragebogen um {zeit} Uhr begonnen.</p>

<form name="neu" action="{scriptName}" method="post">
<input type="hidden" name="show" value="bogen" />
<input type="hidden" name="create" value="1" />
</form>

<form action="{scriptName}" method="post">
<input type="hidden" name="show" value="bogen" />

{|Bogen}
{|Bogen*Frage}
<table class="fragebkg" cellspacing="1" cellpadding="4">
  <colgroup>
    <col width="7%">
    <col width="30%">
    <col width="55%">
    <col width="4%">
    <col width="4%">
  </colgroup>
  <tr>
    <td rowspan="{rowCnt}" valign="top"><div class="fragenr only-print">{frageIndex}</div><span class="no-print" style="font-weight:bold">{abschnittNr}.{frageNr}</span></td>
    <td rowspan="{rowCnt}" valign="top">{frageText}</td>
    <td>{Antwort1}</td>
    <td align="center">A</td>
    <td align="center"><input type="checkbox" name="antwort[{frageID}][1]" value="1" /><div class="print-checkbox"></div></td>
  </tr>
  <tr>
    <td>{Antwort2}</td>
    <td align="center">B</td>
    <td align="center"><input type="checkbox" name="antwort[{frageID}][2]" value="1" /><div class="print-checkbox"></div></td>
  </tr>
{|ThreeRows}{|ThreeRows*Row}        
  <tr>
    <td>{Antwort3}</td>
    <td align="center">C</td>
    <td align="center"><input type="checkbox" name="antwort[{frageID}][3]" value="1" /><div class="print-checkbox"></div></td>
  </tr>
{|ThreeRows*Row}{|ThreeRows}
</table>
{|Bogen*Frage}
{|Bogen*Topline}
<ul class="seitenanfang">
<li class="left"> </li>
<li class="right"><a href="#top" title="Nach Oben" alt="Nach Oben">
<img src="img/oben.gif" alt="Oben" border="0" title="Oben"/></a></li>
</ul>
{|Bogen*Topline}
{|Bogen}

<table cellspacing="0" cellpadding="4" border="0" width="100%">
  <tr>
    <td align="left"><input type="button" value="Neuer Fragenbogen" onClick="neu.submit()"></td>
    <td align="right"><input type="submit" value="Fertig"></td>
  </tr>
</table>
</form>
<div class="only-print">Dieser THW-Prüfungsbogen wurde auf http://www.thw-theorie.de/ erstellt.<br/>
Stand des Fragenkatalogs: {catalogYear}</div>