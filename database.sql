CREATE TABLE IF NOT EXISTS public.frequencia
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 999999999 CACHE 1 ),
    nome_completo character varying,
    entrada character varying,
    dia character varying,
    mes character varying,
    ano character varying,
    saida character varying,
    atraso time with time zone,
    PRIMARY KEY (id)
);