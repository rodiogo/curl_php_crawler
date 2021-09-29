from selenium import webdriver
import pandas as pd
from datetime import date

driver = webdriver.Chrome('C:\Program Files (x86)\chromedriver.exe')

driver.get('https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/index.en.html')

currency_code = driver.find_elements_by_xpath('/html/body/div[2]/main/div[4]/div[2]/div/div/table/tbody/tr/td[1]/a')
rate = driver.find_elements_by_xpath('//*[@id="main-wrapper"]/main/div[4]/div[2]/div/div/table/tbody/tr/td[3]/a/span')


usd_currency_rates = []

for i in range(len(rate))[:1]:
    new_Data={'Currency Code': currency_code[i].text,
              'Rate': rate[i].text}
    usd_currency_rates.append(new_Data)

df_data=pd.DataFrame(usd_currency_rates)
df_data.to_excel('usd_currency_rates_{date}.csv.xlsx', index=False)

driver.quit()
