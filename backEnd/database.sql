CREATE DATABASE pdv;

CREATE TABLE tipos_produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    percentual_imposto DECIMAL(10, 2)
);

CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco_custo DECIMAL(10, 2) NOT NULL,
    preco_venda DECIMAL(10, 2) NOT NULL,
    tipo_produto_id INT REFERENCES tipos_produtos(id) NOT NULL
);

CREATE TABLE vendas (
    id SERIAL PRIMARY KEY,
    data_venda TIMESTAMP NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    total_venda DECIMAL(10, 2) NOT NULL,
    desconto DECIMAL(10, 2)
);

CREATE TABLE itens_venda (
    id SERIAL PRIMARY KEY,
    venda_id INT REFERENCES vendas(id) NOT NULL,
    produto_id INT REFERENCES produtos(id) NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL
);