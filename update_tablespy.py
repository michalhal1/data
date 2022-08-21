import MySQLdb
import pandas as pd
host = '10.255.134.193'
user ='boiws'
passwd = 'OtherOddsUpdateRank73'
db = 'bids_test'

db_connection = MySQLdb.connect(host=host, user=user, passwd=passwd, db=db)
cor = db_connection.cursor()




df = pd.read_excel(r"C:\Users\mhal04\Documents\BazaPB.xlsx")

df1 = df.reset_index()

df = df.truncate(before = 121379, after = 144985)

df = df.reset_index()

df = df.loc[:, "index":"Rola"]

#print(df)
#print(df1)


for index, dane in df.iterrows():
    sql = "insert into client_CRM_data ( client_name, client_NIP, client_PKD_nr, client_PKD_name, client_city, client_postal_code, client_street, client_house_number, client_role) values ('" + (str(dane[2])).strip() + "','" + (str(dane[3])).strip() + "','" + (str(dane[4])).strip() + "','" + (str(dane[5])).strip() + "','" + (str(dane[6])).strip() + "','" + (str(dane[7])).strip()  + "','" + (str(dane[8])).strip() + "','" + (str(dane[9])).strip() +  "','" + (str(dane[10])).strip() + "'"  + ')'
   
    cor.execute(sql)
    #print(sql)
    db_connection.commit()

print("koniec")
    

