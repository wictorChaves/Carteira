@ECHO OFF

REM Export all databases into file C:\path\backup\databases.[year][month][day].sql
"C:\wamp64\bin\mysql\mysql5.7.9\bin\mysqldump.exe" --all-databases --result-file="C:\wamp64\www\Carteira\Banco\databasesHomw.sql" --user=root --password=grafite