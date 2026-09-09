# AGENTS Instructions - MovingPay SDK

Leia também os arquivos em `.ai/` para instruções específicas por tema.

## Context

- SDK PHP 8.1.
- Usa PSR-7, PSR-17 e PSR-18.
- Cliente base: `Husail\MovingPay\Client`.
- APIs ficam em `src/Apis`.
- DTOs ficam em `src/Dtos`.

## Padrão do projeto

- Cada recurso público deve ser exposto no `Client` como propriedade readonly.
- Cada grupo de endpoints deve ter uma classe em `src/Apis`.
- Cada resposta mapeada deve ter DTOs em `src/Dtos/<Recurso>`.
- Consultas usam `GET` com `RequestOptions::QUERY`.
- Requisições com corpo usam `RequestOptions::BODY`.
- Respostas são encapsuladas em `HttpClient\Message\Response`.

## Fluxo recomendado para novos endpoints

1. Identificar método HTTP, path e parâmetros.
2. Verificar se o endpoint pertence a uma API já existente ou se precisa de uma nova classe.
3. Criar DTO(s) da resposta.
4. Implementar o método na API correta.
5. Expor a API no `Client` se for um novo recurso público.
6. Validar com lint/build.

## Convenções

- Manter nomes em português quando o código atual já segue esse padrão.
- Preferir métodos como `todos()`, `visualizar()`, `parcelas()`, etc.
- Preferir tipagem explícita.
- Não alterar comportamento existente sem necessidade.
- Preservar compatibilidade com o padrão atual do SDK.

## Autenticação e headers

- O header `Authorization` e `Customer` são aplicados via `AuthenticationPlugin`.
- Em geral não é necessário setar esses headers manualmente nos endpoints.

## Observações importantes

- Query string é montada pelo SDK automaticamente a partir de arrays.
- O wrapper `Response` suporta `successful()`, `json()` e `object()`.
- Se a resposta precisar de DTO, usar `setResponseDto(FQCN::class)`.

## Checklist rápido antes de concluir uma alteração

- Código segue o padrão do SDK.
- DTOs estão no namespace correto.
- `Client` foi atualizado se necessário.
- Lint sem erros.
- Build/verificação do projeto concluída.

## Quando faltar informação da API

Pedir sempre:

- path do endpoint
- método HTTP
- parâmetros obrigatórios e opcionais
- formato da resposta
- nome esperado da API pública

## Arquivos complementares

- `.ai/architecture.md`
- `.ai/endpoints.md`
- `.ai/dtos.md`
- `.ai/release.md`
