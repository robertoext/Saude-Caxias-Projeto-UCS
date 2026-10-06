-- Saúde Caxias - Estrutura simples do banco
-- Execute este script dentro do banco "saude_caxias".

DROP TABLE IF EXISTS dados_notificacao;
DROP TABLE IF EXISTS localidade;
DROP TABLE IF EXISTS doenca;

CREATE TABLE doenca (
    id_doenca SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    categoria VARCHAR(100),
    descricao TEXT
);

CREATE TABLE localidade (
    id_localidade SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    codigo_ibge CHAR(7) NOT NULL UNIQUE
);

CREATE TABLE dados_notificacao (
    id_registro SERIAL PRIMARY KEY,
    id_doenca INT NOT NULL REFERENCES doenca(id_doenca),
    id_localidade INT NOT NULL REFERENCES localidade(id_localidade),
    ano INT NOT NULL CHECK (ano BETWEEN 2007 AND 2100),
    mes INT CHECK (mes BETWEEN 1 AND 12),
    casos_notificados INT CHECK (casos_notificados >= 0),
    casos_confirmados INT CHECK (casos_confirmados >= 0),
    obitos INT CHECK (obitos >= 0),
    fonte_dados VARCHAR(150) NOT NULL DEFAULT 'Dados simulados - fonte prevista DATASUS/SINAN',
    CONSTRAINT chk_algum_caso CHECK (casos_notificados IS NOT NULL OR casos_confirmados IS NOT NULL),
    CONSTRAINT uq_registro_periodo UNIQUE (id_doenca, id_localidade, ano, mes)
);

CREATE INDEX idx_notificacao_doenca ON dados_notificacao(id_doenca);
CREATE INDEX idx_notificacao_periodo ON dados_notificacao(ano, mes);
