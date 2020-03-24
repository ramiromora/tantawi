<html>
<meta charset="utf-8">

<table cellspacing="0" cellpadding="5" width="100%" border="0">
<tbody>
<tr>
    <td align="right" colspan="3" bgcolor="#b45604">
    <font color="#DDDDDD"><b>Oficina Técnica para el Fortalecimiento de la Empresa Pública - OFEP</b></font>
    </td>
</tr>
<tr>
    <td height="30" colspan="3" bgcolor="#e07516">
    <font color="#FFFFFF" size="3"><b>SISTEMA DE ACTAS</b></font>
    </td>
</tr>
<tr>
</tr>
<tr>
<td width="4%">&nbsp;</td>
<td width="93%" valign="top">

	===============================================================<br>
    Atención:<br>
    Usted {{ $user->name }} fue mencionado en el acta <u><strong>"{{$act->title}}"</strong></u> de la reunión llevada a cabo el día {{obtenerFechaEnLetra($act->date)}}<br>
    Convocado por <b>{{buscanombre($act->user_id)}}</b><br>
    <?php
    $pdf = 'http://tantawi.ofep.gob.bo/'.$act->pdf; ///modificar los lincks para la puesta en produccion
    ?>
    <a href="{{ $pdf }} "> <font color="#fff" face="verdana" size="3" style="background-color: #f42e1f;">Acta en PDF</font></a>
    <br><br>Para más detalles diríjase al sistema <a href="http://tantawi.ofep.gob.bo" target="_blank">tantawi.ofep.gob.bo</a>
    Gracias.
    <br>
    <br>
    <br>
    ===============================================================<br>
</td>
<td width="3%">&nbsp;
</td>
</tr>

<tr><td colspan="3" align="center" bgcolor="#DDDDDD">
<a href="http://www.ofep.gob.bo" target="_blank">www.ofep.gob.bo</a>
</font>
</td>
</tr>
</tbody>
</table></html>
