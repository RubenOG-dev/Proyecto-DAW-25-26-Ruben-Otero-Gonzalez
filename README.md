# Proxecto fin de ciclo: GameMatcher

* [Taboleiro do proxecto](#taboleiro-do-proxecto)
* [Descrición](#descrición)
* [Instalación / Posta en marcha](#instalación--posta-en-marcha)
* [Uso](#uso)
* [Sobre o autor](#sobre-o-autor)
* [Licenza](#licenza)
* [Índice](#índice)
* [Guía de contribución](#guía-de-contribución)
* [Links](#links)

---

## Taboleiro do proxecto
**Estado:** En desenvolvemento.

---

## Descrición
**GameMatcher** nace como unha resposta á necesidade de moitos xogadores de atopar un espazo propio onde a información sobre videoxogos sexa accesible, clara e, sobre todo, compartida. O obxectivo principal deste proxecto é ofrecer unha plataforma que funcione como punto de encontro para a comunidade, permitindo que calquera persoa poida explorar un catálogo inmenso de títulos e interactuar con outros usuarios de xeito sinxelo.

O aspecto fundamental de GameMatcher é a súa capacidade para conectar cunha fonte de datos externa chamada **RAWG API**. Grazas a isto, o usuario non ten que buscar en diferentes webs: aquí pode ver imaxes, datas de lanzamento, requisitos técnicos e descricións de case calquera xogo existente no mercado. Pero a web non é só unha enciclopedia; é unha rede viva. Os usuarios rexistrados teñen a posibilidade de valorar os títulos segundo o seu criterio e participar nun foro de discusión, onde poden crear debates, resolver dúbidas ou compartir as súas experiencias.

Para construír esta plataforma, utilicei unha combinación de tecnoloxías modernas e estables. No "corazón" do sistema traballa **PHP** xunto cunha base de datos **MySQL**, que se encargan de xestionar toda a lóxica de usuarios, comentarios e puntuacións. No que respecta ao que o usuario ve e toca, empreguei **HTML5** e **CSS3** para crear un deseño visualmente atractivo e adaptable (que se ve igual de ben nun móbil que nun ordenador). Finalmente, incluín **JavaScript** para dar vida a elementos interactivos, como o carrusel de imaxes das fichas dos xogos, logrando que a navegación sexa fluída e dinámica.

---

## Instalación / Posta en marcha
Para poder despregar **GameMatcher** no teu equipo, o primeiro que necesitas é ter instalado un contorno de servidor local como **XAMPP** ou **Laragon** (que inclúa Apache, PHP e MySQL).

* **Se usas Windows:** Descarga e instala XAMPP ou Laragon. Unha vez instalado, asegúrate de iniciar os módulos de Apache e MySQL dende o seu panel de control.
* **Se usas Linux:** Abre a terminal e instala a pila LAMP cos comandos:
    ```bash
    sudo apt update && sudo apt upgrade
    sudo apt install apache2 php mysql-server php-mysql
    ```

Unha vez que o teu servidor local estea funcionando, clona o repositorio ou descarga o código dentro do cartafol correspondente (`htdocs` en XAMPP ou `www` en Laragon). 

O seguinte paso é configurar a persistencia de datos: accede a **phpMyAdmin** dende o teu navegador, crea unha nova base de datos chamada `gamematcher` e importa o ficheiro `gamematcher.sql` que atoparás dentro do cartafol `/database`. Finalmente, abre o arquivo `config.php` no teu editor de texto para introducir as túas credenciais de MySQL e a túa **API KEY de RAWG**. 

Con isto feito, ao buscar `localhost/GameMatcher` no teu navegador, xa deberías poder interactuar coa plataforma.

---

## Uso
O uso de **GameMatcher** está deseñado para que calquera afeccionado aos videoxogos poida xestionar a súa biblioteca ideal dende o primeiro minuto. A interface permite aos usuarios buscar títulos de forma dinámica, accedendo a fichas técnicas completas que inclúen dende requisitos de sistema ata galerías de imaxes en alta resolución grazas á integración con RAWG.

Os usuarios rexistrados poden interactuar directamente coa comunidade puntuando os seus xogos favoritos mediante un sistema de estrelas, o que axuda a xerar un ranking de popularidade en tempo real. Ademais, a plataforma conta cun foro dinámico onde se poden abrir fíos de discusión, compartir guías ou pedir axuda técnica. 

Actualmente, GameMatcher permite un control total sobre as achegas: cada usuario pode engadir, editar ou eliminar os seus propios comentarios nos foros, garantindo unha experiencia personalizada e segura. Todo isto preséntase baixo un deseño **responsive** que garante que poidas consultar as túas estatísticas ou debater sobre o último lanzamento tanto dende o teu ordenador como dende o teu móbil.

---

## Sobre o autor
Como creador de **GameMatcher**, son estudante de segundo ano do Ciclo Superior en Desenvolvemento de Aplicacións Web. Defínome como un programador versátil que se sente cómodo traballando en ambos ámbitos do desenvolvemento, tanto en *frontend* coma en *backend*. As miñas habilidades principais céntranse en **PHP e JavaScript**, linguaxes coas que teño maior familiaridade e que me permiten construír solucións robustas e interactivas dende cero. Así mesmo, conto con coñecementos sólidos en **Laravel, HTML5 e CSS3**, xunto con experiencia práctica no uso de **jQuery** e a xestión de contidos en **WordPress**.

A idea de GameMatcher nace da necesidade de ofrecer unha experiencia máis limpa e especializada para o xogador, creando comunidades de nicho máis próximas e eficientes nun sector en constante expansión como é o do lecer dixital. 

Para calquera consulta ou colaboración, podes contactar comigo a través do meu perfil de GitHub ou mediante o correo electrónico: [rubenog.dev@gmail.com](mailto:rubenog.dev@gmail.com).

---

## Licenza
Podes consultar os termos legais no ficheiro: [LICENSE](LICENSE.md)

---

## Índice
1. [Anteproyecto](doc/templates/1_Anteproxecto.md)
2. [Análise](doc/templates/2_Analise.md)
3. [Deseño](doc/templates/3_Deseño.md)
4. [Codificación e probas](doc/templates/4_Codificacion_e_probas.md)
5. [Implantación](doc/templates/5_Implantación.md)
6. [Referencias](doc/templates/6_Referencias.md)
7. [Incidencias](doc/templates/7_Incidencias.md)

---

## Guía de contribución
Se che gusta a idea de GameMatcher e queres contribuír ao seu desenvolvemento, podes comezar ampliando a lóxica do *backend* creando o modelo e o controlador para a xestión de **Listas de Desexos (Wishlists)**, ou ben mellorando o sistema de **Valoracións** para que admita comentarios extensos vinculados ás estrelas.

Outras áreas nas que podes colaborar son a implementación dun sistema de perfil de usuario avanzado que se cargue cando un xogador entra por primeira vez, permitindo seleccionar as súas plataformas favoritas (PC, PS5, Switch, etc.). Tamén sería de gran axuda mellorar o buscador principal para que permita filtrar por etiquetas de xénero ou data de lanzamento.

A nivel visual, habilitar a edición de perfís e comentarios utilizando a librería **X-editable** ou integrando un editor de texto rico (como **CKEditor**) nos foros faría que a interacción fose moito máis profesional.

---

## Links

### Viabilidade e Gastos do Proxecto
* [Formas Xurídicas](https://www.infoautonomos.com/)
* [Precio Hosting](https://dinahosting.com/)
* [Tarifa de Internet para Empresas](https://www.orange.es/empresas/tarifas/fibra/)
* [Guia AEPD sobre protección de datos](https://www.aepd.es/)
* [Tarifas Pasarelas de Pago](https://stripe.com/es/pricing/)

### Tecnoloxías e Librarías
* **Frontend Framework:** [Bootstrap 5 Documentation](https://getbootstrap.com/)
* **Lóxica Dinámica:** [jQuery API](https://api.jquery.com/)
* **Catálogo de Datos:** [Documentación API RAWG](https://api.rawg.io/docs/)
* **Iconografía:** [FontAwesome Icons](https://fontawesome.com/)

### Referencias e Estándares
* **Deseño de Interface:** [Inspiración Gaming](https://dribbble.com/tags/gaming/)
* **Validación de Código:** [W3C CSS Validator](https://jigsaw.w3.org/css-validator/)
* **Ferramenta de API:** [Probas con Postman](https://www.postman.com/)
