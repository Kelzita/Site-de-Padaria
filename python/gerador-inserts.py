import random
from datetime import datetime, timedelta
import os
import re
import mysql.connector
import math

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

def get_time_weighted_probability(hour):
    """
    Retorna um peso de probabilidade baseado na hora do dia.
    Padarias geralmente têm picos pela manhã (6h-9h) e final da tarde (16h-18h).
    """
    # Distribuição típica de movimento em uma padaria
    if 6 <= hour < 9:    # Manhã - pico
        return 2.0
    elif 9 <= hour < 11:  # Manhã - movimento moderado
        return 1.5
    elif 11 <= hour < 14: # Horário de almoço
        return 1.2
    elif 14 <= hour < 16: # Tarde - movimento mais lento
        return 0.8
    elif 16 <= hour < 19: # Final da tarde - pico
        return 1.8
    elif 19 <= hour < 22: # Noite - movimento moderado
        return 1.2
    else:                 # Fora do horário de funcionamento
        return 0.0

def generate_realistic_time(start_date, end_date):
    """
    Gera um horário realista baseado na distribuição típica de uma padaria.
    """
    # Gerar uma data aleatória dentro do intervalo
    time_difference = end_date - start_date
    random_days = random.randrange(time_difference.days)
    base_date = start_date + timedelta(days=random_days)
    
    # Gerar hora considerando a distribuição de probabilidade
    valid_hours = []
    probabilities = []
    
    for hour in range(6, 22):  # Das 6h às 22h
        weight = get_time_weighted_probability(hour)
        if weight > 0:
            valid_hours.append(hour)
            probabilities.append(weight)
    
    # Normalizar probabilidades
    total = sum(probabilities)
    probabilities = [p/total for p in probabilities]
    
    # Selecionar hora baseada na distribuição de probabilidade
    selected_hour = random.choices(valid_hours, weights=probabilities, k=1)[0]
    
    # Gerar minutos e segundos
    minute = random.randint(0, 59)
    second = random.randint(0, 59)
    
    # Criar datetime completo
    return base_date.replace(hour=selected_hour, minute=minute, second=second)

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
        
        # Gerar horário realista para abertura da comanda
        data_abertura = generate_realistic_time(start_date, end_date)
        
        # Definir tempo de permanência baseado no horário
        hour = data_abertura.hour
        
        if hour < 9:  # Manhã - clientes mais rápidos
            max_duration = 30  # minutos
        elif hour < 14:  # Período intermediário
            max_duration = 45  # minutos
        else:  # Tarde/noite - clientes mais relaxados
            max_duration = 60  # minutos
            
        # Garantir que o tempo de permanência seja razoável (5-45 minutos)
        duration = min(max_duration, random.randint(5, 60))
        
        # Calcular horário de fechamento
        data_fechamento = data_abertura + timedelta(minutes=duration)
        
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
        
        # Número de itens baseado no horário (manhã tende a ter compras maiores)
        if hour < 11:  # Manhã
            num_items = random.choices([1, 2, 3, 4, 5], weights=[0.1, 0.2, 0.3, 0.3, 0.1], k=1)[0]
        else:  # Resto do dia
            num_items = random.choices([1, 2, 3, 4, 5], weights=[0.3, 0.3, 0.2, 0.15, 0.05], k=1)[0]
            
        for _ in range(num_items):
            current_item_comanda_id += 1
            
            id_produto = random.choice(produtos_existentes)
            
            # Quantidade baseada no tipo de produto (pães tendem a ser comprados em maior quantidade)
            if "pao" in str(id_produto).lower() or "bread" in str(id_produto).lower():
                quantidade = random.choices([1, 2, 3, 4, 5, 6], weights=[0.1, 0.2, 0.3, 0.2, 0.1, 0.1], k=1)[0]
            else:
                quantidade = random.choices([1, 2, 3], weights=[0.7, 0.2, 0.1], k=1)[0]
                
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