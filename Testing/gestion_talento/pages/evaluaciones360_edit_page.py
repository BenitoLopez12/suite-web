import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select

#Temporizadores
tiempo_modulos = 5
tiempo_carga = 10
tiempo_espera = 3
tiempo_llenado = 1
tiempo_largo = 120

#----------------------------------------------------INICIO DE CLASE--------------------------------------------------------------------------

class Evaluaciones_360_edit_page:
    
    def __init__(self, driver):
        self.driver = driver


    def login(self, username, password):
        
        #Entrando URL
        self.driver.get('https://192.168.9.78/')
        self.driver.maximize_window()
        print("------ LOGIN - TABANTAJ -----")
        time.sleep(5)
        
        #Ingresando Correo
        username_input = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "input[name='email']"))
        )
        username_input.clear()
        username_input.send_keys(username)
        print("Usario ingresado")

        #Ingresando Contraseña
        password_input = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "input[name='password']"))
        )
        password_input.clear()
        password_input.send_keys(password)
        print("Contraseña ingresada")

        #Dando clic botón Enviar
        submit_button = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//button[@type='submit'][contains(text(),'Enviar')]"))
        )
        submit_button.click()
        print("Enviando credenciales de acceso")
        
        #Encontrando imagen de Incio de Sesión
        WebDriverWait(self.driver, 2).until(
            EC.presence_of_element_located((By.XPATH, "//IMG[@src='https://192.168.9.78/img/logo-ltr.png']"))
        )
        print("Login correcto")
        
        print("URL actual:", self.driver.current_url)
        
        time.sleep(tiempo_llenado)
        
    def in_modulos(self):
        
        # Entrando a Menu Hamburguesa
        print("Entrando a Menu Hamburguesa ...")
        btn_hmaburguesa = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//BUTTON[@class='btn-menu-header']"))
        )
        btn_hmaburguesa.click()
        
        time.sleep(tiempo_llenado)
        
        # Entrando a Gestión Talento 
        print("Entrando a Gestión Talento ...")
        btn_gt = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//A[@href='https://192.168.9.78/admin/capital-humano']"))
        )
        btn_gt.click()
        
        time.sleep(tiempo_llenado)

        # Entrando a Sub Modulo Evalución 360
        print("Entrando a Sub Modulo Evalución 360 ...")
        btn_evaluaciones = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//a[contains(.,'Evaluación 360')]"))
        )
        btn_evaluaciones.click()
        
        time.sleep(tiempo_llenado)
        
        # Entrando a Seguimiento Evaluaciones
        print("Entrando a Seguimiento Evaluaciones ...")
        btn_crear_evaluaciones = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//A[@href='https://192.168.9.78/admin/recursos-humanos/evaluacion-360/evaluaciones']"))
        )
        btn_crear_evaluaciones.click()
        
        time.sleep(tiempo_llenado)
        
        print("URL actual:", self.driver.current_url)
        
    def edit_evaluacion360 (self):
        
        # Dando clic en buscador 
        print("Dando clic en buscador ...")
        btn_buscar = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "(//INPUT[@type='search'])[2]"))
        )
        btn_buscar.click()
        btn_buscar.send_keys("PRUEBA-1")
        
        time.sleep(tiempo_llenado)
        
        # Entrar a boton evaluacion
        print("Dando clic en boton evaluacion (editar) ...")
        btn_edit = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "(//I[@class='fas fa-cogs'])[1]"))
        )
        btn_edit.click()

        time.sleep(tiempo_llenado)
        
    def send_reminder(self):
        
        # Boton enviar recordatorio
        print("Dando clic en enviar recordatorio...")
        btn_send_reminder = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//BUTTON[@id='btnEnviarRecordatorio']"))
        )
        btn_send_reminder.click()

        time.sleep(tiempo_llenado)
        
        # Boton enviar 
        print("Dando clic en boton enviar ...")
        btn_send = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//BUTTON[@type='button'][text()='¡Enviar!']"))
        )
        btn_send.click()

        time.sleep(tiempo_llenado)
        
    def view_evaluacion360 (self):
        
        # Boton visualizar
        print("Dando clic en boton visualizar (entrando a evaluacion) ...")
        btn_view_evaluacion = WebDriverWait(self.driver, 3).until(
            EC.element_to_be_clickable((By.XPATH, "//I[@class='fas fa-arrow-right']"))
        )
        btn_view_evaluacion.click()

        time.sleep(tiempo_llenado)
        
        
        
        
        
    