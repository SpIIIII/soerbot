
import requests
import json
from flask import Flask
from flask import request
from flask import jsonify
from flask_sslify import SSLify
import re

app=Flask(__name__)
sslify=SSLify(app)


token=''
url='https://api.telegram.org/bot{}/'.format(token)


def write_json(data,filename='answer.json'):
    with open(filename,'w') as f:
        json.dump(data,f,indent=2,ensure_ascii=False)


def get_undate():
    URL=url+'getUpdates'
    r=requests.get(URL)
    #write_json(r.json())
    return r.json()


def sendMassage(chat_id,text='bla-bla'):
    URL=url+'sendMessage'
    answer={'chat_id':chat_id,'text':text}
    r=requests.post(URL,json=answer)
    return r.json()

@app.route('/',methods=['POST','GET']) 
def index():
    if request.method=='POST':
        r=request.get_json()
        #print (r)
        write_json(r)
        #sendMassage(r)
        chat_id=r['message']['chat']['id']
        massage=r['message']['text']
        sendMassage(chat_id,'you have send me next messege: '+massage)
        return jsonify(r)
    return '<h1> Bot welcomes you </h1>'



def main():
    r=requests.get(url+'getMe')
    write_json(r.json())
    chat_id=get_undate()['result'][-1]['message']['chat']['id']
    print(chat_id)
    sendMassage(get_undate()['result'][-1]['message']['chat']['id'],'your send me next text: '+get_undate()['result'][-1]['message']['text'])


if __name__ == '__main__':
    main()
    print("it's starts")
    #app.run()