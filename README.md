# geomob
Ponto Digital em PHP v0.5.0

## :globe_with_meridians: Sobre

Permite o usuário registrar a entrada e saída do ambiente, geralmente usado para registro da frequência de colaboradores numa empresa.

Consulte [Instalação](#instal) para saber como implantar o projeto.

### 📋 Pré-requisitos

Este código funciona independente, basta subir os arquivos para o servidor e construir a tabela "frequencia" no banco.



### 🔧 <a id="instal">Instalação</a>

Baixe os arquivos e copie para a sua pasta raiz no servidor web e execute o arquivo sql no seu banco de dados.


Ou se preferir, execute o código sql abaixo:

```
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
```

## ⚙️ Testando a aplicação

Acesse o seu localhost e registre sua entrada ou saída. Após você registrar sua saída, o sistema só permitirá um novo registro no dia seguinte.
Os horários de check-in/out são entre 8h e 12h (turno da manhã) e 13h e 17h (turno da tarde). Margem de atraso de 15min. e tolerância para checkout de 30min.

```

```


## 📦 Implementação 

Este módulo pode ser utilizado em conjunto com outros sistemas com a finalidade de registrar a frequência de colaboradores de empresas ou órgãos públicos.

## 🛠️ Construído com

Desenvolvido em PHP, Javascript, HTML5 e CSS utilizando BOOTSTRAP.


* [PHP](https://www.php.net/) - Linguagem server-side
* [Javascript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/) - Linguagem front-end
* [BOOTSTRAP](https://getbootstrap.com/) -  Bootstrap é um framework web com código-fonte aberto.


## 📌 Versão 0.5.0

Nós usamos [SemVer](http://semver.org/) para controle de versão.

## ✒️ Autores

Este projeto foi desenvolvido por Lincolemberg Canuto

* **Lincolemberg** - [umdesenvolvedor](https://github.com/lincolemberg)


## 📄 Licença

Este projeto está sob a licença (sua licença) - veja o arquivo [LICENSE.md](https://github.com/lincolemberg/) para detalhes.

## 🎁 Um café pra dois

* Compartilhe algo bom para as pessoas enquanto a cerveja está gelada 🍺 
* Obrigado 🤓

