wunderlist-evernote-migration
=============================

This project will convert Wunderlist's json backup file to Evernote .enex file format for importing, every list in wunderlist will generate one .enex file for manual importing from evernote.

-----------------------

> **Requirements:**
> 
> PHP >= 5.4
> Composer

-----------------------

> **Instruction:**
> 
> 1. Run "composer install" to resolve dependencies.
> 2. Save your Wunderlist backup file (Looks like: wunderlist-20140822-22_41_10.json) as wunderlist.json, put it in "io/input/" directory under this project's root.
> 3. Run conver.php in command line or web browser.
> 4. After that, the generated .enex file can be located in directory: "io/input".
