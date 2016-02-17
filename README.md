# clubhouse
a membership sign in system for clubs

Clubhouse is a free opensource membership and sign in system for clubs!
Currently only fully supported on firefox

FEATURES:
Can be multitenanted (each organisation has a virtual space on a shared database)
Sign up members and record membership information
Accept sign in and sign out of members
Members can sign up during sign in (then staff add detail later)
Multiple locations / venues can be used each with its own timezone.

REQUIREMENTS:
php
apache
mysql
twitter bootstrap (required but included)
cron or some task sheduler to auto logout

INSTRUCTIONS:
* install php, apache, mysql
* grab a copy of clubhouse
* Change the database details in configPDO.php
* create a database with credentials that match those in configPDO.php
* change the hard-coded admin user details in do_authenticate.php
* configure apache as desired 
* access clubhouse at http://localhost/clubhouse
* create a new staff user using the hard coded admin user

DESIGN PRINCIPLES
* Easy to use
* Responsive to different screensizes
* Fast to use (fewer clicks more action)
  * ie. add and remove items right where you edit them,
  * heavy use of autocomplete, nowhere to view fixed list or edit elements
  * Fairly Normalised database common elements added as needed (eg. suburb, ethinicity etc)
    * However each organisation is totally separate from others (no crossover).
  
NO WARANTY OR LIABILITY
  * Free and open source offered without warranty noor accepting any liability for use!
