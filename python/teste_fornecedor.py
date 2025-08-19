from selenium import webdriver 
from selenium.webdriver.common.by import By 
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import time 

driver = webdriver.Chrome()

driver.get("file:///C:/Users/raquel_f_brito/Documents/Site-de-Padaria/cadastrarfornecedor.html") # Trocar de acordo com o diretório! - 8080 ou 80 ( padão )
# Preenchimento do Nome do Fornecedor

nome_fornecedor_input = driver.find_element(By.ID, "nome_fornecedor")
nome_fornecedor_input.send_keys("Mammy Salgados")

# Preenchimento do CNPJ 

cnpj_fornecedor_input = driver.find_element(By.ID, "cnpj_fornecedor")
cnpj_fornecedor_input.send_keys("14589658489632")

# Preenchimento do Telefone

telefone_fornecedor_input = driver.find_element(By.ID, "telefone_fornecedor") 
telefone_fornecedor_input.send_keys("(84)994587-9856")

# Preenchimento do Email

email_fornecedor_input = driver.find_element(By.ID, "email_fornecedor")
email_fornecedor_input.send_keys("MammySalgados@gmail.com")

# Preenchimento do CEP 

cep_input = driver.find_element(By.ID, "cep")
cep_input.clear()
cep_input.send_keys("01001000")  # CEP de exemplo: Praça da Sé (SP)

# Clica na lupa para buscar o CEP

botao_buscar = WebDriverWait(driver, 10).until(
    EC.element_to_be_clickable((By.CSS_SELECTOR, "button[type='button']"))
)
driver.execute_script("arguments[0].click();", botao_buscar) 

# Aguarda os campos serem preenchidos automaticamente

wait = WebDriverWait(driver, 10)

# Espera até que os campos estejam visíveis/preenchidos

rua_fornecedor = wait.until(EC.presence_of_element_located((By.ID, "rua_fornecedor")))
bairro_fornecedor = wait.until(EC.presence_of_element_located((By.ID, "bairro_fornecedor")))
cidade_fornecedor = wait.until(EC.presence_of_element_located((By.ID, "cidade_fornecedor")))

# Preenchimento do UF (SELECT)

uf_element = wait.until(EC.presence_of_element_located((By.ID, "uf_fornecedor")))
uf_select = Select(uf_element) 

# Verifica se o UF foi preenchido automatcamente

uf_atual = uf_select.first_selected_option.text  # Pega o valor selecionado
print(f"UF preenchido automaticamente: {uf_atual}")

#Preenchimento para o campo Número

numero_fornecedor_input = driver.find_element(By.ID, "numero_fornecedor")
numero_fornecedor_input.send_keys("540")

# Pausa o programa para visualizar o preenchimento

time.sleep(100)

# Clica no botão cadastrar ( Linha comentada para que não seja enviado )
submit_button = driver.find_element(By.ID, "btnCadastrar") # ESTUDAR UMA FORMA PRA ESSA DESGRAÇA FUNCIONAR
driver.execute_script("arguments[0].click();", submit_button) 


driver.quit()

#==============PREENCHIMENTO MANUAL ===============#

#Preenchimento para o campo Rua
#rua_fornecedor_input = driver.find_element(By.ID, "rua_fornecedor")
#rua_fornecedor_input.send_keys("Rua Ilheus")


# Preenchimento do campo Bairro
#bairro_fornecedor_input = driver.find_element(By.ID, "bairro_fornecedor")
#bairro_fornecedor_input.send_keys("Floresta")

#Preenchimento para o campo Cidade 
#cidade_fornecedor_input = driver.find_element(By.ID, "cidade_fornecedor")
#cidade_fornecedor_input.send_keys("Joinville")

#Seleção do campo UF
#uf_fornecedor_input = driver.find_element(By.ID, "uf_fornecedor")
#uf_fornecedor.send_keys("Santa Catarina")

