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

| 1.2: Bei den Lehrern k�nnen die Terminfelder beim Importieren nun auch leer sein.
| 

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
| 
************
Installation
************

| 1. copy files to your Host
| 2. Rename mainfolder to "est"
| 3. go to \application\config and edit the file "config.php":
|    change in line 26 the variable $config['base_url'] to 'https://yoururl.com/est/';
|  

************
Update
************

| 1. Logout from EST
| 2. Copy EST.db in \assets\db
| 3. Paste EST.db to \assests\db
|  

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.


