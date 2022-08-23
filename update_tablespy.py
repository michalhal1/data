import MySQLdb
import pandas as pd
host = '10.255.134.193'
user ='user'
passwd = 'password'
db = 'database'

db_connection = MySQLdb.connect(host=host, user=user, passwd=passwd, db=db)
cor = db_connection.cursor()

df = pd.read_excel(r"C:\Users\mhal04\Documents\excel_file.xlsx")
df = df.reset_index()

for index, dane in df.iterrows():
    sql = "insert into table ( col1, col2, col3, col4, col5, col6, col7, col8, col9) values ('" + (str(dane[2])).strip() + "','" + (str(dane[3])).strip() + "','" + (str(dane[4])).strip() + "','" + (str(dane[5])).strip() + "','" + (str(dane[6])).strip() + "','" + (str(dane[7])).strip()  + "','" + (str(dane[8])).strip() + "','" + (str(dane[9])).strip() +  "','" + (str(dane[10])).strip() + "'"  + ')'
   
    cor.execute(sql)
    #print(sql)
    db_connection.commit()

print("koniec")
    

