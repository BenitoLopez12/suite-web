from pages.administracion.configurar_organizacion.procesos.create.procesos_create_page import Create_Procesos
from selenium.webdriver.firefox.options import Options as FirefoxOptions
from selenium import webdriver
import pytest

@pytest.fixture(scope="session")
def browser():
    options = FirefoxOptions()
    options.add_argument('--headless')
    options.add_argument('--disable-gpu')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
 
 
    options.add_argument('--disable-extensions')
    options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--disable-browser-side-navigation')
    options.add_argument('--disable-gpu')
    options.add_argument('--no-sandbox')
    options.add_argument('--log-level=3')
    
    driver = webdriver.Firefox(options=options)
    yield driver
    driver.quit()  
    
def test_create_procesos(browser):
    
 create_procesos = Create_Procesos(browser)
 create_procesos.login()
 create_procesos.in_submodulo(menu_hamburguesa, element_entrar_modulo, element_entrar_submodulo)
 create_procesos.add_procesos(agregar_btn_xpath, guardar_xpath)
 
#Variables
menu_hamburguesa = "//BUTTON[@class='btn-menu-header']"
element_entrar_modulo = "(//A[@href='#'])[3]"
element_entrar_submodulo = "//A[@href='https://192.168.9.78/admin/procesos'][text()='Procesos']"
agregar_btn_xpath= "//A[@href='https://192.168.9.78/admin/procesos/create'][text()='Registrar Proceso']"
guardar_xpath = "//button[contains(@class, 'btn-danger') and normalize-space(text())='Guardar']"
