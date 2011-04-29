@echo off

set PHP=C:\php\php.exe
set SCRIPT=%~dp0Launcher.php
set SEARCHLIST=%~dp0Launcher_Paths.txt
set MUSICCACHE=%~dp0App\MusicCache.xml
set O2MANIA_PATH=%~dp0App
set O2MANIA_NAME=o2mania.exe

"%PHP%" "%SCRIPT%"
cd "%O2MANIA_PATH%"
start "" "%O2MANIA_NAME%"