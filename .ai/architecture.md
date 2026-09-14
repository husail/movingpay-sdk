# Architecture - MovingPay SDK

## Visão geral

O SDK segue uma arquitetura simples:

- `Client` expõe os recursos públicos.
- `src/Apis` concentra as chamadas HTTP por domínio.
- `src/Dtos` concentra os objetos de resposta.
- `src/HttpClient` concentra a infraestrutura HTTP e os plugins.

## Camadas

### Entrada pública

- `Husail\MovingPay\Client` é a entrada pública do SDK.
- O cliente configura a infraestrutura HTTP e expõe as APIs como propriedades readonly.
- Cada novo recurso público deve ser inicializado e exposto no `Client`.

### APIs

- Classes em `src/Apis` representam domínios da API.
- Cada método público de uma API corresponde a um endpoint.
- As APIs recebem o cliente HTTP por meio de `AbstractApi`.
- Os métodos retornam `Husail\MovingPay\HttpClient\Message\Response`.

### HTTP

- `HttpClient\Builder` monta o cliente HTTP.
- `HttpMethodsClient` oferece métodos de alto nível para as requisições.
- O transporte segue PSR-7, PSR-17 e PSR-18.
- Plugins cuidam da base URI, autenticação, headers e logging.

### DTOs

- `BaseDto` centraliza o mapeamento com Valinor.
- DTOs representam payloads conhecidos retornados pela API.
- `Response::setResponseDto()` define o DTO usado por `Response::object()`.

## Fluxo de uma requisição

1. `Client` configura ou recebe as dependências HTTP.
2. O consumidor acessa uma API exposta pelo `Client`.
3. A classe de API executa `get()`, `post()`, `put()`, `patch()` ou `delete()`.
4. O cliente HTTP monta e envia uma requisição PSR-7 por um cliente PSR-18.
5. A resposta é encapsulada em `HttpClient\Message\Response`.
6. Quando configurado, `setResponseDto()` permite mapear o JSON para um DTO.

## Regras de extensão

- Não quebrar a API pública sem necessidade.
- Reaproveitar uma classe de API existente quando o endpoint pertencer ao mesmo domínio.
- Criar uma nova classe em `src/Apis` somente para um novo grupo de recursos.
- Expor novos recursos públicos como propriedades readonly no `Client`.
- Criar DTOs quando a estrutura conhecida da resposta exigir mapeamento.
- Preservar o uso das interfaces PSR adotadas pelo projeto.

## Decisões importantes

- A base URI padrão é `https://api.movingpay.com.br/api/v3`.
- Autenticação e headers de cliente são aplicados por `AuthenticationPlugin`.
- Logging é opcional e aplicado por `LoggerPlugin`.
- As respostas da API são orientadas a JSON.
- O SDK privilegia tipagem explícita e mapeamento direto dos payloads.
