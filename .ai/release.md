# DTOs - MovingPay SDK

## Regra geral

- DTOs ficam em `src/Dtos/<Recurso>`.
- Cada DTO deve estender `Husail\MovingPay\Dtos\BaseDto`.
- Use propriedades públicas tipadas.

## Tipos e nomes

- Prefira nomes idênticos aos retornados pela API quando já estiverem consolidados no projeto.
- Se o retorno vier em camelCase, mantenha camelCase no DTO.
- Se o retorno vier em snake_case e já houver padrão no SDK, preserve o padrão existente.

## Resposta paginada

- Se a API retornar paginação, crie um DTO de resposta e um DTO da coleção.
- Exemplo esperado:
  - `FooResponseDto`
  - `FooPaginacaoDto`
  - `FooDto`

## Boas práticas

- Declarar arrays com PHPDoc quando houver coleção de DTOs.
- Não adicionar lógica de negócio no DTO.
- Manter DTOs pequenos e focados em mapeamento.
