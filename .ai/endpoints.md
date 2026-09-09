# Architecture - MovingPay SDK

## Visão geral

O SDK segue uma arquitetura simples:

- `Client` expõe os recursos públicos.
- `src/Apis` concentra as chamadas HTTP por domínio.
- `src/Dtos` concentra os objetos de resposta.
- `src/HttpClient` concentra a infraestrutura HTTP e plugins.

## Camadas

### Entrada pública

- `Husail\MovingPay\Client`
- Instancia o cliente HTTP e expõe as APIs como propriedades readonly.

### APIs

- Classes em `src/Apis` representam domínios da API.
- Cada método da API corresponde a um endpoint.
- Métodos retornam `HttpClient\Message\Response`.

### HTTP

- `HttpClient\Builder` monta o cliente com plugins.
- `HttpMethodsClient` encapsula `sendRequest` com métodos de alto nível.
- Plugins cuidam de base URI, headers, auth e logging.

### DTOs

- `BaseDto` é a base para mapeamento com Valinor.
- DTOs representam payloads de resposta da API.

## Fluxo de uma requisição

1. `Client` cria ou recebe o `HttpMethodsClient`.
2. A classe de API chama `get/post/put/...`.
3. O `HttpMethodsClient` monta a requisição PSR-7.
4. O `Psr\Http\Client\ClientInterface` envia a requisição.
5. A resposta é embrulhada por `HttpClient\Message\Response`.
6. `setResponseDto()` habilita o mapeamento para DTO.

## Regras de extensão

- Não quebrar a API pública sem necessidade.
- Sempre preferir reaproveitar a classe de API existente antes de criar outra.
- Criar DTO novo apenas quando a estrutura da resposta exigir.
- Manter o uso de discovery PSR-17/18.

## Decisões importantes do projeto

- Autenticação é aplicada por plugin.
- Base URI é fixa para `https://api.movingpay.com.br/api/v3`.
- Respostas são orientadas a JSON.
- O SDK privilegia simplicidade e mapeamento direto de payload.
