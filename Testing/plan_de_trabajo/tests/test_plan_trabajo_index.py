import pytest
from selenium import webdriver
from pages.plan_trabajo_index import PlanTrabajo_index


def test_plan_de_trabajo_index(browser):
    #LOGIN
    plan_trabajo_index= PlanTrabajo_index(browser)
    plan_trabajo_index.login("zaid.garcia@becarios.silent4business.com","Administrador2")
    #MENÚ HAMBURGUESA
    plan_trabajo_index.open_menu()
    #OPCION PLAN DE TRABAJO
    plan_trabajo_index.plan_trabajo()
    #FILTRO
    plan_trabajo_index.plan_trabajo_filtro()
    #BARRA DE BUSQUEDA
    search=""
    plan_trabajo_index.plan_trabajo_searchbar(search)
    #PAGINADO
    plan_trabajo_index.plan_trabajo_paginador()
    #OPCIONES
    plan_trabajo_index.plan_trabajo_opciones()
    #EDITAR
    plan_trabajo_index.plan_trabajo_editar()
    #VER PLAN
    plan_trabajo_index.plan_trabajo_ver_plan()