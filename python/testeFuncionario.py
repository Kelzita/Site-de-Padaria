from selenium import webdriver 
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select 
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time

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
driver.get("http://localhost:8080/Site-de-Padaria/html_cadastros/cadastrar_funcionario.php")

nome_funcionario_input= wait.until(EC.presence_of_element_located((By.ID, "nome_funcionario")))

# ----------------- PREENCHER FORMULÁRIO -----------------
nome_funcionario_input.send_keys("Joshua Kyle Beauchamp")
driver.find_element(By.ID, "cpf_funcionario").send_keys("815.492.370-04")
driver.find_element(By.ID, "email_funcionario").send_keys("joshuakyle@gmail.com")
driver.find_element(By.ID, "telefone_funcionario").send_keys("(84)99458-79856")
driver.find_element(By.ID, "senha").send_keys("12345678")
driver.find_element(By.ID, "cep_funcionario").send_keys("01001-000")
driver.find_element(By.ID, "rua_funcionario").send_keys("Praça da Sé")
driver.find_element(By.ID, "numero_funcionario").send_keys("540")
driver.find_element(By.ID, "bairro_funcionario").send_keys("Sé")
driver.find_element(By.ID, "cidade_funcionario").send_keys("São Paulo")

uf_select = Select(driver.find_element(By.ID, "uf_funcionario"))
uf_select.select_by_visible_text("SP")

driver.find_element(By.ID, "data_admissao").send_keys("09/09/2025")

driver.find_element(By.ID, "salario").send_keys("1.200,00")

funcao_select = Select(driver.find_element(By.ID, "id_funcao"))
funcao_select.select_by_value("3")

time.sleep(2)  # conferir preenchimentos
driver.find_element(By.CSS_SELECTOR, "button.btn-cadastrar").click()

time.sleep(5)
driver.quit()