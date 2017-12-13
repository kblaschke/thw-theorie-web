<div class="rubrik"><span>&nbsp;</span></div>
<h1>Fragen üben</h1>
<h2>Fragen in zufälliger Reihenfolge üben</h2>
<p>In diesem Bereich können Sie alle oder bestimmte Fragen des Curriculums "Grundausbildung der Helfer des THW" in einer zufälligen Reihenfolge üben. Dabei werden, sofern Sie nicht einen neuen Fragenkatalog generieren, keine Fragen doppelt angezeigt oder ausgelassen. Wenn Sie alle bzw. die gewünschte Anzahl Fragen durchgearbeitet haben, wird eine Gesamtstatistik zur aktuellen Fragen-Serie bzw. wenn Sie in dieser Sitzung bereits mehrere Durchgänge absolviert haben, auch eine Gesamtstatistik angezeigt.</p>
<p>Die Fragen werden in zufälliger Reihenfolge einzeln angezeigt. Ein erneutes Beantworten der Fragen in der aktuellen Serie ist nicht möglich, da die Lösung sofort angezeigt wird.</p>
<p>Bei den meisten Fragen stehen 3 Antworten zur Auswahl (bei wenigen nur 2). Es ist mindestens eine Antwort anzukreuzen, bei einigen Fragen müssen auch mehrere Antworten angekreuzt werden. Die Aufgabe gilt als richtig gelöst, wenn <b>alle</b> zutreffenden Antworten angekreuzt sind.</p>
<p>Hinweis: Sind in den ausgewählten Lernabschnitten <i>weniger</i> Fragen als unter "Anzahl Fragen" ausgewählt wurde vorhanden, wird die Fragenzahl entsprechend reduziert. "Alle Fragen" und die Auswahl nur eines Lernabschnittes beschränkt die Anzahl der Fragen also auf die in diesem Themenbereich vorhandenen Fragen.</p>
<script type="text/javascript">

function checkAbschnitt(check) {
    for (I=1; I<={abschnitteAnz}; I++) {
        eval("document.forms['zufallform'].elements['chkAbschnitt" + I + "']").checked = check;
    }
}

function invertSelection() {
    for (I=1; I<={abschnitteAnz}; I++) {
        eval("document.forms['zufallform'].elements['chkAbschnitt" + I + "']").checked = !(eval("document.forms['zufallform'].elements['chkAbschnitt" + I + "']").checked);
    }
}

</script>
<form name="zufallform" action="index.php?show=fragen" method="post">
<input type="hidden" name="action" value="start" />
<table class="fragebkg" cellspacing="1" cellpadding="4" border="0" width="100%">
  <tr>
    <td valign="top" nowrap>
      Lernabschnitte:<br /><br />
      <a href="javascript:checkAbschnitt(true);" title="Alle Themenabschnitte auswählen">Alle wählen</a><br />
      <a href="javascript:checkAbschnitt(false);" title="Keinen Themenabschnitt auswählen">Keine wählen</a><br /><br />
      <a href="javascript:invertSelection();" title="Aktuelle Auswahl umkehren">Invertieren</a><br />
    </td>
    <td>
      <table cellspacing="0" cellpadding="2" border="0" width="100%">
      {|Abschnitte}
      {|Abschnitte*Row}
        <tr>
          <td valign="top">
            <input id="chkAbschnitt{abschnittNr}" type="checkbox" name="abschnitt[{abschnittNr}]" value="1" checked="checked" />
          </td>
          <td>
            <label for="chkAbschnitt{abschnittNr}">{abschnittDesc}</label>
          </td>
        </tr>
      {|Abschnitte*Row}
      {|Abschnitte}
      </table>
    </td>
  </tr>
  <tr>
    <td valign="middle" nowrap>Max. Anzahl Fragen:</td>
    <td width="100%">
      <select size="1" name="fragen">
        <option value="0">Alle Fragen ({maxFragen} max.)</option>
        <option value="150">150 Fragen</option>
        <option value="125">125 Fragen</option>
        <option value="100">100 Fragen</option>
        <option value="75">75 Fragen</option>
        <option value="50">50 Fragen</option>
        <option value="20">25 Fragen</option>
        <option value="10">10 Fragen</option>
        <option value="5">5 Fragen</option>
      </select>
    </td>
  </tr>
</table>

<table cellspacing="4" cellpadding="2" border="0" width="100%">
  <tr>
    <td align="center"><input type="submit" value="OK, auf geht's!" /></td>
  </tr>
</table>
</form>