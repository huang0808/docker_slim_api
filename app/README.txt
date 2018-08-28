Usage:
1)
start: docker-compose up -d

stop: docker-compose down

2)
Input below address to browser:
http://localhost:8080/api

User API;

http://localhost:8080/api/user

NOTICE: If there is db related error. Do step 3) below and then do 2) again

3)

After all docker instances stated

Login into mysql instance and run:

mysql -uroot (login to mysql)
create database oms;
use oms;
source /oms.sql;




