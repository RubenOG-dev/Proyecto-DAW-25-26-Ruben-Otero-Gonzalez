# Requerimientos do sistema

- [Requerimientos do sistema](#requerimientos-do-sistema)
  - [1- Descrición Xeral](#1--descrición-xeral)
  - [2- Funcionalidades](#2--funcionalidades)
  - [3- Tipos de usuarios](#3--tipos-de-usuarios)
  - [4- Contorno operacional](#4--contorno-operacional)
  - [5- Normativa](#5--normativa)
  - [6- Melloras futuras](#6--melloras-futuras)

> *EXPLICACION*: Este documento describe os requirimentos para "nome do proxecto" especificando que funcionalidade ofrecerá e de que xeito.

## 1- Descrición Xeral

>*EXPLICACION*: Descrición Xeral do proxecto

O proxecto consiste nunha plataforma web orientada a afeccionados aos videoxogos, na que se poderá consultar información actualizada de xogos, descubrir novos títulos e realizar valoracións por parte da comunidade.

A aplicación obterá os datos principais dos videoxogos (título, descrición, xénero, plataformas, datas de lanzamento, imaxes e valoracións base) a través da API externa RAWG, o que garante información actualizada e fiable procedente dunha base de datos amplamente utilizada no sector.

As valoracións e opinións dos videoxogos serán xeradas polos propios usuarios da plataforma, promovendo a participación activa da comunidade e a interacción entre xogadores. Este enfoque permite diferenciar GameMatcher doutras plataformas centradas unicamente na crítica profesional, apostando por unha visión máis próxima e representativa das preferencias reais dos usuarios.

O sistema desenvolverase como unha aplicación web con backend en PHP seguindo o patrón MVC e cunha base de datos MySQL para a xestión de usuarios, valoracións e contido propio.

## 2- Funcionalidades

>*EXPLICACION* Describir que servizos ou operacións se van poder realizar por medio do noso proxecto, indicando que actores interveñen en cada caso.
>
> Enumeradas, de maneira que na fase de deseño poidamos definir o diagrama ou configuración correspondente a cada funcionalidade.
> Cada función ten uns datos de entrada e uns datos de saída. Entre os datos de entrada e de saída, realízase un proceso, que debe ser explicado.

Exemplo:

| Acción   |  Descrición        |
|----------|--------------------|
| Alta de productos   | Dar de alta os productos na base de datos|
| Modificar productos | Modificación de productos na base de datos|
| Presentación dos productos  | Mostra dos productos por medio da páxina web |


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

> *EXPLICACION* Describir os tipos de usuario que poderán acceder ao noso sistema. Habitualmente os tipos de usuario veñen definidos polas funcionalidades ás cales teñen acceso. En termos xerais existen moitos grupos de usuarios: anónimos, novos, rexistrados, bloqueados, confirmados, verificados, administradores, etc.
>
> Exemplo:
>
> - Usuario xenérico, que terá acceso a ...
> - Usuario técnico, que poderá...

O sistema contará cos seguintes tipos de usuarios:

- **Usuario anónimo**: pode acceder á páxina principal e consultar información básica dos videoxogos, pero non pode valorar nin comentar.
- **Usuario rexistrado**: pode iniciar sesión, realizar valoracións, escribir opinións e xestionar o seu perfil.
- **Administrador**: ten acceso ás funcionalidades de xestión e moderación, podendo controlar usuarios e contido xerado na plataforma.

## 4- Contorno operacional

> *EXPLICACION* Neste apartado deben describirse os recursos necesarios, dende o punto de vista do usuario, para poder operar coa aplicación web. Habitualmente consiste nun navegador web actualizado e unha conexión a internet.
Se é necesario algún hardware ou software adicional, deberá indicarse.

Para o uso da aplicación web, o usuario necesitará:

- Un dispositivo con navegador web actualizado (Chrome, Firefox, Edge, Safari, etc.).
- Conexión a internet estable.

Non será necesario ningún hardware nin software adicional máis alá dun navegador compatible.

## 5- Normativa

> *EXPLICACION* Investigarase que normativa vixente afecta ao desenvolvemento do proxecto e de que maneira. O proxecto debe adaptarse ás esixencias legais dos territorios onde vai operar.

GameMatcher, como aplicación web que recolle e xestiona datos persoais de usuarios rexistrados, cumprirá coa normativa vixente en materia de protección de datos, en particular coa [Lei Orgánica 3/2018, de Protección de Datos Persoais e garantía dos dereitos dixitais (LOPDPGDD)](https://www.boe.es/buscar/act.php?id=BOE-A-2018-16673), así como co [Regulamento Xeral de Protección de Datos (GDPR)](https://eur-lex.europa.eu/eli/reg/2016/679/oj) a nivel europeo.

A plataforma incluirá os correspondentes apartados legais accesibles desde a web: aviso legal, política de privacidade e política de cookies. O usuario deberá aceptar a política de privacidade no momento do rexistro, sendo informado da finalidade do tratamento dos seus datos, que se limitará exclusivamente ao funcionamento da aplicación (xestión de contas, valoracións e participación na comunidade).

O responsable do tratamento dos datos será GameMatcher, garantindo en todo momento os dereitos de acceso, rectificación, cancelación e eliminación dos datos persoais por parte dos usuarios.

## 6- Melloras futuras

> *EXPLICACION* É posible que o noso proxecto se centre en resolver un problema concreto que se poderá ampliar no futuro con novas funcionalidades, novas interfaces, etc.

[**<-Anterior**](../../README.md)
