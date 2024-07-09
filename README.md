
# Transaction API

A API transaction-hyperf faz de maneira simplificada uma transação entre duas pessoas, atualizando devidamente suas carteiras, enviando notificações e também é realizada uma validação externa para a autorização da transação, e para envio de notificações.

## Índice

- [Instalação](#instalação)
- [Arquitetura](#arquitetura)
- [Testes](#testes)
- [Documentação](#documentação)

## Instalação

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

- Renomeie o *.env.example* para *.env*
- Insira os dados do banco de dados no *.env*


## Arquitetura

**Back-end:** Php 8.2 - Framework HyperF

### Tecnologias

Visando a redução do acoplamento, código limpo e escalabilidade, o desenho do sistema teve como base a utlização de [DTO](https://en.wikipedia.org/wiki/Data_transfer_object), [Repository](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html) e [Resources](https://laravel.com/docs/8.x/eloquent-resources).

Onde possível também utilizei da [Injeção de dependencias](https://en.wikipedia.org/wiki/Dependency_injection) alinhado aos conceitos de [SOLID](https://en.wikipedia.org/wiki/SOLID) facilitando os testes e manutenibilidade.

## Testes

Para rodar os testes, rode o seguinte comando dentro do container

```bash
  composer test
```

## Documentação

Disponível em [OpenAPI](https://github.com/dieg0rood/api-transaction-hyperf/blob/main/doc/openapi.json)

## Sripts Fixers

```bash
  docker run -it --rm -v $(pwd):/api-transaction-hyperf -w /api-transaction-hyperf jakzal/phpqa phpmd app text cleancode,codesize,controversial,design,naming,unusedcode
```

```bash
  docker run -it --rm -v $(pwd):/api-transaction-hyperf ghcr.io/php-cs-fixer/php-cs-fixer:3.57-php8.2 fix /api-transaction-hyperf
```