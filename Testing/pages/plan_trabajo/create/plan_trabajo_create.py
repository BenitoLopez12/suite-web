import time
import pdb
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.common.exceptions import TimeoutException
from config import username, password

class PlanTrabajo_create:
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 20)

    def login(self):
        try:
            self.driver.get('https://192.168.9.78/')
            self.driver.maximize_window()
            print("Iniciando sesión en el sistema...")
            time.sleep(4)
            self._fill_input_field("input[name='email']", username)
            self._fill_input_field("input[name='password']", password)
            self._click_element("//button[@type='submit'][contains(text(),'Enviar')]")
            print("¡Sesión iniciada con éxito!")
            self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "img[alt='Logo Tabantaj']")))
            print("Login correcto.")
        except Exception as e:
            print("Error durante el inicio de sesión:", e)

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
            EC.element_to_be_clickable((By.XPATH, "//button[contains(text(), 'Agregar nuevo')]"))
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

    def seleccionar_fecha_inicio(self, fecha):
        print("Seleccionando fecha...")
        self._wait_and_fill("//input[@id='inicio']", fecha)
        print("Fecha seleccionada.")
    def seleccionar_fecha_fin(self, fecha):
        print("Seleccionando fecha...")
        self._wait_and_fill("//input[@id='fin']", fecha)
        print("Fecha seleccionada.")
    def descripcion(self, descripcion):
        print("Ingresando descripción...")
        self._fill_input_field1("//textarea[contains(@class,'form-control')]", descripcion)
        print("Descripción ingresada.")

    def guardar_btn(self):
        guardar_btn = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//button[contains(.,'Guardar')]"))
        )
        guardar_btn.click()
        print("Guardando Plan de trabajo")
        time.sleep(0.2)
        print("URL actual: ", self.driver.current_url)


    def _fill_input_field(self, locator, value):
        input_field = self.wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, locator)))
        input_field.clear()
        input_field.send_keys(value)

    def _fill_input_field1(self, locator, value):
        input_field = self.wait.until(EC.visibility_of_element_located((By.XPATH, locator)))
        input_field.clear()
        input_field.send_keys(value)

    def _click_element(self, xpath):
        element = self.wait.until(EC.element_to_be_clickable((By.XPATH, xpath)))
        element.click()

    def _wait_and_fill(self, xpath, value):
        try:
            element = self.wait.until(EC.visibility_of_element_located((By.XPATH, xpath)))
            element.clear()
            element.send_keys(value)
        except TimeoutException:
            raise TimeoutError(f"Elemento no encontrado en {xpath}")
