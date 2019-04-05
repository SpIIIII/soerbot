import requests
from bs4 import BeautifulSoup

def get_description(html):
    return BeautifulSoup(html,'lxml').find('p',itemprop="description").getText()

def get_img_ref(html):
    return BeautifulSoup(html,'lxml').find('img',itemprop="image").get('src')

def search(text="маленький+принц"):
    inter_text=text.replace(" ", "+")
    ref_to_book=get_books(get_html(f"https://readrate.com/rus/search?q={inter_text}&scope=books"))
    descripiton=get_description(get_html(ref_to_book))
    img_ref=get_img_ref(get_html(ref_to_book))
    return {'name':text,'description':descripiton.strip(),'img_ref':img_ref,'reference':ref_to_book}

def get_html(url):
    r=requests.get(url)
    return r.text

def get_books(html):
    soup= BeautifulSoup(html, 'lxml')
    ref_to_book= soup.find('div',class_="search-results").find('div',class_="title").find('a').get('href')
    if ref_to_book:
        return "https://readrate.com"+ref_to_book
    else:
        return "Такой книги не найдено"

print(search("алиса в стране чудес"))
if __name__ =="__main__":
    book_to_find="алиса в стране чудес"
    ref_to_book=search(book_to_find)
    print(search(book_to_find))
