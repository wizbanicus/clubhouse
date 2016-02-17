# clubhouse
a membership sign in system for clubs

Clubhouse is a free opensource membership and sign in system for clubs!
Currently only fully supported on firefox

FEATURES:
* Can be multitenanted (each organisation has a virtual space on a shared database)
* Sign up members and record membership information
* Accept sign in and sign out of members
* Members can sign up during sign in (then staff add detail later)
* Multiple locations / venues can be used each with its own timezone.

TEST / EXPLORE
* Test clubhouse at http://test.clubhouse.nz
  * username: admin
  * password: tppanoway!
* add new staff user and give them an organisation
  * logout
  * login as new staff
    * start taking signins at venue (add as you go).
    * or edit blank member to add members

REQUIREMENTS:
* php
* apache
* mysql
* bootstrap date range picker (required but included)
* twitter bootstrap (required but included)
* awesomplete (required but included)
* cron or some task sheduler to auto logout

INSTRUCTIONS:
* install php, apache, mysql
* grab a copy of clubhouse
* Change the database details in configPDO.php
* create a database with credentials that match those in configPDO.php
* change the hard-coded admin user details in do_authenticate.php
* configure apache as desired 
* access clubhouse at http://localhost/clubhouse
* create a new staff user using the hard coded admin user
* create a cron (or scheduled task) to run server_auto_signout.php regularly 
  * say every hour at say 27 and 57 minutes after the hour.
* finally add a nifty background image to css/images
  * then reference that image in css/clubhouse.css

DESIGN PRINCIPLES
* Easy to use
* Responsive to different screensizes
* Fast to use (fewer clicks more action)
  * ie. add and remove items right where you edit them,
  * heavy use of autocomplete, nowhere to view fixed list or edit elements
  * Fairly Normalised database common elements added as needed (eg. suburb, ethinicity etc)
    * However each organisation is totally separate from others (no crossover).
  
FUTURE IMPROVEMEMTS
* better js support for chrome and safari
* Internationalised date time formats eg. dd/mm/yyy mm/dd/yyy
* More reports
* Implement better password security (hash + salt)
* Implement https
* fix php errors (undefined vars)
* make it more robust (needs testing)

HELP!
* implement some cool changes and push to github!
* get in touch jimihendrixhewasgood@gmail.com
  * to discuss how you could help work on the project
    * need help with html,css,php,javascript
    * all skill levels welcome!
* test and email me with a bug or feature you think it should have
  
NO WARANTY OR LIABILITY
  * Free and open source offered without warranty nor accepting any liability for use!
  * Please note licences for Twitter Bootstrap and Date Range Picker.
