__READ FIRST: This only works when you want to play only BMS files!__
If you want to play OJN files, you must not use this, or have another
O2mania installation.



O2mania Launcher
================

This is a launcher for O2mania. It scans the BMS file and generates the
"MusicCache.xml" file before launching O2mania itself.

This way you don't need to refresh the music list in O2mania every time.
There are more features too, like:

* Multiple BMS directories. (Useful when you have song organized in many places).
* Detects and skips `___bmse_temp.bms` automatically. (Useful when testing a song).
* Displays the BMS file in case the title is not available. (In o2mania you will see the blank title).
* Loads properly the #ARTISTS field.


Usage
-----

### Install PHP

You need to have PHP installed first.
[Download the zip file from windows.php.net](http://windows.php.net/download/)
(I use VC9 x86 Non Thread Safe), and extract it to `C:\PHP`.

### Create `Launcher_Paths.txt`

Then, in the launcher's folder, create a file called `Launcher_Paths.txt` and
put a list of directories that have BMS files, one per each line.
You can use * for wildcards. For example,

    C:\My BMS\*\wav\
    C:\BMS from o2mania.com\*\

The launcher will look for `C:\My BMS\*\wav\*.bm[se]` and
`C:\BMS from o2mania\*\*.bm[se]`. You can have multiple wildcards too,
for example, when you have all BMS categoried in subdirectories, you can use:

    C:\BMS\*\*\
    
and the launcher will look for `C:\BMS\*\*\*.bm[se]`.

### Put O2mania Inside `Apps`

Then, in the launcher's folder, create a folder called `App` and put O2mania
inside there. Your folder should look something like this

* Launcher.bat
* Launcher.php
* Launcher_Paths.txt
* App
    * o2mania.exe
    * O2ManiaDriverSelect.exe
    * ....
    * ....
    * ....

### Launch O2mania With This Launcher

To launch O2mania, double click "Launcher.bat" instead. You will see a command
prompt window, showing the list of all songs in 



