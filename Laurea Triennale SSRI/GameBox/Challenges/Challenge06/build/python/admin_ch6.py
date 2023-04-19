from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
import time

url="http://challenge06.gamebox:8086"

def access():
    chrome_options = Options()
    chrome_options.add_argument('--headless')
    chrome_options.add_experimental_option("excludeSwitches", ["disable-popup-blocking"])
    chrome_options.add_argument('--remote-debugging-port=9222')
    chrome_options.add_argument('--no-sandbox')
    #chrome_options.add_argument('--disable-gpu')
    web=webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=chrome_options)
    web.set_page_load_timeout(10)
    try:
        web.get(url+"/index.php")
        time.sleep(2)
        username="admin"
        username_field=web.find_element(By.NAME, "username")
        username_field.send_keys(username)
        password="X#K*Ych@+u$QKa9Z"
        password_field=web.find_element(By.NAME, "password")
        password_field.send_keys(password)
        submit=web.find_element(By.ID, "btn")
        submit.click()
        print ("[admin_ch6] Login effettuato con successo!")
        while True:
            web.get(url+"/admin.php")
            time.sleep(10)
            print("[admin_ch6] Image visualized.")
            if web.find_elements(By.ID,"end"):
                break
            else:
                continue
        print ("[admin_ch6] Logout in corso...")
        web.get(url+"/image.php")
        time.sleep(2)
        logout=web.find_element(By.ID, "lgt")
        print ("[admin_ch6] Logout effettuato!")
    except:
        pass
    finally:
        web.quit()

time.sleep(60)
while True:
    access()
    time.sleep(60)
