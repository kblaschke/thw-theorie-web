<div class="rubrik"><span>&nbsp;</span></div>
<h1>Zufallsfragen &uuml;ben</h1>

<p><b>Frage Nr. {aktuelleFrage} von {fragenCnt}</b></p>
<p><b>Lernabschnitt {abschnittNr}:</b> {abschnitt}</p>

<form name="neu" action="{scriptName}?show=fragen" method="post">
<input type="hidden" name="action" value="neu" />
</form>

<form id="zufallsfrageFormular" action="{scriptName}?show=fragen" method="post">

<input type="hidden" name="frage_id[]" value="{frageID}" />

<table class="fragebkg" cellspacing="1" cellpadding="4">
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
    <td>{Antwort1}</td>
    <td align="center">A</td>
    <td align="center"><input id="antwortA" type="checkbox" name="antwort[{frageID}][1]" value="1" /><div class="print-checkbox"></div></td>
  </tr>
  <tr>
    <td>{Antwort2}</td>
    <td align="center">B</td>
    <td align="center"><input id="antwortB" type="checkbox" name="antwort[{frageID}][2]" value="1" /><div class="print-checkbox"></div></td>
  </tr>
{|ThreeRows}{|ThreeRows*Row}        
  <tr>
    <td>{Antwort3}</td>
    <td align="center">C</td>
    <td align="center"><input id="antwortC" type="checkbox" name="antwort[{frageID}][3]" value="1" /><div class="print-checkbox"></div></td>
  </tr>
{|ThreeRows*Row}{|ThreeRows}
</table>

<div>&nbsp;</div>


<table cellspacing="0" cellpadding="4" border="0" width="100%">
  <tr>
    <td align="left"><input type="button" value="Neuer Fragenkatalog" onClick="neu.submit()" /></td>
    <td align="right"><input type="submit" id="nextButton" value="Weiter" /></td>
  </tr>
</table>

</form>

<script type="application/javascript">
    function toggleCheckbox(id)
    {
        $("#" + id).prop("checked", !$('#' + id).prop("checked"));
    }

    $(document).keypress(function(event) {
        if (event.keyCode == 13 || event.charCode == 32)
        {
            $('#zufallsfrageFormular').submit();
            event.stopPropagation();
            return false;
        }

        if (event.charCode == 49)
        {
            toggleCheckbox('antwortA');
            event.stopPropagation();
            return false;
        }
        if (event.charCode == 50)
        {
            toggleCheckbox('antwortB');
            event.stopPropagation();
            return false;
        }
        if (event.charCode == 51)
        {
            toggleCheckbox('antwortC');
            event.stopPropagation();
            return false;
        }
    });

</script>