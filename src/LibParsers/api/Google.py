import requests
import json


def get(name):
    in_book=name.replace(" ", "+")
    URL= "https://www.googleapis.com/books/v1/volumes?q="
    url = "https://www.googleapis.com/books/v1/volumes?q="+in_book
    #print(url)
    
    r=requests.get(url)
    
    return{"author":r.json()['items'][1]['volumeInfo']["authors"][0],}




if __name__ == "__main__":
    print(get("маленький принц"))