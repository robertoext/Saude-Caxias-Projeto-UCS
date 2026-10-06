-- Saúde Caxias - Dados SIMULADOS para desenvolvimento e demonstração.
-- NÃO apresentar estes valores como estatísticas oficiais.

INSERT INTO localidade (nome, codigo_ibge)
VALUES ('Caxias do Sul', '4305108');

INSERT INTO doenca (nome, categoria, descricao) VALUES
('Dengue', 'Arbovirose', 'Doença viral transmitida principalmente pelo mosquito Aedes aegypti.'),
('Influenza', 'Respiratória', 'Infecção viral aguda do sistema respiratório.'),
('Covid-19', 'Respiratória', 'Doença infecciosa causada pelo coronavírus SARS-CoV-2.'),
('Sífilis', 'Infecção sexualmente transmissível', 'Infecção bacteriana que pode apresentar diferentes estágios clínicos.'),
('Tuberculose', 'Respiratória', 'Doença infecciosa causada por bactérias do complexo Mycobacterium tuberculosis.'),
('Hepatites Virais', 'Infecciosa', 'Grupo de infecções virais que afetam principalmente o fígado.'),
('Chikungunya', 'Arbovirose', 'Doença viral transmitida por mosquitos do gênero Aedes.'),
('Zika', 'Arbovirose', 'Doença viral transmitida principalmente por mosquitos Aedes.');

-- Gera 480 registros: 8 doenças x 5 anos x 12 meses.
-- Fórmulas determinísticas para facilitar a demonstração.
INSERT INTO dados_notificacao
(id_doenca, id_localidade, ano, mes, casos_notificados, casos_confirmados, obitos, fonte_dados)
SELECT
    d.id_doenca,
    l.id_localidade,
    a.ano,
    m.mes,
    ((d.id_doenca * 19 + (a.ano - 2019) * 13 + m.mes * 7) % 90) + 25 AS casos_notificados,
    ((d.id_doenca * 17 + (a.ano - 2019) * 11 + m.mes * 5) % 65) + 12 AS casos_confirmados,
    CASE WHEN d.id_doenca IN (1,3,5) THEN ((a.ano + m.mes + d.id_doenca) % 3) ELSE 0 END AS obitos,
    'Dados simulados - fonte prevista DATASUS/SINAN'
FROM doenca d
CROSS JOIN localidade l
CROSS JOIN generate_series(2020, 2024) AS a(ano)
CROSS JOIN generate_series(1, 12) AS m(mes);
