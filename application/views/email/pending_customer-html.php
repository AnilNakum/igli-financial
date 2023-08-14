<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Company Service Status :  <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
Dear  <?php echo $username; ?>,<br />
The current status of your Annual Compliance - <?php echo $ServiceTitle; ?> is as follows:<br />
<br />
<b>Status: <?php echo $progressStatus; ?> - <?php echo $Reason; ?></b>
<br />
<p>As the engagement is currently pending with you, we request you to kindly provide us with the information or documents required to complete the service at the earliest.</p>
<p>In case of any questions, feel free to contact us for updates.</p>
<p>Once again, thank you for choosing <?php echo $site_name; ?>. We value your business and are always ready to help. Have a great day!</p>
<br />
Best regards,<br />
The <?php echo $site_name; ?> Team
</td>
</tr>
</table>
</div>
</body>
</html>