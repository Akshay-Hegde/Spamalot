Spamalot
========

Cut down on spam registrations for PyroCMS via the great API from stopforumspam.com

This module comes with a range of options and integrates seamlessly into the user registration process to oversee and check the email and ip of the user. It then checks it against one of the largest databases of spam emails and ip addresses in the world to ensure that the user has not been blacklisted. If they are classed as blacklisted their account will then be deactivated or deleted according your your preferences.

### Installation

1. Create a new "spamalot" folder in addons/default/modules or addons/shared_addons/modules
2. Drop in the files
3. In your PyroCMS Dashboard go to modules and install Spamalot
4. In Settings you can choose a range of options to customise the tolerances

### TODO

1. Existing user checks
2. One-click ban for existing users that are flagged as spam
3. Email notifications for the admin when a user is disabled/deleted and when a user has been reported but doesn't meet tolerances for removal
