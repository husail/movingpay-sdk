# Endpoints - MovingPay SDK

## Regra geral

- Um endpoint novo deve seguir o padrão da API já existente.
- Se o recurso já existir em `src/Apis`, adicionar método na classe correspondente.
- Se for um novo grupo de endpoints, criar nova classe em `src/Apis` e expor no `Client`.

## Consultas

- Use `GET` para listagem/consulta.
- Filtros vão em `RequestOptions::QUERY`.
- Prefira arrays tipados no PHPDoc quando houver filtros opcionais.

## Mutação

- Use `POST`, `PUT`, `PATCH` ou `DELETE` conforme a documentação.
- Corpo da requisição vai em `RequestOptions::BODY` ou `RequestOptions::JSON` quando aplicável ao padrão do projeto.

## Respostas

- Sempre que a resposta tiver estrutura conhecida, crie DTO.
- Use `->setResponseDto(FQCN::class)` para mapear a resposta.

## Checklist por endpoint

- path correto
- método HTTP correto
- headers corretos
- filtros e corpo documentados
- DTO de resposta criado
- método exposto no `Client` se necessário
