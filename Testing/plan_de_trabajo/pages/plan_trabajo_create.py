import time
import pdb
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains

class PlanTrabajo_create:
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
        print("URL actual: ", self.driver.current_url)

    def open_menu(self):
        menu_btn = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//button[@class='btn-menu-header']"))
        )
        menu_btn.click()

    def plan_trabajo(self):
        plan_trabajo_btn= WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(.,'Planes de acción')]"))
        )
        plan_trabajo_btn.click()
        print("Ingresando a Plan de trabajo")
        print("URL actual: ", self.driver.current_url)

    def plan_trabajo_create(self):
        plan_trabajo_create_btn= WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//a[@href='https://192.168.9.78/admin/planes-de-accion/create']"))
        )
        plan_trabajo_create_btn.click()
        print("Ingresando a Crear Plan de trabajo")
        print("URL actual: ", self.driver.current_url)

    def input_nombre_create(self, nombre):
        nombre_input = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//input[contains(@type,'text')]"))
        )
        nombre_input.clear()
        nombre_input.send_keys(nombre)
        print("Nombre ingresado")

    def select_norma_create(self):
        norma_select = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@id,'norma')]"))
        )
        select = Select(norma_select)
        select.select_by_index(2)
        print("Norma seleccionada")

    def input_objetivo_create(self, objetivo):
        objetivo_input = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//textarea[contains(@class,'form-control ')]"))
        )
        objetivo_input.clear()
        objetivo_input.send_keys(objetivo)
        print("Objetivo ingresado")

    def guardar_btn(self):
        guardar_btn = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//button[contains(.,'Guardar')]"))
        )
        guardar_btn.click()
        print("Guardando Plan de trabajo")
        time.sleep(0.2)
        print("URL actual: ", self.driver.current_url)
        pdb.set_trace()