<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Service Status :  <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
Dear  <?php echo $username; ?>,<br />
The current status of your <?php echo $ServiceTitle; ?> engagement is as follows:<br />
<br />
<b>Status: <?php echo $progressStatus; ?> - <?php echo $Reason; ?></b>
<br />
<p>We are working on the engagement and will try to complete the service at the earliest possible. We will also contact you in case we require any information or documents. Thank you for your patience.</p>
<p>In case of any questions, feel free to contact <?php echo $RMName.' - '.$RMNo;?>.</p>
<p>Have a great day!</p>
<br />
Best regards,<br />
<?php echo $RMName; ?><br />
<a href="https://iglifinancial.com/"><?php echo $site_name; ?></a>
</td>
</tr>
</table>
</div>
</body>
</html>