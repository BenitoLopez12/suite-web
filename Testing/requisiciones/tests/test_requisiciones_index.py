import pytest
from selenium import webdriver
from pages.requisiciones_index_page import Requisiciones_index


def test_contratos(browser):
    #LOGIN
    requisiciones_index_page= Requisiciones_index(browser)
    requisiciones_index_page.login("admin@admin.com","#S3cur3P4$$w0Rd!")
    #MENÚ HAMBURGUESA
    requisiciones_index_page.open_menu()
    #GESTION CONTRACTUAL
    requisiciones_index_page.go_to_gestion_contractual()
    #REQUISICIONES
    requisiciones_index_page.requisiciones_module()
    #FILTRO
    requisiciones_index_page.requisiciones_filtro()
    #BARRA DE BÚSQUEDA
    search="TEST"
    requisiciones_index_page.requisiciones_searchbar(search)
    #APROBADORES BTN
    requisiciones_index_page.requisiciones_aprobadores()
    #ARCHIVADOS BTN
    requisiciones_index_page.requisiciones_archivados()
    #CSV
    requisiciones_index_page.requisiciones_download_csv()
    #EXCEL
    requisiciones_index_page.requisiciones_download_excel()
    #PDF
    requisiciones_index_page.requisiciones_download_pdf()
    #PRINT
    requisiciones_index_page.requisiciones_print()