import requests
from bs4 import BeautifulSoup

def get_description(html):
    temp=BeautifulSoup(html,'lxml').find('div',itemprop="description").find_all('p')
    return ''.join(map(BeautifulSoup.getText,temp))

def get_name(html):
    return BeautifulSoup(html,'lxml').find('h1',itemprop="name").getText()

def get_img_ref(html):
    return BeautifulSoup(html,'lxml').find('img',itemprop="image").get('src')

def get_review(html):
    return BeautifulSoup(html,'lxml').find('div',class_="recense_content").getText()


def get(name="маленький+принц"):
    inter_text=name.replace(" ", "+")
    ref_to_book=get_books(get_html(f"https://www.litres.ru/pages/rmd_search/?q={inter_text}"))
    html_to_book=get_html(ref_to_book)
    descripiton=get_description(html_to_book)
    img_ref=get_img_ref(html_to_book)
    review=get_review (html_to_book)
    
    return {'name':name,'reference':ref_to_book,'img_ref':img_ref,'description':descripiton.strip(),
    'review':review}

def get_html(url):
    r=requests.get(url)
    return r.text

def get_books(html):
    soup= BeautifulSoup(html, 'lxml')
    ref_to_book= soup.find('div',class_="books_box").find('div',class_="art-item__name").find('a').get('href')
    
    if ref_to_book:
        return "https://www.litres.ru"+ref_to_book
    else:
        return "Такой книги не найдено"

#print(get("алиса в стране чудес"))
if __name__ =="__main__":
    book_to_find="алиса в стране чудес"
    get(book_to_find)
    #ref_to_book=get(book_to_find)
    print(get(book_to_find))
