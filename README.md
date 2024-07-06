
# Transaction API

A API transaction-hyperf faz de maneira simplificada uma transação entre duas pessoas, atualizando devidamente suas carteiras, enviando notificações e também é realizada uma validação externa para a autorização da transação (Mock).



## Instalação/Configuração

Faça o clone o projeto em seu computador

```bash
  git clone git@github.com:dieg0rood/api-transaction-hyperf.git
```

Na pasta do projeto faça o build do container

```bash
  docker-compose build --no-cache
```

Verifique se o container está rodando

```bash
  docker ps
```

Caso não esteja dê o start

```bash
  docker-composer up -d
```

Acesse o bash do container, instale as dependencias do projeto

```bash
  composer install
```

Renomeie o .env.example para .env e o projeto já estará totalmente configurado
    
## Stack utilizada

**Back-end:** Php 8.2 - Framework HyperF

Implementações e Justificativas:

- **Repository**: Menor acoplamento ao ORM utilizado 
- **Resource**: Redução de acomplamento e padronização de retorno de dados de serviços.
- **Testes Unitários**: Testes realizados pelo plugin disponibilizado no skeleton do projeto hyperf.
- **Exceptions**: Foram criadas exceptions e handlers personalizados em todo o projeto, dessa forma com o auxilio da documentação(swagger) e os códigos de erros mapeados + http codes, qualquer consumidor da API será capaz de identificar a origem do erro, além de permitir que os testes façam a validação especifica de cada exception disparada.
- **ExternalServices**: Pasta criada na raiz do app para armazenar de maneira separada requisições a serviços de terceiros, mantendo o diretório App\Services dedicado à serviços internos da API.
- **Validação Request**: Utilizado a validação do framework, similar a validação feita via FormRequest do Laravel.


## Rodando os testes

Para rodar os testes, rode o seguinte comando dentro do container

```bash
  composer test
```


## Roadmap

- Implementar Mocks nos testes, Adicionar testes nos serviços terceiros, caso de falha.

- Aumentar a utilização de Injeção de dependencias para reduzir a chamada de funções estáticas

- Padronizar a aplicação para trabalhar com valores em float (o objetivo inicial era trabalhar com valores como int, exemplo $10,00 = 1000). Reverter essa lógica.


## Documentação

[Documentação] Disponível em docs\openai.json

