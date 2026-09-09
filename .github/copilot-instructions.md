# Copilot Instructions - MovingPay SDK

Leia também `AGENTS.md` na raiz do projeto e os arquivos complementares em `.ai/`.

Resumo rápido:

- SDK PHP 8.1 com PSR-7/17/18.
- `Client` é o ponto de entrada.
- `src/Apis` contém os recursos HTTP.
- `src/Dtos` contém os objetos de resposta.
- Endpoints de consulta normalmente usam `GET` + `RequestOptions::QUERY`.
- Respostas mapeadas usam `Response::setResponseDto()`.

Antes de alterar código:

1. Identifique o endpoint e a resposta.
2. Siga o padrão já usado no SDK.
3. Atualize o `Client` se surgir um novo recurso público.
4. Valide com lint/build.
