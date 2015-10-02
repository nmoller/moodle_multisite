# moodle_multisite
I would like to use the same code base to get several working instances of Moodle. 

The idea is to modify Moodle's global $CFG depending on the virtual folder. To say it simply, in one server, I want to be able to handle several instances with the same code.

Ex: 
- http://moodle.dev/instance1
- http://moodle.dev/instance2
...

So I should add classes:
- class Conf_instance1 extends configurator
- class Conf_instance2 extends configurator

with the right values.
After that I modify config.php ( as shown in the tests... if you are a moodler, you must know what I'm talking about :D )

Dont forget to **call cron** for each instance with:
- wget -q -O /dev/nullhttp://moodle.dev/instance1/admin/cron.php
- wget -q -O /dev/null http://moodle.dev/instance2/admin/cron.php
