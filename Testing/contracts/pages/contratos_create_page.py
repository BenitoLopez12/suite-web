import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import pdb
#pdb.set_trace()

class Contratos_Create:
    def __init__(self, driver):
        self.driver = driver
        #Login
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
        #menú hamburguesa
    def open_menu(self):
        menu_btn = WebDriverWait(self.driver, 3).until(
            EC.visibility_of_element_located((By.XPATH, "//button[@class='btn-menu-header']"))
        )
        menu_btn.click()
        #Gestion Contractual
    def go_to_gestion_contractual(self):
        gestion_contractual_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[@href='https://192.168.9.78/contract_manager/katbol']"))
        )
        time.sleep(0.2)
        gestion_contractual_btn.click()
        print("Botón de Gestion Contractual presionado")
        print("URL actual:", self.driver.current_url)
        #Contratos
    def go_to_contratos(self):
        contratos_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "(//a[contains(.,'Contratos')])[3]"))
            )
        contratos_btn.click()
        #Agregar Contrato
    def agregar_contrato(self):
        agregar_contrato_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(.,'Agregar Contrato +')]"))
            )
        agregar_contrato_btn.click()
    def numero_contrato(self, numero_contrato):
        numero_contrato_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@class='form-control'][contains(@id,'contrato')]"))
        )
        numero_contrato_input.clear()
        numero_contrato_input.send_keys(numero_contrato)

    def tipo_contrato(self):
        tipo_contrato_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@name,'contrato')]"))
        )
        select = Select(tipo_contrato_btn)
        select.select_by_index(3)

    def nombre_servicio(self, nombre_servicio):
        nombre_servicio_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//textarea[@class='form-control']"))
        )
        nombre_servicio_input.clear()
        nombre_servicio_input.send_keys(nombre_servicio)

    def nombre_cliente(self):
        nombre_cliente_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@name,'proveedor_id')]"))
        )
        select = Select(nombre_cliente_btn)
        select.select_by_index(3)

    def numero_proveedor(self, numero_proveedor):
        numero_proveedor_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='no_proyecto']"))
        )
        numero_proveedor_input.clear()
        numero_proveedor_input.send_keys(numero_proveedor)

    def area_contrato(self):
        area_contrato_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[@name='area_id']"))
        )
        select = Select(area_contrato_btn)
        select.select_by_index(2)
    def fase(self):
        fase_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@name,'fase')]"))
        )
        select = Select(fase_btn)
        select.select_by_index(2)

    def estatus(self):
        estatus_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[contains(@name,'estatus')]"))
        )
        select = Select(estatus_btn)
        select.select_by_index(2)

    def objetivo_servicio(self, objetivo_servicio):
        objetivo_servicio_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//textarea[@name='objetivo']"))
        )
        objetivo_servicio_input.clear()
        objetivo_servicio_input.send_keys(objetivo_servicio)

    def adjuntar_contrato(self):
        adjuntar_contrato_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='file_contrato']"))
        )
        adjuntar_contrato_btn.send_keys("/Users/imzzaidd/Desktop/S4B/tabantaj/testing/contratos/tests_files/CorruptedPDF.pdf")
    def vigencia(self):
        vigencia_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='vigencia_contrato']"))
        )
        vigencia_btn.click()
        vigencia_btn.send_keys("2021-12-31")

    def fecha_inicio(self,fecha_inicio):
        fecha_inicio_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='fecha_inicio']"))
        )
        fecha_inicio_btn.click()
        fecha_inicio_btn.send_keys(fecha_inicio)

    def fecha_fin(self,fecha_fin):
        fecha_fin_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='fecha_fin']"))
        )
        fecha_fin_btn.click()
        fecha_fin_btn.send_keys(fecha_fin)

    def fecha_firma(self,fecha_firma):
        fecha_firma_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='fecha_firma']"))
        )
        fecha_firma_btn.click()
        fecha_firma_btn.send_keys(fecha_firma)

    def numero_pagos(self,numero_pagos):
        numero_pagos_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='no_pagos']"))
        )
        numero_pagos_input.clear()
        numero_pagos_input.send_keys(numero_pagos)

    def tipo_cambio(self):
        tipo_cambio_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//select[@name='tipo_cambio']"))
        )
        select = Select(tipo_cambio_btn)
        select.select_by_index(1)


    def monto_de_pago(self,monto_de_pago):
        monto_de_pago_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@id='teste']"))
        )
        monto_de_pago_input.clear()
        monto_de_pago_input.send_keys(monto_de_pago)


    def monto_maximo(self,monto_maximo):
        monto_maximo_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@id='este' and @name='maximo']"))
        )
        monto_maximo_btn.clear()
        monto_maximo_btn.send_keys(monto_maximo)

    def monto_minimo(self,monto_minimo):
        monto_minimo_btn = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@id='prueba' and @name='minimo']"))
        )
        monto_minimo_btn.clear()
        monto_minimo_btn.send_keys(monto_minimo)

    def supervisor_1(self,supervisor_1):
        supervisor_1_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='pmp_asignado']"))
        )
        supervisor_1_input.clear()
        supervisor_1_input.send_keys(supervisor_1)

    def puesto_supervisor_1(self,puesto_supervisor_1):
        puesto_supervisor_1_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='puesto']"))
        )
        puesto_supervisor_1_input.clear()
        puesto_supervisor_1_input.send_keys(puesto_supervisor_1)
    def area_supervisor_1(self,area_supervior_1):
        area_supervisor_1_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='area']"))
        )
        area_supervisor_1_input.clear()
        area_supervisor_1_input.send_keys(area_supervior_1)

    def supervisor_2(self,supervisor_2):
        supervisor_2_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.XPATH, "//input[@name='administrador_contrato']"))
        )
        supervisor_2_input.clear()
        supervisor_2_input.send_keys(supervisor_2)

    def puesto_supervisor_2(self,puesto_supervisor_2):
        puesto_supervisor_2_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.NAME, "cargo_administrador"))
        )
        puesto_supervisor_2_input.clear()
        puesto_supervisor_2_input.send_keys(puesto_supervisor_2)

    def area_supervisor_2(self,area_supervisor_2):
        area_supervisor_2_input = WebDriverWait(self.driver, 5).until(
            EC.visibility_of_element_located((By.NAME, "area_administrador"))
        )
        area_supervisor_2_input.clear()
        area_supervisor_2_input.send_keys(area_supervisor_2)

    def guardar(self):
        guardar_btn = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//input[@id='btnGuardar']"))
        )
        guardar_btn.click()
        print("Contrato guardado")