from selenium import webdriver
import os
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
import time
tiempo_modulos=4
tiempo_carga=10
tiempo_espera=2.5
#driver Firefox
driver=webdriver.Firefox()

#Open URL
driver.get('https://192.168.9.78/admin/capital-humano')

#Maximize Window
driver.maximize_window()
time.sleep(5)

#Login
usr=driver.find_element(By.XPATH,"//INPUT[@id='email']").send_keys("cesar.escobar@silent4business.com")
time.sleep(tiempo_modulos)
pw=driver.find_element(By.XPATH,"//INPUT[@id='password']").send_keys("6&b5lzoX!E")
time.sleep(tiempo_modulos)
btn=driver.find_element(By.XPATH,"//button[@type='submit'][contains(.,'Enviar')]")
btn.click()

#Entrar a modulos

modulo=driver.find_element(By.XPATH,"//A[@href='https://192.168.9.78/admin/recursos-humanos/evaluacion-360/competencias']")
modulo.click()
time.sleep(tiempo_modulos)

#Filtro de Busqueda 

filtro_competencia=driver.find_element(By.XPATH,"(//INPUT[@type='search'])[2]").send_keys("PRUEBASAUT")
time.sleep(tiempo_modulos)

#Usar boton visualizar

btneditar=driver.find_element(By.XPATH,"(//I[@class='fas fa-eye'])[2]")
btneditar.click()
time.sleep(tiempo_modulos)

#Usar boton regresar

btnregresar=driver.find_element(By.XPATH,"(//A[@class='btn btn-default'][text()='Regresar']")
btnregresar.click()

driver.quit()