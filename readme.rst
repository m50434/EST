###################
EST - Online
###################

| DEFAULT LOGIN: admin password
| PLEASE CHANGE THIS PASSWORD IMMEDIATELY !!!
| 
| 
| TEST ACCOUNTS as parents:
| Benutzername;Password
| Harrell-123;7136
| Cruz-122;7254
| Harrell-444;8607
| Mckinney-324;5561
| Camacho-578;6375
| Coleman-555;4506
| Cline-642;7982
| Ayala-532;4412
| Gregory-809;9168
| 
| 


**************************
Changelog and New Features
**************************

| 1.2: Bei den Lehrern können die Terminfelder beim Importieren nun auch leer sein.
| 1.3: Es können nun die tatsächlich stattfindenden Elterngespräche sowie die Raumdaten importiert werden. Außerdem können Eltern nun ihre Gespärchstermine einsehen und diese drucken bzw. als PDF herunterladen. Für Version 1.3 muss die neue Datenbank benutzt werden, da sich hier ebenfalls Änderungen ergeben haben.
| 1.31: Fixes in db. PDF-Ausgabe der Elternergebnisse optimiert.
| 1.32: Es kann die Elternwahl beendet werden ODER Elternergebnisse angezeigt werden.
| 1.33: Some Fixes.
| 1.34: Individueller Info-Text bei den Elternergebnissen darstellbar, neue Datenbankstruktur
| 1.35: Eleternergebnisse-Ansicht für kleine Bildschirme optimiert
| 1.36: Fehlenden Ordner Files hinzugefügt



*******************
Server Requirements
*******************
EST-Online is based on CodeIgniter and SQLite.

| PHP:
| PHP version 5.6 or newer is recommended.

| It should work on 5.3.7 as well, but we strongly advise you NOT to run
| such old versions of PHP, because of potential security and performance
| issues, as well as missing features.
| 
| SQLite:
| You need to install/activate the extension "pdo_sqlite" in your PHP-Version!!!
| Otherwise you cannot access the database!!!


************
Installation
************

| 1. copy files to your Host
| 2. Rename mainfolder to "est"
| 3. go to \application\config and edit the file "config.php":
|    change in line 26 the variable $config['base_url'] to 'https://yoururl.com/est/';
|  

*******************************
Update (ab 1.34)
*******************************

| 1. Logout from EST
| 2. Copy EST.db in \assets\db
| 3. Paste EST.db to \assests\db
|  

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.


