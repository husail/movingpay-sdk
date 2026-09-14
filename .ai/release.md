# Releases - MovingPay SDK

## Formato geral

- Escrever as release notes em inglês.
- Usar Markdown e manter a mesma estrutura das releases anteriores.
- Informar versão, data, branch e tag no início do documento.
- Resumir no primeiro parágrafo o objetivo e as principais alterações da versão.
- Incluir apenas seções aplicáveis à release.

## Cabeçalho

Usar o seguinte formato:

```markdown
# 🚀 Release Notes: vX.Y.Z-alpha

**Release Date**: Month D, YYYY  
**Branch**: main  
**Tag**: vX.Y.Z-alpha

This `vX.Y.Z-alpha` release ...
```

## Seções de alterações

Usar uma ou mais destas seções, conforme o conteúdo da release:

- `## ✨ Features` para novas funcionalidades.
- `## 🐛 Fixes` para correções comuns.
- `## 🐛 Hotfix` para uma release dedicada a uma correção urgente.

Dentro de cada seção:

- Agrupar alterações por recurso com um item em negrito.
- Descrever os detalhes em subitens objetivos.
- Usar listas aninhadas quando for necessário enumerar filtros, campos ou comportamentos.
- Descrever o efeito para quem utiliza o SDK, evitando detalhes internos sem relevância pública.

Exemplo:

```markdown
## 🐛 Fixes

* **Resource Response**
  * Corrected the response mapping to match the API payload.
  * Added pagination metadata:
    * Total records
    * Current page
```

## Notas adicionais

Finalizar com:

```markdown
## 💡 Additional Notes

This release ...

No breaking changes were introduced.
```

- Resumir o impacto geral da versão nessa seção.
- Declarar explicitamente se existem breaking changes.
- Usar `No breaking changes were introduced.` somente quando a compatibilidade pública tiver sido preservada.
- Se houver breaking changes, descrevê-las claramente e incluir as ações de migração necessárias.

## Checklist

- Versão do título e da tag são idênticas.
- Data está em inglês no formato `Month D, YYYY`.
- Branch corresponde à branch da release.
- Categorias refletem corretamente features, fixes ou hotfixes.
- Alterações estão descritas do ponto de vista de quem usa o SDK.
- Breaking changes foram avaliadas e declaradas corretamente.
- Texto segue o estilo e a estrutura das releases anteriores.
