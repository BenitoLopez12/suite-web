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
tiempo_espera=15
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

time.sleep(tiempo_modulos)

#Entrar a Evaluacion 360

modulo=driver.find_element(By.XPATH,"//A[@id='nav-ev360-tab']").click()
time.sleep(tiempo_modulos)

#Usar boton crear evaluaciones
btncreate=driver.find_element(By.XPATH,"//A[@href='https://192.168.9.78/admin/recursos-humanos/evaluacion-360/evaluaciones/create']").click()
time.sleep(tiempo_espera)

#Usar campo nombre

btnnombre=driver.find_element(By.XPATH,"//INPUT[@id='nombre']").send_keys("Evaluacion de Prueba")

#Usar campo descripcion

btndescripcion=driver.find_element(By.XPATH,"//TEXTAREA[@class='form-control ']").send_keys("Evaluacion de Prueba")

#Usar btn competencias

btncompetencia=driver.find_element(By.XPATH,"//SPAN[@class='checkmark'])[1]").click()

#Usar btn objetivos

btncompetencia=driver.find_element(By.XPATH,"//SPAN[@class='checkmark'])[2]").click()

#Usar btn siguiente

btncompetencia=driver.find_element(By.XPATH,"//BUTTON[@type='button']").click()


"""

seleccionarp=driver.find_element(By.XPATH,"(//SPAN)[14]")
seleccionarp.click()
#Actualizaciones de datos

nombre_competencia=driver.find_element(By.XPATH,"//INPUT[@id='nombre']").send_keys("PRUEBASAUTCOPETENCIAS ACTUALIZACION")
time.sleep(tiempo_modulos)
descripcion=driver.find_element(By.XPATH,"(//TEXTAREA[@class='form-control '])[2]").send_keys("PruebaAutomatizada Actualizada")
time.sleep(tiempo_modulos)

tipocompetencia=driver.find_element(By.XPATH,"//SELECT[@id='tipo_id']").send_keys("Competencia Funcional")

time.sleep(tiempo_modulos)
btn3=driver.find_element(By.XPATH,"//BUTTON[@type='submit'][text()='Guardar']")
btn3.click()
"""