import time
import pdb
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.common.exceptions import NoSuchElementException, TimeoutException

class Requisiciones_create:
    def __init__(self, driver):
        self.driver = driver

    def login(self, username, password):
        self.driver.get('https://192.168.9.78/')
        self.driver.maximize_window()
        print("------ LOGIN - TABANTAJ -----")
        time.sleep(5)
        username_input = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "input[name='email']"))
        )
        username_input.clear()
        username_input.send_keys(username)
        print("Usario ingresado")

        password_input = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "input[name='password']"))
        )
        password_input.clear()
        password_input.send_keys(password)
        print("Contraseña ingresada")

        submit_button = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//button[@type='submit'][contains(text(),'Enviar')]"))
        )
        submit_button.click()
        print("Enviando credenciales de acceso")

        WebDriverWait(self.driver, 2).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "img[alt='Logo Tabantaj']"))
        )
        print("Login correcto")

    def open_menu(self):
        menu_btn = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//button[@class='btn-menu-header']"))
        )
        menu_btn.click()

    def go_to_gestion_contractual(self):
        gestion_contractual_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[@href='https://192.168.9.78/contract_manager/katbol']"))
        )
        time.sleep(0.2)
        gestion_contractual_btn.click()
        print("Botón de Gestion Contractual presionado")
        print("URL actual:", self.driver.current_url)

    def requisiciones_module(self):
        requisiciones_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(.,'Requisiciones')]"))
            )
        requisiciones_btn.click()
        print("Botón de Requisiciones presionado")
        print("URL actual:", self.driver.current_url)
    def requisiciones_create(self):
        create_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//button[contains(.,'Agregar')]"))
            )
        create_btn.click()
        print("Botón de Crear Requisición presionado")
        print("URL actual:", self.driver.current_url)

    def fecha_solicitud(self,fecha_solicitud):
        fecha_solicitud_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='fecha']"))
        )
        fecha_solicitud_btn.click()
        fecha_solicitud_btn.send_keys(fecha_solicitud)

    def razon_social(self):
        razon_social_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@name,'sucursal_id')]"))
        )
        select = Select(razon_social_btn)
        select.select_by_index(2)

    def titulo_requisicion(self,titulo_requisicion):
        titulo_requisicion_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='descripcion']"))
        )
        titulo_requisicion_btn.send_keys(titulo_requisicion)

    def comprador(self):
        comprador_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@name,'comprador_id')]"))
        )
        select = Select(comprador_btn)
        select.select_by_index(1)

    def proyecto(self,proyecto):
        proyecto_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//span[@class='select2-selection__arrow']"))
            )
        proyecto_btn.click()
        time.sleep(0.5)
        pdb.set_trace()
        proyecto_btn.send_keys(Keys.ENTER)