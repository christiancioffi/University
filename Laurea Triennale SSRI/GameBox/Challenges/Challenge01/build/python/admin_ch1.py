from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
import time

url="https://challenge01.gamebox:8081"

def access():
    chrome_options = Options()
    chrome_options.add_argument('--headless')
    chrome_options.add_experimental_option("excludeSwitches", ["disable-popup-blocking"])
    #chrome_options.add_argument('ignore-certificate-errors')
    chrome_options.add_argument('--ignore-certificate-errors')
    #chrome_options.add_argument('--disable-dev-shm-usage')
    #chrome_options.add_argument("--disable-setuid-sandbox")
    chrome_options.add_argument('--remote-debugging-port=9222')
    chrome_options.add_argument('--no-sandbox')
    #chrome_options.add_experimental_option("prefs", {"profile.managed_default_content_settings.images": 2})
    #chrome_options.add_argument("start-maximized")
    web=webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=chrome_options)
    #web=webdriver.Remote("http://selenium_server:4444/wd/hub", options=chrome_options)
    web.set_page_load_timeout(10)
    try:
        web.get(url+"/index.php")
        time.sleep(2)
        print ("[admin_ch1] Login in corso...")
        username="admin"
        username_field=web.find_element(By.NAME, "username")
        username_field.send_keys(username)
        password="Yg47LWqvW2@2gNM!"
        password_field=web.find_element(By.NAME, "password")
        password_field.send_keys(password)
        submit=web.find_element(By.ID, "btn")
        submit.click()
        print ("[admin_ch1] Login effettuato!")
        while True:
            web.get(url+"/admin.php")
            time.sleep(2)
            if web.find_elements(By.CLASS_NAME, "url"):
                link=web.find_element(By.CLASS_NAME, "url")
                link_url=link.get_attribute("href")
                web.get(link_url)
                print ("[admin_ch1] Cliccato su un link! Link cliccato: "+link_url)
                time.sleep(10)
            else:
                break
        print ("[admin_ch1] Logout in corso...")
        web.get(url+"/profile.php")
        time.sleep(2)
        logout=web.find_element(By.ID, "lgt")
        logout.click()
        print ("[admin_ch1] Logout effettuato!")
    except:
        pass
    finally:
        web.quit()


#time.sleep(60)
while True:
    access()
    time.sleep(60)
