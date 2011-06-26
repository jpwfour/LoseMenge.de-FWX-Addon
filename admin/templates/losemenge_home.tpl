<h3>Einstellungen</h3>
unter: <a href="admin.php?p=configuration&u=addon">Konfiguration -> AddOns</a>
<ul>
<li>klamm-Account</li>
<li>klamm-Losepasswort</li>
<li>Sicherheitspuffer: Der Sicherheitspuffer gibt an wie viel Lose auf dem EF bleiben sollen um eventuelle Auszahlungen nicht zu beeintr&auml;chtigen. Diese Lose werden nicht mitgez&auml;hlt!</li>
</ul>
Zum Schlu&szlig; musst du dich noch auf <a href="http://www.losemenge.de/exportforce.html">www.losemenge.de</a> mit dem Link zu <code>%config_siteurl%/losemenge/losemenge.php</code> eintragen! 
Vielen Dank f&uuml;r deine Teilnahme!
<br />
M&ouml;chtest du einen zus&auml;tzlichen Schutz, dass die Lose auch garantiert auf den ExportForce-Account zur&uuml;cktransferiert werden, kannst du einen Cronjob einrichten, der in
m&ouml;glichst geringen Abst&auml;nden das Script mit <code>%config_siteurl%/losemenge/losemenge.php?act=3</code> auf diesem Webserver aufruft. Alternativ kann auch der Cronjob <code>%config_siteurl%/page.php?cat=cronjob&t=losemenge&pwd=CRONJOB_PASSWORT</code> genutzt werden. Sollte mal eine R&uuml;ckbuchung von Losemenge.de innerhalb von 60 Sekunden
nicht ausgel&ouml;st werden, wird diese durch den Cronjob ausgel&ouml;st.<br />
<br />