import requests
from bs4 import BeautifulSoup


def main(text="маленький+принц"):
    inter_text=text.replace(" ", "+")
    return get_books(get_html(f"https://readrate.com/rus/search?q={inter_text}&scope=books"))

def get_html(url):
    r=requests.get(url)
    return r.text

def get_books(html):
    soup= BeautifulSoup(html, 'lxml')
    not_link= soup.find('div',class_="search-results").find_all('div',class_="title")
    links=[]
    for i in not_link:
        a=i.find('a').get('href')
        links.append(a)
    if links :
        return "https://readrate.com"+links[0]
    else:
        return "Такой книги не найдено"


if __name__ =="__main__":

    print(main("алиса в стране чудес"))