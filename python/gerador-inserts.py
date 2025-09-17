import random
from datetime import datetime, timedelta
import os
import re
import mysql.connector

# --- CONFIGURAÇÕES DO BANCO DE DADOS ---
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'padaria_pao_genial'
}

def find_last_ids(filename):
    """
    Lê o arquivo e encontra o último id_comanda e id_item_comanda usados.
    """
    last_comanda_id = 0
    last_item_comanda_id = 0
    
    if os.path.exists(filename):
        with open(filename, 'r') as f:
            for line in f:
                match_comanda = re.search(r'INSERT INTO `comanda` .*? VALUES \((\d+),', line)
                if match_comanda:
                    last_comanda_id = int(match_comanda.group(1))

                match_item = re.search(r'INSERT INTO `item_comanda` .*? VALUES \((\d+),', line)
                if match_item:
                    last_item_comanda_id = int(match_item.group(1))
                    
    return last_comanda_id, last_item_comanda_id

def get_products_from_db():
    """
    Conecta-se ao banco de dados e retorna um dicionário de IDs e preços dos produtos.
    """
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        
        # Execute a consulta para obter os IDs e preços da sua tabela de produtos
        cursor.execute("SELECT id_produto, preco FROM produto")
        
        products = {row[0]: row[1] for row in cursor.fetchall()}
        
        cursor.close()
        conn.close()
        
        if not products:
            print("Nenhum produto encontrado na tabela 'produto'. Por favor, adicione produtos antes de gerar os inserts.")
            return None
        
        return products
    
    except mysql.connector.Error as err:
        print(f"Erro ao conectar ao banco de dados ou executar a consulta: {err}")
        return None

def generate_insert_scripts(num_inserts=5000, filename="inserts.sql"):
    """
    Gera e salva os scripts de insert agrupados.
    """
    products = get_products_from_db()
    if not products:
        return
        
    produtos_existentes = list(products.keys())
    precos = products

    formas_pagamento = ['pix', 'dinheiro', 'cartao de credito', 'cartao de debito']
    
    current_comanda_id, current_item_comanda_id = find_last_ids(filename)
    
    print(f"Iniciando a partir de id_comanda: {current_comanda_id + 1}")
    print(f"Iniciando a partir de id_item_comanda: {current_item_comanda_id + 1}")
    
    comanda_values = []
    item_comanda_values = []
    
    start_date = datetime(2000, 1, 1)
    end_date = datetime(2025, 9, 16)

    for i in range(1, num_inserts + 1):
        id_comanda = current_comanda_id + i
        
        # --- LÓGICA DE HORÁRIOS ROBUSTA ---
        # 1. Gerar uma data aleatória
        time_difference = end_date - start_date
        random_days = random.randrange(time_difference.days)
        
        # 2. Gerar uma hora de abertura entre 06:00 e 21:00
        hour_abertura = random.randint(6, 21)
        minute_abertura = random.randint(0, 59)
        second_abertura = random.randint(0, 59)
        
        # 3. Criar o objeto de data e hora de abertura
        data_abertura = start_date + timedelta(days=random_days, hours=hour_abertura, minutes=minute_abertura, seconds=second_abertura)
        
        # 4. Gerar uma hora de fechamento (entre 15 e 120 minutos depois da abertura)
        # O horário de fechamento não pode ultrapassar 22:00:00
        data_fechamento = data_abertura + timedelta(minutes=random.randint(15, 120))
        
        # Se a comanda fechar depois das 22h, ajustamos para fechar às 22h
        limite_fechamento = data_abertura.replace(hour=22, minute=0, second=0)
        if data_fechamento > limite_fechamento:
            data_fechamento = limite_fechamento

        # Formatar datas e horários para SQL
        data_abertura_str = data_abertura.strftime('%Y-%m-%d')
        hora_abertura_str = data_abertura.strftime('%H:%M:%S')
        data_fechamento_str = data_fechamento.strftime('%Y-%m-%d')
        hora_fechamento_str = data_fechamento.strftime('%H:%M:%S')
        
        status = 'fechada'
        forma_pagamento = random.choice(formas_pagamento)
        id_funcionario = random.randint(1, 10)
        
        comanda_values.append(
            f"({id_comanda}, {id_funcionario}, '{data_abertura_str}', '{hora_abertura_str}', '{data_fechamento_str}', '{hora_fechamento_str}', '{status}', '{forma_pagamento}')"
        )
        
        num_items = random.randint(1, 5)
        for _ in range(num_items):
            current_item_comanda_id += 1
            
            id_produto = random.choice(produtos_existentes)
            quantidade = random.randint(1, 10)
            price = precos.get(id_produto, 0.00)
            
            total_item = quantidade * price
            observacao = 'Nenhuma observacao' if random.random() < 0.8 else 'Sem cebola'
            
            item_comanda_values.append(
                f"({current_item_comanda_id}, {id_comanda}, {id_produto}, {quantidade}, '{observacao}', {total_item:.2f})"
            )

    return comanda_values, item_comanda_values

def save_inserts_to_file(filename="inserts.sql"):
    """
    Função principal para lidar com as operações de arquivo.
    """
    numero_de_inserts_desejado = 5000 
    
    print(f"Gerando {numero_de_inserts_desejado} inserts agrupados e salvando em '{filename}'...")
    comanda_values, item_comanda_values = generate_insert_scripts(num_inserts=numero_de_inserts_desejado, filename=filename)
    
    if comanda_values is None or item_comanda_values is None:
        return

    mode = 'a' if os.path.exists(filename) else 'w'
    with open(filename, mode) as f:
        f.write(f"\n--- Inserts for comanda table ---\n")
        f.write(f"INSERT INTO `comanda` (`id_comanda`, `id_funcionario`, `data_abertura`, `hora_abertura`, `data_fechamento`, `hora_fechamento`, `status`, `forma_pagamento`) VALUES\n")
        f.write(",\n".join(comanda_values))
        f.write(";\n\n")

        f.write(f"--- Inserts for item_comanda table ---\n")
        f.write(f"INSERT INTO `item_comanda` (`id_item_comanda`, `id_comanda`, `id_produto`, `quantidade`, `observacao`, `total`) VALUES\n")
        f.write(",\n".join(item_comanda_values))
        f.write(";\n")
            
    print(f"Os inserts agrupados foram gerados e anexados/salvos com sucesso em '{filename}'.")
    print("Você pode abrir o arquivo para visualizar ou copiá-lo para seu banco de dados.")

if __name__ == "__main__":
    save_inserts_to_file()

    # USAR ISSO

   # pip install mysql-connector-python 