import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import pdb
from config import username, password

class TimesheetDashboard:
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 20)

    def login(self,logo,btn_enviar,username_input,password_input):
        try:
            self.driver.get('https://192.168.9.78/')
            self.driver.maximize_window()
            print("Iniciando sesión en el sistema...")
            time.sleep(4)
            self._fill_input_field_css(username_input, username)
            self._fill_input_field_css(password_input, password)
            self._click_element(btn_enviar)
            print("¡Sesión iniciada con éxito!")
            self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, logo)))
        except Exception as e:
            print("Error durante el inicio de sesión:", e)

    def timesheet_dashboard_index(self, dashboard_route):
        try:
            self.driver.get(dashboard_route)
            print("Index de timesheet cargado.")
        except Exception as e:
            print("Error al cargar el index de timesheet:", e)
    def finazas_option(self,finanzas):
        try:
            self._click_element(finanzas)
            print("Opción Finanzas seleccionada.")
        except Exception as e:
            print("Error al seleccionar la opción Finanzas:", e)
    def scroll(self):
        try:
            self.driver.execute_script("window.scrollTo(0, 600)")
            print("Scroll realizado.")
            time.sleep(4)
            pdb.set_trace()
        except Exception as e:
            print("Error al realizar scroll:", e)

    def _select_option_by_text(self, locator, text):
        select = Select(self.driver.find_element(By.XPATH, locator))
        select.select_by_visible_text(text)

    def _fill_input_field_xpath(self, locator, value):
        input_field = self.wait.until(EC.visibility_of_element_located((By.XPATH, locator)))
        input_field.clear()
        input_field.send_keys(value)

    def _fill_input_field_css(self, locator, value):
            input_field = self.wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, locator)))
            input_field.clear()
            input_field.send_keys(value)

    def _click_element(self, xpath):
        element = self.wait.until(EC.element_to_be_clickable((By.XPATH, xpath)))
        element.click()
