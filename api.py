import requests
import json
import pprint
import datetime as dt
from datetime import datetime
import pandas as pd

url_base = 'https://www.biznes-polska.pl/'

# url = url_base + 'api/1.0/authenticate'
# payload = {'login': 'UPC1', 'password': 'DSPWroclaw118!', 'device_type': 'ThinkPad', 'device_id': 'NPF214A7BF'}
# response = requests.post(url, data=json.dumps(payload)) 
# print(response.json())

token = 'bd0a5eb0d04bc01d77d809da246d7917a73886ab'


#url = url_base + 'api/1.0/get_profiles'

# payload = {'token': token}
# response = requests.post(url, data=json.dumps(payload)) 
# #pprint.pprint(response.json())

# profile = response.json()
# profile = profile['data']      
# profile = (list(filter(lambda x:x["name"]=="UPC, FOM, TON, gastronomia, pralnictwo - konto główne",profile)))
#print(profile[0]['id'])
#6842692

url = url_base + 'api/1.0/get_documents'
yesterday_date = (datetime.now()) - dt.timedelta(days=1)
yesterday_date_ts = (int(yesterday_date.timestamp()))

payload = {'token' : token, 'profile_id' : 6842692, 'timestamp': yesterday_date_ts }
response = requests.post(url, data=json.dumps(payload)) 
offers = (response.json())
offers = (offers["data"]["offers"])
offers_id_list = [] 
for i in offers:
    offers_id_list.append((i["id"]))

#dołączenie added on 
#print(offers_id_list)

url = url_base + 'api/1.0/get_offers_details'

payload = {'token' : token, 'ids' : offers_id_list}
response = requests.post(url, data=json.dumps(payload)) 
response = response.json()["data"]
offers_details = []

for i in response:
    id = i["id"]
   
    organiser = i["organiser"]
    category = i["category_fullname"]
    url = i["url"]
    try:
        nip = i["vatin"]
    except: 
        pass
    offers_details.append([id, organiser, category, url, nip])


df = pd.DataFrame(offers_details, columns = ["id", "organiser", "category_fullname", "url", "NIP"])

print(df)