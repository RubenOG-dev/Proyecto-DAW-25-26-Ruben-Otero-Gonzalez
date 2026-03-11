# FASE DE CODIFICACIÓN E PROBAS

- [FASE DE CODIFICACIÓN E PROBAS](#fase-de-codificación-e-probas)
  - [1- Codificación](#1--codificación)
  - [2- Prototipos](#2--prototipos)
  - [3- Innovación](#3--innovación)
  - [4- Probas](#4--probas)

> Este documento explica como se debe realizar a fase de codificación e probas.

## 1- Codificación

[Código](/GameMatcher/)

## 2- Prototipos

[Enlace a Prototipo en Figma](https://www.figma.com/design/zZixQwAAGmkDk2Xc79SOiO/GameMatcher?node-id=2-27&t=hcmXhg3YDC0xTb4U-1)

## 3- Innovación

Vou facer uso de bootstrap nos formularios de rexistro e inicio de sesión.
>
Uso de sistemas de notificacións persistentes mediante clases CSS animadas para confirmar accións do usuario como o rexistro exitoso ou erros de validación.
>
Uso de animacións de carga con js e css para mellorar a percepción de velocidade de carga

## 4- Probas

Probase o envío de mensaxes vacíos no botchat: o bot non responde a mensaxes sen texto.
>
Corrección: engadir unha validación no script bot.js para que o botón de enviar so actúe se o campo input ten contido.
>
Próbase o cerre do chat, funciona correctamente.
>
O Formulario de rexistro impide o rexistro dun usuario se ese email xa se atopa na base de datos
>
Detectouse un erro ao intentar valorar un xogo que ainda non existía na base de datos propia.
>
Enviaronse comentarios no foro con caracteres especiais os cales agora son correxidos con htmlspecialchars()
>
Implementouse logo dun erro durante a eliminación dun fio no foro a eliminación dos comentarios asociados a dito fio facendo uso da clave foranea mais ON DELETE CASCADE en MYSQL.



[**<-Anterior**](../../README.md)
