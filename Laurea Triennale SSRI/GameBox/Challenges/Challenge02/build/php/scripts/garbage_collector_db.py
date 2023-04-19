import mysql.connector
from mysql.connector.cursor import MySQLCursorPrepared
import hashlib
import time

users_count=0
i=2

def delete_old_users(mydb):
    mycursor = mydb.cursor(prepared=True)
    prepared = "DELETE FROM users WHERE DataRegistrazione < (NOW() - INTERVAL 60 MINUTE) and DataRegistrazione is not null"
    params = ()
    mycursor.execute(prepared,params)
    mydb.commit()
    users_counts=mycursor.rowcount
    print ("Utenti del database ch"+str(i)+"challenge cancellati: "+str(users_counts))


def clear():
    mydb = mysql.connector.connect(
      host="ch"+str(i)+"_db",
      port=3306,
      user="root",
      password="87W1%^xfBuYl",
      database="ch"+str(i)+"challenge"
    )
    delete_old_users(mydb)

while True:
    try:
        clear()
    except:
        continue
    time.sleep(3600)

#clear()
