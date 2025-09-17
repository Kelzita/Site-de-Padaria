import random
from datetime import datetime, timedelta
import os
import re
import mysql.connector
import math
from collections import defaultdict

# --- CONFIGURAÇÕES DO BANCO DE DADOS ---
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'padaria_pao_genial'
}

# Dias da semana com comportamentos diferentes
PESOS_DIA_SEMANA = {
    0: 0.8,  # Segunda - movimento moderado
    1: 1.0,  # Terça - movimento normal
    2: 1.0,  # Quarta - movimento normal
    3: 1.2,  # Quinta - movimento acima da média
    4: 1.5,  # Sexta - movimento alto
    5: 2.0,  # Sábado - movimento muito alto
    6: 1.8  # Domingo - movimento alto (manhã)
}

# Feriados importantes (mês, dia) com multiplicador de movimento
FERIADOS = {
    (1, 1): 1.8,    # Ano Novo
    (4, 21): 1.5,  # Tiradentes
    (5, 1): 1.3,    # Dia do Trabalho
    (9, 7): 1.4,    # Independência
    (10, 12): 2.0,  # Nossa Senhora Aparecida
    (11, 2): 1.3,  # Finados
    (11, 15): 1.4,  # Proclamação da República
    (12, 25): 2.0,  # Natal
    (12, 31): 1.8  # Véspera de Ano Novo
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
    Conecta-se ao banco de dados e retorna informações dos produtos.
    """
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        
        # Execute a consulta para obter os IDs e preços dos produtos
        cursor.execute("SELECT id_produto, preco FROM produto")
        
        products = {}
        for row in cursor.fetchall():
            id_produto, preco = row
            products[id_produto] = preco
        
        cursor.close()
        conn.close()
        
        if not products:
            print("Nenhum produto encontrado na tabela 'produto'. Por favor, adicione produtos antes de gerar os inserts.")
            return None
        
        return products
    
    except mysql.connector.Error as err:
        print(f"Erro ao conectar ao banco de dados ou executar a consulta: {err}")
        return None

def infer_product_type(product_id):
    """
    Infere o tipo de produto com base no ID.
    """
    # Esta é uma suposição - ajuste conforme a numeração real dos seus produtos
    if product_id <= 20:
        return "pao"          # Pães (IDs 1-20)
    elif product_id <= 40:
        return "bolo"         # Bolos (IDs 21-40)
    elif product_id <= 60:
        return "salgado"      # Salgados (IDs 41-60)
    elif product_id <= 70:
        return "bebida"       # Bebidas (IDs 61-70)
    elif product_id <= 80:
        return "confeitaria"  # Confeitaria (IDs 71-80)
    else:
        return "outro"        # Outros produtos (IDs 81+)

def get_quantity_for_product_type(product_type):
    """
    Retorna uma quantidade realista baseada no tipo de produto.
    """
    if product_type == "pao":
        return random.choices([1, 2, 3, 4, 5, 6], weights=[0.1, 0.2, 0.3, 0.2, 0.1, 0.1], k=1)[0]
    elif product_type == "bolo":
        return random.choices([1, 2, 3], weights=[0.6, 0.3, 0.1], k=1)[0]
    elif product_type == "salgado":
        return random.choices([1, 2, 3, 4], weights=[0.4, 0.3, 0.2, 0.1], k=1)[0]
    elif product_type == "bebida":
        return random.choices([1, 2], weights=[0.8, 0.2], k=1)[0]
    elif product_type == "confeitaria":
        return random.choices([1, 2], weights=[0.7, 0.3], k=1)[0]
    else:
        return random.choices([1, 2], weights=[0.9, 0.1], k=1)[0]

def is_feriado(date):
    """
    Verifica se a data é um feriado.
    """
    return (date.month, date.day) in FERIADOS

def get_time_weighted_probability(hour, is_weekend, is_feriado):
    """
    Retorna um peso de probabilidade baseado na hora do dia, considerando fins de semana e feriados.
    """
    # Distribuição REALISTA de movimento em uma padaria - CORRIGIDA
    if 6 <= hour < 8:    # Primeira hora - movimento moderado
        return 1.5
    elif 8 <= hour < 10:  # Pico da manhã - movimento alto
        return 3.0 if not is_weekend else 3.5
    elif 10 <= hour < 12: # Manhã - movimento moderado
        return 2.0
    elif 12 <= hour < 14: # Horário de almoço
        return 2.5
    elif 14 <= hour < 16: # Tarde - movimento mais lento
        return 1.5
    elif 16 <= hour < 18: # Final da tarde - pico
        return 2.5 if not is_weekend else 3.0
    elif 18 <= hour < 20: # Noite - movimento moderado
        return 2.0
    elif 20 <= hour < 22: # Final de expediente - movimento baixo
        return 1.2
    else:               # Fora do horário de funcionamento
        return 0.0

def get_daily_weight(date):
    """
    Retorna um peso para o dia baseado no dia da semana e feriados.
    """
    weekday = date.weekday()
    base_weight = PESOS_DIA_SEMANA[weekday]
    
    # Ajustar para feriados
    if is_feriado(date):
        feriado_multiplier = FERIADOS[(date.month, date.day)]
        return base_weight * feriado_multiplier
    
    return base_weight

def generate_realistic_time(start_date, end_date):
    """
    Gera um horário realista baseado na distribuição típica de uma padaria.
    Considera dias da semana, feriados e sazonalidade.
    """
    # Gerar uma data aleatória dentro do intervalo
    total_days = (end_date - start_date).days
    random_days = random.randint(0, total_days)
    base_date = start_date + timedelta(days=random_days)
    
    is_weekend = base_date.weekday() >= 5
    is_holiday = is_feriado(base_date)
    daily_weight = get_daily_weight(base_date)
    
    valid_hours = []
    probabilities = []
    
    # Garantir que TODAS as horas de funcionamento (6h-22h) sejam consideradas
    for hour in range(6, 22):  # Das 6h às 22h
        time_weight = get_time_weighted_probability(hour, is_weekend, is_holiday)
        final_weight = time_weight * daily_weight
        
        if final_weight > 0:
            valid_hours.append(hour)
            probabilities.append(final_weight)
    
    # Selecionar hora baseada na distribuição de probabilidade
    selected_hour = random.choices(valid_hours, weights=probabilities, k=1)[0]
    
    # Gerar minutos e segundos com distribuição mais realista
    minute = random.randint(0, 59)
    second = random.randint(0, 59)
    
    # Criar datetime completo
    return base_date.replace(hour=selected_hour, minute=minute, second=second)

def get_products_for_time(hour, product_ids):
    """
    Seleciona produtos apropriados para o horário com base no tipo inferido.
    """
    # Determinar pesos por tipo de produto baseado no horário
    if hour < 12:  # Manhã: mais pães, bolos
        type_weights = {
            "pao": 0.40, 
            "bolo": 0.25, 
            "salgado": 0.15, 
            "bebida": 0.15, 
            "confeitaria": 0.04, 
            "outro": 0.01
        }
    elif hour < 18:  # Tarde: mais salgados e bebidas
        type_weights = {
            "pao": 0.25, 
            "bolo": 0.15, 
            "salgado": 0.30, 
            "bebida": 0.20, 
            "confeitaria": 0.08, 
            "outro": 0.02
        }
    else:  # Noite: mais pães
        type_weights = {
            "pao": 0.50, 
            "bolo": 0.10, 
            "salgado": 0.15, 
            "bebida": 0.15, 
            "confeitaria": 0.08, 
            "outro": 0.02
        }
    
    # Classificar produtos por tipo
    products_by_type = defaultdict(list)
    for product_id in product_ids:
        product_type = infer_product_type(product_id)
        products_by_type[product_type].append(product_id)
    
    # Selecionar tipos de produtos baseado nos pesos
    types = list(type_weights.keys())
    weights = [type_weights[t] for t in types]
    
    selected_products = []
    for _ in range(min(20, len(product_ids))):  # Limitar a 20 produtos por comanda
        selected_type = random.choices(types, weights=weights, k=1)[0]
        if products_by_type[selected_type]:
            selected_products.append(random.choice(products_by_type[selected_type]))
    
    return selected_products

def generate_insert_scripts(num_inserts=5000, filename="inserts.sql"):
    """
    Gera e salva os scripts de insert agrupados.
    """
    products = get_products_from_db()
    if not products:
        return None, None
        
    product_ids = list(products.keys())
    # NOVA LISTA DE FORMAS DE PAGAMENTO INCLUINDO 'vale alimentação'
    formas_pagamento = ['pix', 'dinheiro', 'cartao de credito', 'cartao de debito', 'vale alimentacao']
    # NOVA DISTRIBUIÇÃO DE PESOS PARA REFLETIR AS PROBABILIDADES
    formas_pagamento_weights = [0.4, 0.25, 0.2, 0.1, 0.05]
    
    current_comanda_id, current_item_comanda_id = find_last_ids(filename)
    
    print(f"Iniciando a partir de id_comanda: {current_comanda_id + 1}")
    print(f"Iniciando a partir de id_item_comanda: {current_item_comanda_id + 1}")
    
    comanda_values = []
    item_comanda_values = []
    
    start_date = datetime(2020, 1, 1)  # Data mais recente
    end_date = datetime(2025, 9, 16)

    # DEBUG: Contador de horas para verificar distribuição
    hour_distribution = {hour: 0 for hour in range(6, 22)}
    
    for i in range(1, num_inserts + 1):
        id_comanda = current_comanda_id + i
        
        # Gerar horário realista para abertura da comanda
        data_abertura = generate_realistic_time(start_date, end_date)
        hour = data_abertura.hour
        is_weekend = data_abertura.weekday() >= 5
        
        # DEBUG: Contar distribuição de horas
        hour_distribution[hour] += 1
        
        # Definir tempo de permanência baseado no horário e dia da semana
        if is_weekend:
            max_duration = random.randint(10, 45)
        else:
            if hour < 9:
                max_duration = random.randint(5, 15)
            elif hour < 12:
                max_duration = random.randint(10, 25)
            else:
                max_duration = random.randint(15, 30)
        
        # Calcular horário de fechamento
        data_fechamento = data_abertura + timedelta(minutes=max_duration)
        
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
        # SELEÇÃO DA FORMA DE PAGAMENTO COM OS NOVOS PESOS
        forma_pagamento = random.choices(formas_pagamento, weights=formas_pagamento_weights, k=1)[0]
        id_funcionario = random.randint(1, 10)
        
        comanda_values.append(
            f"({id_comanda}, {id_funcionario}, '{data_abertura_str}', '{hora_abertura_str}', '{data_fechamento_str}', '{hora_fechamento_str}', '{status}', '{forma_pagamento}')"
        )
        
        # Determinar número de itens baseado no horário e dia da semana
        if is_weekend:
            num_items = random.choices([1, 2, 3, 4, 5, 6], weights=[0.05, 0.15, 0.25, 0.25, 0.2, 0.1], k=1)[0]
        else:
            if hour < 9:
                num_items = random.choices([1, 2, 3], weights=[0.6, 0.3, 0.1], k=1)[0]
            elif hour < 12:
                num_items = random.choices([1, 2, 3, 4], weights=[0.3, 0.3, 0.25, 0.15], k=1)[0]
            else:
                num_items = random.choices([1, 2, 3, 4, 5], weights=[0.2, 0.25, 0.25, 0.2, 0.1], k=1)[0]
        
        # Selecionar produtos para esta compra baseado no horário
        available_products = get_products_for_time(hour, product_ids)
        num_items = min(num_items, len(available_products))
        
        selected_products = random.sample(available_products, num_items)
        
        for product_id in selected_products:
            current_item_comanda_id += 1
            
            product_type = infer_product_type(product_id)
            quantidade = get_quantity_for_product_type(product_type)
            
            price = products[product_id]
            total_item = quantidade * price
            
            # Observações realistas
            if product_type == "pao":
                observacoes = ["Nenhuma observacao", "Bem passado", "Mais crocante", "Sem gergelim", "Com gergelim"]
            elif product_type == "bolo":
                observacoes = ["Nenhuma observacao", "Fatia grande", "Com cobertura extra", "Sem cobertura"]
            elif product_type == "salgado":
                observacoes = ["Nenhuma observacao", "Quente", "Bem frito", "Sem pimenta"]
            elif product_type == "bebida":
                observacoes = ["Nenhuma observacao", "Gelada", "Sem gelo", "Com gelo extra"]
            else:
                observacoes = ["Nenhuma observacao", "Embrulhar para presente"]
                
            observacao = random.choices(observacoes, weights=[0.8] + [0.2/(len(observacoes)-1)]*(len(observacoes)-1), k=1)[0]
            
            item_comanda_values.append(
                f"({current_item_comanda_id}, {id_comanda}, {product_id}, {quantidade}, '{observacao}', {total_item:.2f})"
            )

    # DEBUG: Mostrar distribuição de horas
    print("\nDistribuição de vendas por hora:")
    for hour in range(6, 22):
        count = hour_distribution[hour]
        percentage = (count / num_inserts) * 100
        print(f"{hour:02d}h: {count} vendas ({percentage:.1f}%)")
    
    return comanda_values, item_comanda_values

def save_inserts_to_file(filename="inserts.sql"):
    """
    Função principal para lidar com as operações de arquivo.
    """
    numero_de_inserts_desejado = 7000
    
    print(f"Gerando {numero_de_inserts_desejado} inserts agrupados e salvando em '{filename}'...")
    comanda_values, item_comanda_values = generate_insert_scripts(num_inserts=numero_de_inserts_desejado, filename=filename)
    
    if comanda_values is None or item_comanda_values is None:
        return

    mode = 'a' if os.path.exists(filename) else 'w'
    with open(filename, mode, encoding='utf-8') as f:
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