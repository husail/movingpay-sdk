# DTOs - MovingPay SDK

## Regra geral

- DTOs ficam em `src/Dtos/<Recurso>`.
- Cada DTO deve estender `Husail\MovingPay\Dtos\BaseDto`.
- Usar propriedades públicas com tipos explícitos.
- DTOs devem representar o payload real da API e não conter regras de negócio.
- Manter cada DTO pequeno e focado no mapeamento de uma estrutura.

## Nomes e mapeamento

- Preferir os nomes retornados pela API quando ela já usa camelCase.
- Representar chaves em snake_case como propriedades camelCase, seguindo o padrão existente.
- `BaseDto::fromArray()` aplica `camelCaseKeys()`, permitindo, por exemplo:
  - `created_at` → `createdAt`;
  - `per_page` → `perPage`.
- Não renomear semanticamente uma chave da API sem um mecanismo explícito de mapeamento.
- Conferir sempre o nome real dos envelopes e coleções, como `data`, `items` ou outro valor retornado.

## Tipos

- Tipar propriedades conforme os valores efetivamente retornados pela API.
- Códigos numéricos retornados como texto devem permanecer `string` quando zeros à esquerda ou representação exata forem relevantes.
- Usar tipos nullable (`?string`, `?int`, etc.) somente quando o campo puder ser nulo.
- Usar `\DateTimeImmutable` para datas e timestamps mapeados.
- Os formatos de data suportados pelo mapper incluem:
  - `DateTimeInterface::ATOM`;
  - `Y-m-d\TH:i:s.v\Z`;
  - `Y-m-d H:i:s`;
  - `Y-m-d`.

O mapper permite casting flexível e ignora chaves adicionais, mas isso não substitui a definição correta dos campos obrigatórios e dos tipos do DTO.

## Coleções

- Declarar propriedades de coleção como `array`.
- Informar o tipo dos itens por PHPDoc para que o Valinor crie os DTOs internos.

Exemplo:

```php
/** @var FooDto[] */
public array $data;
```

## Respostas paginadas

- Representar o envelope exato retornado pela API.
- Incluir os metadados presentes no payload, normalmente:
  - `total`;
  - `perPage`;
  - `page`;
  - `lastPage`;
  - `data`.
- Usar um DTO para o envelope paginado e outro para cada item da coleção.
- Seguir a convenção de nomes já adotada no recurso, como `FooPaginacaoDto` ou `FooResponseDto`, evitando renomeações públicas desnecessárias.

## Integração com a resposta

- Configurar o DTO no endpoint com `setResponseDto(FQCN::class)`.
- O consumidor obtém o objeto mapeado por `Response::object()`.
- Validar o mapeamento com um payload representativo da resposta real.

## Checklist

- Namespace e diretório correspondem ao recurso.
- DTO estende `BaseDto`.
- Todas as propriedades possuem tipos explícitos.
- Nomes correspondem às chaves reais após a conversão para camelCase.
- Campos opcionais ou nulos estão corretamente representados.
- Datas usam um tipo e formato aceitos pelo mapper.
- Coleções possuem PHPDoc com o tipo dos itens.
- Envelope de paginação corresponde ao corpo real da resposta.
- Mapeamento foi validado com dados representativos.
