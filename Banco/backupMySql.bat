@ECHO OFF

REM Export all databases into file C:\path\backup\databases.[year][month][day].sql
"C:\wamp64\bin\mysql\mysql5.7.14\bin\mysqldump.exe" --all-databases --result-file="C:\wamp64\www\Carteira\Banco\databases.sql" --user=root --password=grafite