wunderlist-evernote-migration
=============================

This project will convert Wunderlist's json backup file to Evernote .enex file format for importing, every list in wunderlist will generate one .enex file for manual importing to evernote.

**Requirements:**
-----------------

> PHP >= 5.4
>
> Composer


 **Install and run instruction:**
---------------------------------

> 1. Run "composer install" to pull all dependencies.
> 2. Save your Wunderlist backup file (Looks like: wunderlist-20140822-22_41_10.json) as wunderlist.json, put it in "io/input/" directory.
> 3. Run conver.php in command line or web browser.
> 4. After the process, the generated .enex files can be located in directory: "io/input".
