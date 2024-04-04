import time
import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException

#TEST CREAR AREAS

#Variables
menu_hamburguesa = "//BUTTON[@class='btn-menu-header']"
element_entrar_submodulo = "//A[@href='https://192.168.9.78/admin/areas'][text()='Crear Áreas']"
element_confirgurar_organizacion = "(//I[@class='material-symbols-outlined i-direct'][text()='keyboard_arrow_down'])[2]"
agregar_btn_xpath= "//BUTTON[@class='btn btn-xs btn-outline-success rounded ml-2 pr-3']"
trespuntos_btn_xpath= "//I[@class='fa-solid fa-ellipsis-vertical']"
boton_editar = "//I[@class='fas fa-edit']"
campo_buscar_xpath= "(//INPUT[@type='search'])[2]"

#Temporizadores
tiempo_modulos = 4
tiempo_carga = 10
tiempo_espera = 2.5

@pytest.fixture(scope="module")
def browser():
    driver = webdriver.Firefox()
    yield driver
    driver.quit()
    

def login(driver):

    # Abrir la URL de Tabantaj
    driver.get('https://192.168.9.78/')

    # Maximizar la ventana del navegador
    driver.maximize_window()
    time.sleep(5)

    # Ingresar credenciales
    usuario = driver.find_element(By.XPATH, "//input[contains(@name,'email')]").send_keys("admin@admin.com")
    time.sleep(tiempo_modulos)
    password = driver.find_element(By.XPATH, "//input[contains(@name,'password')]").send_keys("#S3cur3P4$$w0Rd!")
    time.sleep(tiempo_modulos)

    # Hacer clic en el botón de envío
    btn = driver.find_element(By.XPATH, "//button[@type='submit'][contains(.,'Enviar')]")
    btn.click()
    
    WebDriverWait(driver, 2).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "img[alt='Logo Tabantaj']"))
    )
    print("Login correcto")
    
    print("URL actual:", driver.current_url)
    
def test_login(browser):
    
    login(browser)
    
################################################## Entrar a Modulos y Submodulos
    
def in_submodulo(driver):
    
    time.sleep(tiempo_modulos)
    
    # Entrando a Menu Hamburguesa
    print("URL actual:", driver.current_url)
    print("Entrando a Menu Hamburguesa...")
    element = driver.find_element(By.XPATH, menu_hamburguesa)
    driver.execute_script("arguments[0].scrollIntoView(true);", element)
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, menu_hamburguesa)))
    print("Dando clic en Menu Hamburguesa...")
    element.click()

    time.sleep(tiempo_modulos)
    
    # Entrando a Modulo Configurar Organizacion
    print("Entrando a Configurar Organizacion...")
    element = driver.find_element(By.XPATH, element_confirgurar_organizacion)
    driver.execute_script("arguments[0].scrollIntoView(true);", element)
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, element_confirgurar_organizacion)))
    print("Dando clic en Configurar Organizacion...")
    element.click()
    
    time.sleep(tiempo_modulos)

    # Entrando a Sub Modulo Categoria Crear Areas
    print("Entrando a Sub Modulo Categoria de Crear Areas...")
    entrar = driver.find_element(By.XPATH,element_entrar_submodulo)
    driver.execute_script("arguments[0].scrollIntoView(true);", element)
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH,element_entrar_submodulo)))
    print("Dando clic en Sub Modulo Categoria de Crear Areas...")
    entrar.click()
    
    time.sleep(tiempo_modulos)
    
    print("URL actual:", driver.current_url)
    
def test_in_submodulos(browser):
    
    in_submodulo(browser)
    
########################################## AGREGAR Y LLENAR REPOSITORIO ####################################
    
def add_areas(driver):    

    # Dando clic en Boton Agregar Area
    print("Dando clic al botón Agregar Crear Areas...")
    wait = WebDriverWait(driver, 10)
    agregar_btn = wait.until(EC.presence_of_element_located((By.XPATH, agregar_btn_xpath)))
    agregar_btn.click()
    
    time.sleep(tiempo_modulos)
    
    # Nombre del Area
    print("Llenando nombre der Area...")
    campo_area = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//INPUT[@id='area']"))
        )
    campo_area.click()
    campo_area.send_keys("Area de Prueba 000001117")

    time.sleep(tiempo_modulos)
    
    # Nombre del Responsable
    print("Llenando nombre del responsable... ")
    campo_n_responsable = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//SELECT[@id='nombre_contacto_puesto']"))
        )
    campo_n_responsable.click()
    campo_n_responsable.send_keys("Luis Fernando Jonathan Vargas Osornio")

    time.sleep(tiempo_modulos)
    
    # Nombre del Area a la que Reporta
    print("Asignando nombre del area a la que reporta... ")
    campo_area_reporta = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//SELECT[@id='inputGroupSelect01']"))
        )
    campo_area_reporta.click()
    time.sleep(tiempo_espera)
    campo_area_reporta.send_keys("Arquitectura")
    time.sleep(tiempo_espera)
    campo_area_reporta.click()

    time.sleep(tiempo_modulos)
    
    # Nombre del Grupo
    print("Asignando nombre del grupo... ")
    campo_grupo = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//SELECT[@id='id_grupo']"))
        )
    campo_grupo.click()
    time.sleep(tiempo_espera)
    campo_grupo.send_keys("Grupo Operativo")
    time.sleep(tiempo_espera)
    campo_grupo.click()

    time.sleep(tiempo_modulos)
    
    # Descripcion
    print("Llenando descripcion del apartado...")
    campo_descripcion = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//TEXTAREA[@id='descripcion']"))
        )
    campo_descripcion.click()
    campo_descripcion.send_keys("Descripcion de Prueba")

    time.sleep(tiempo_modulos)
    
    # Guardar
    print("Guardando repositorio creado... ")
    guardar_xpath = "//BUTTON[contains(@class, 'btn') and contains(@class, 'btn-danger') and normalize-space()='Guardar']"
    guardar = WebDriverWait(driver, 20).until(
        EC.element_to_be_clickable((By.XPATH, guardar_xpath))
    )
    guardar.click()

    time.sleep(tiempo_modulos)
    
    print("URL actual:", driver.current_url)
    

def test_add_areas(browser):
    
    add_areas(browser)
    
#################################BUSCAR REPOSITORIO Y ENTRAR A BOTONES DE EDICION###################################

def edit_areas(driver):
    
    time.sleep(tiempo_carga)
    
    # Campo Buscar
    campo_entrada = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, campo_buscar_xpath))
    )
    campo_entrada.click()
    campo_entrada.send_keys("Area de Prueba 000001117")

    time.sleep(tiempo_carga)

    # Boton 3 puntos
    print("Dando clic al botón 3 puntos...")
    wait = WebDriverWait(driver, 10)
    # Esperar a que el elemento esté presente en el DOM
    puntos_btn = wait.until(EC.presence_of_element_located((By.XPATH, trespuntos_btn_xpath)))
    # Ahora intenta hacer clic en el elemento
    puntos_btn.click()

    time.sleep(tiempo_modulos)

    # Boton editar
    print("Dando clic al botón editar...")
    wait = WebDriverWait(driver, 10)
    # Esperar a que el elemento esté presente en el DOM
    btn_editar = wait.until(EC.presence_of_element_located((By.XPATH, boton_editar)))
    # Ahora intenta hacer clic en el elemento
    btn_editar.click()

    time.sleep(tiempo_modulos)  
    
   # Descripcion
    campo_descripcion = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//TEXTAREA[@id='descripcion']"))
        )
    campo_descripcion.click()
    campo_descripcion.clear()
    campo_descripcion.send_keys("Descripcion de Prueba Actuakizado 22")

    time.sleep(tiempo_modulos)

    # Guardar actualización
    print("Dando clic al botón Guardar para guardar actualización...")
    guardar_xpath = "//BUTTON[contains(@class, 'btn') and contains(@class, 'btn-danger') and normalize-space()='Guardar']"
    guardar = WebDriverWait(driver, 20).until(
        EC.element_to_be_clickable((By.XPATH, guardar_xpath))
    )
    guardar.click()
    
    print("URL actual:", driver.current_url)

    time.sleep(tiempo_modulos)  

def test_edit_areas(browser):
    
    edit_areas(browser)
    