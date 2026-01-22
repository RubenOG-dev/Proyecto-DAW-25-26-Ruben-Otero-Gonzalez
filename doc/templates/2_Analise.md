# Requerimientos do sistema

- [Requerimientos do sistema](#requerimientos-do-sistema)
  - [1- Descrición Xeral](#1--descrición-xeral)
  - [2- Funcionalidades](#2--funcionalidades)
  - [3- Tipos de usuarios](#3--tipos-de-usuarios)
  - [4- Contorno operacional](#4--contorno-operacional)
  - [5- Normativa](#5--normativa)
  - [6- Melloras futuras](#6--melloras-futuras)


## 1- Descrición Xeral

O proxecto consiste nunha plataforma web orientada a afeccionados aos videoxogos, na que se poderá consultar información actualizada de xogos, descubrir novos títulos e realizar valoracións por parte da comunidade.

A aplicación obterá os datos principais dos videoxogos (título, descrición, xénero, plataformas, datas de lanzamento, imaxes e valoracións base) a través da API externa RAWG, o que garante información actualizada e fiable procedente dunha base de datos amplamente utilizada no sector.

As valoracións e opinións dos videoxogos serán xeradas polos propios usuarios da plataforma, promovendo a participación activa da comunidade e a interacción entre xogadores. Este enfoque permite diferenciar GameMatcher doutras plataformas centradas unicamente na crítica profesional, apostando por unha visión máis próxima e representativa das preferencias reais dos usuarios.

O sistema desenvolverase como unha aplicación web con backend en PHP seguindo o patrón MVC e cunha base de datos MySQL para a xestión de usuarios, valoracións e contido propio.

## 2- Funcionalidades

A continuación descríbense as principais funcionalidades do sistema, indicando os actores implicados e o proceso realizado en cada caso:

| Acción | Descrición |
|------|------------|
| Consulta e presentación de videoxogos | O usuario pode visualizar un catálogo de videoxogos obtidos da API RAWG, con información detallada de cada título. |
| Busca e filtrado | O usuario pode buscar xogos por nome e aplicar filtros (xénero, plataforma, valoración, etc.). |
| Rexistro de usuarios | Un visitante pode crear unha conta proporcionando os datos necesarios, que se almacenan na base de datos. |
| Inicio de sesión | Un usuario rexistrado pode autenticarse para acceder ás funcionalidades avanzadas. |
| Eliminación de usuario | Un usuario rexistrado pode eliminar a súa propia conta. |
| Valoración de videoxogos | O usuario rexistrado pode puntuar e escribir opinións sobre os videoxogos. |
| Xestión de valoracións | O usuario pode editar ou eliminar as súas propias valoracións. |
| Xestión do foro | O usuario rexistrado pode crear, modificar e eliminar comentarios nos foros da comunidade. |
| Panel de administración | O administrador pode xestionar usuarios e moderar contido inapropiado. |

Cada funcionalidade implica datos de entrada (accións do usuario, formularios ou seleccións) e datos de saída (información mostrada por pantalla, mensaxes de confirmación ou erro), procesados polo backend seguindo a lóxica do sistema.

## 3- Tipos de usuarios

O sistema contará cos seguintes tipos de usuarios:

- **Usuario anónimo**: pode acceder á páxina principal e consultar información básica dos videoxogos, pero non pode valorar nin comentar.
- **Usuario rexistrado**: pode iniciar sesión, realizar valoracións, escribir opinións e xestionar o seu perfil.
- **Administrador**: ten acceso ás funcionalidades de xestión e moderación, podendo controlar usuarios e contido xerado na plataforma.

## 4- Contorno operacional

Para o uso da aplicación web, o usuario necesitará:

- Un dispositivo con navegador web actualizado (Chrome, Firefox, Edge, Safari, etc.).
- Conexión a internet estable.

Non será necesario ningún hardware nin software adicional máis alá dun navegador compatible.

## 5- Normativa

GameMatcher, como aplicación web que recolle e xestiona datos persoais de usuarios rexistrados, cumprirá coa normativa vixente en materia de protección de datos, en particular coa [Lei Orgánica 3/2018, de Protección de Datos Persoais e garantía dos dereitos dixitais (LOPDPGDD)](https://www.boe.es/buscar/act.php?id=BOE-A-2018-16673), así como co [Regulamento Xeral de Protección de Datos (GDPR)](https://eur-lex.europa.eu/eli/reg/2016/679/oj) a nivel europeo.

A plataforma incluirá os correspondentes apartados legais accesibles desde a web: aviso legal, política de privacidade e política de cookies. O usuario deberá aceptar a política de privacidade no momento do rexistro, sendo informado da finalidade do tratamento dos seus datos, que se limitará exclusivamente ao funcionamento da aplicación (xestión de contas, valoracións e participación na comunidade).

O responsable do tratamento dos datos será GameMatcher, garantindo en todo momento os dereitos de acceso, rectificación, cancelación e eliminación dos datos persoais por parte dos usuarios.

## 6- Melloras futuras

En futuras versións de *GameMatcher* **poderán incorporarse** funcionalidades sociais avanzadas, como o seguimento doutros usuarios ou a interacción mediante comentarios nas valoracións. Ademais, está prevista a posible integración de sistemas baseados en intelixencia artificial orientados á recomendación personalizada de videoxogos segundo os gustos, hábitos e valoracións previas dos usuarios, podendo ofrecer estas funcionalidades avanzadas como un servizo diferencial para usuarios premium, incrementando así o valor engadido da plataforma e as súas vías de monetización.

[**<-Anterior**](../../README.md)
