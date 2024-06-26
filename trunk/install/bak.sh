#!/bin/bash
DATE=`date +%Y%m%d`
OLD=`date -d"1 day ago" +"%Y%m%d"`
OLD3=`date -d"3 day ago" +"%Y%m%d"`
config="/home/judge/etc/judge.conf"
SERVER=`cat $config|grep 'OJ_HOST_NAME' |awk -F= '{print $2}'`
USER=`cat $config|grep 'OJ_USER_NAME' |awk -F= '{print $2}'`
PASSWORD=`cat $config|grep 'OJ_PASSWORD' |awk -F= '{print $2}'`
DATABASE=`cat $config|grep 'OJ_DB_NAME' |awk -F= '{print $2}'`
PORT=`cat $config|grep 'OJ_PORT_NUMBER' |awk -F= '{print $2}'`

echo "delete from source_code where solution_id in (select solution_id from solution where problem_id=0 and result>4);"|mysql -h $SERVER -P $PORT -u$USER -p$PASSWORD $DATABASE 
echo "delete from source_code_user where solution_id in (select solution_id from solution where problem_id=0 and result>4);"|mysql -h $SERVER -P $PORT -u$USER -p$PASSWORD $DATABASE 
echo "delete from runtimeinfo where solution_id in (select solution_id from solution where problem_id=0 and result>4);"|mysql -h $SERVER -P $PORT -u$USER -p$PASSWORD $DATABASE 
echo "delete from compileinfo where solution_id in (select solution_id from solution where problem_id=0 and result>4);"|mysql -h $SERVER -P $PORT -u$USER -p$PASSWORD $DATABASE 

echo "delete from solution where problem_id=0 and result>4 "|mysql -h $SERVER -P $PORT -u$USER -p$PASSWORD $DATABASE 

echo "optimize table compileinfo,contest,contest_problem,loginlog,news,privilege,problem,solution,source_code,users,topic,reply,online,sim,mail;"|mysql -h $SERVER -P $PORT -u$USER -p$PASSWORD $DATABASE 
mysqldump -h $SERVER -P $PORT -R $DATABASE -u$USER -p$PASSWORD | bzip2 >/var/backups/db_${DATE}.sql.bz2
if tar cjf /var/backups/hustoj_${DATE}.tar.bz2 /home/judge/data /home/judge/src /home/judge/etc /var/backups/db_${DATE}.sql.bz2 --exclude=/home/judge/src/install/*.bz2 ; then
	rm /var/backups/hustoj_${OLD3}.tar.bz2  2> /dev/null
	rm /var/backups/db_${OLD}.sql.bz2  2> /dev/null
fi
