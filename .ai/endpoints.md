# Endpoints - MovingPay SDK

## Regra geral

- Um endpoint novo deve seguir o padrão da API já existente.
- Se o recurso já existir em `src/Apis`, adicionar o método à classe correspondente.
- Se for um novo grupo de recursos, criar uma classe em `src/Apis` e expô-la no `Client`.
- Métodos de endpoint devem retornar `HttpClient\Message\Response`.
- Preservar nomes em português quando o domínio existente já seguir esse padrão.

## Definição do endpoint

Antes de implementar, confirmar:

- método HTTP;
- path relativo à base URI;
- parâmetros obrigatórios e opcionais;
- localização dos parâmetros: path, query ou body;
- formato da resposta;
- DTO esperado, quando aplicável.

Se alguma dessas informações não estiver disponível, solicitá-la antes de inferir o contrato.

## Consultas

- Usar `GET` para listagens e consultas.
- Enviar filtros por `RequestOptions::QUERY`.
- Tipar filtros opcionais com array shape no PHPDoc.
- O SDK monta a query string automaticamente a partir do array informado.

Exemplo:

```php
/**
 * @param array{
 *     page?: int,
 *     limit?: int
 * } $filters
 */
public function todos(array $filters = []): Response
{
    return $this->httpClient->get('/recursos', [
        RequestOptions::QUERY => $filters,
    ]);
}
```

## Requisições com corpo

- Usar `POST`, `PUT`, `PATCH` ou `DELETE` conforme o contrato da API.
- Enviar o corpo por `RequestOptions::BODY`, seguindo o padrão atual do SDK.
- Não definir manualmente `Authorization` ou `Customer`; esses headers são responsabilidade do `AuthenticationPlugin`.

## Respostas

- Encapsular respostas em `HttpClient\Message\Response`.
- Para estruturas conhecidas, criar DTOs e configurar o mapeamento com `setResponseDto(FQCN::class)`.
- Conferir o envelope real da resposta, incluindo paginação e nome da propriedade da coleção.
- Não assumir que exemplos de documentação representam os tipos reais retornados em produção.

## Checklist

- Método HTTP e path estão corretos.
- Parâmetros obrigatórios e opcionais estão tipados e documentados.
- Query e body usam a opção de requisição adequada.
- Headers de autenticação não foram duplicados no endpoint.
- Resposta está associada ao DTO correto.
- Nova API pública foi exposta no `Client`, quando necessário.
- Compatibilidade com os métodos existentes foi preservada.
