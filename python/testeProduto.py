from selenium import webdriver 
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select 
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time
import os

# ----------------- CONFIGURAÇÃO DO NAVEGADOR -----------------
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")

service = Service(ChromeDriverManager().install())
driver = webdriver.Chrome(service=service, options=options)

wait = WebDriverWait(driver, 15)

# ----------------- LOGIN -----------------
driver.get("http://localhost:8080/Site-de-Padaria/index.php")

email_input = wait.until(EC.presence_of_element_located((By.NAME, "email_funcionario")))
email_input.send_keys("jamillyrodriguesfroes@gmail.com")

senha_input = driver.find_element(By.ID, "senha")
senha_input.send_keys("12345678")

btn_login = driver.find_element(By.CSS_SELECTOR, "button.botao-style")
btn_login.click()

# ----------------- ESPERAR E IR PARA PÁGINA DE CADASTRO -----------------
time.sleep(5)
driver.get("http://localhost:8080/Site-de-Padaria/html_cadastros/cadastrar_produto.php")

nome_produto_input = wait.until(EC.presence_of_element_located((By.ID, "nome_produto")))

# ----------------- PREENCHER FORMULÁRIO -----------------
nome_produto_input.send_keys("Sonho Recheado")
driver.find_element(By.ID, "descricao").send_keys("Delicioso sonho com recheio de creme")
driver.find_element(By.ID, "preco").send_keys("5,50")

unidade_select = Select(driver.find_element(By.ID, "unmedida"))
unidade_select.select_by_value("un")

driver.find_element(By.ID, "quantidade_produto").send_keys("50")
driver.find_element(By.ID, "validade").send_keys("31/12/2025")


fornecedor_select = Select(driver.find_element(By.ID, "id_fornecedor"))
fornecedor_select.select_by_value("5") 


caminho_imagem = os.path.abspath("sonho.png") 
driver.find_element(By.ID, "imagem_produto").send_keys("C:/xamp/htdocs/Site-de-Padaria/python/sonho.png")


btn_cadastrar = driver.find_element(By.CSS_SELECTOR, "button.btn-cadastrar")
driver.execute_script("arguments[0].scrollIntoView(true);", btn_cadastrar)
btn_cadastrar = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "button.btn-cadastrar")))
btn_cadastrar.click()

time.sleep(5)
driver.quit()
