# FASE DE IMPLANTACIÓN

- [FASE DE IMPLANTACIÓN](#fase-de-implantación)
  - [1- Manual técnico](#1--manual-técnico)
    - [1.1- Instalación](#11--instalación)
    - [1.2- Administración do sistema](#12--administración-do-sistema)
  - [2- Manual de usuario](#2--manual-de-usuario)
  - [3- Melloras futuras](#3--melloras-futuras)

## 1- Manual técnico

### 1.1- Instalación

A posta en marcha de GameMatcher require dunha contorna de servidor web estándar. O proxecto está deseñado para ser lixeiro, funcionando en calquera servidor con polo menos 512MB de RAM e 100MB de espazo en disco.
>
En canto ao software, é indispensable contar cun servidor Apache 2.4 e PHP 8.0 ou superior. A xestión de datos realízase mediante MySQL 5.7 (ou MariaDB). Como elemento crítico, o servidor debe ter acceso á rede para realizar as consultas á API externa de RAWG, da cal obtemos o catálogo de xogos en tempo real.
>
Para a carga inicial, o administrador debe importar o arquivo gamematcher.sql situado na carpeta de base de datos. Unha vez creada a estrutura, cómpre configurar o ficheiro config.php cos parámetros de conexión ao host e a API KEY correspondente. O sistema diferenza entre usuarios estándar e administradores mediante unha columna de roles na táboa de usuarios, permitindo unha xestión graduada de permisos desde o primeiro acceso.

### 1.2- Administración do sistema

Unha vez o sistema estea en produción, a administración centrarase en garantir a dispoñibilidade e seguridade dos datos. Recoméndase a programación de copias de seguridade diarias da base de datos MySQL para evitar a perda de información dos foros e valoracións dos usuarios.
>
Os administradores do sistema terán a responsabilidade de velar polo cumprimento das normas de respecto e convivencia nos foros. Para isto, o panel de administración permite supervisar as achegas e proceder ao bloqueo temporal ou definitivo de contas para protexer a integridade da comunidade.

## 2- Manual de usuario

O deseño de GameMatcher prioriza a experiencia de usuario (UX), polo que a interface é intuitiva e non require dunha formación técnica previa. O usuario só precisa rexistrarse cun correo válido para comezar a interactuar coa comunidade.

Unha vez iniciada a sesión, os usuarios poden navegar polas fichas técnicas dos xogos, onde atoparán o sistema de valoración por estrelas que desenvolvemos. A interacción nos foros está protexida: cada usuario ten control total sobre as súas achegas, podendo editar ou eliminar os seus propios comentarios mediante botóns que aparecen dinamicamente nos seus mensaxes.

## 3- Melloras futuras

A folla de ruta para a evolución de **GameMatcher** inclúe varias optimizacións clave para transformar o prototipo actual nunha plataforma social e técnica máis robusta:

* **Sistema de Amizades e Feed Social:** Implementarase a funcionalidade de "Seguir", permitindo que os usuarios conecten entre si. Isto habilitará un taboleiro personalizado onde se poidan ver as últimas valoracións e comentarios dos amigos en tempo real, fomentando a interacción social.
* **Caché Local de API:** Para optimizar o rendemento, prevese o desenvolvemento dun sistema de almacenamento temporal para os datos obtidos de **RAWG**. Isto reduciría drasticamente a latencia na carga das fichas de xogos e minimizaría o consumo inecesario de recursos externos e peticións á API.
* **Comparador de Prezos:** Prevese a integración de APIs de terceiros (como Steam, Epic Games ou tiendas dixitais similares) para ofrecer ao usuario información de mercado actualizada, permitíndolle atopar a mellor oferta de compra para o xogo que está consultando.
* **Notificacións en tempo real:** Mediante o uso de tecnoloxías como **AJAX** ou **WebSockets**, o sistema poderá avisar instantaneamente ao usuario de novas interaccións (respostas en fíos do foro ou mencións) sen necesidade de recargar a páxina, mellorando a fluidez da experiencia de usuario.
* **Modelo de Usuarios Premium:** Introdución dun sistema de subscrición que ofreza vantaxes exclusivas, como a eliminación de publicidade, insignias de perfil personalizadas, acceso prioritario a novas funcións e estatísticas avanzadas sobre os seus hábitos de xogo.
* **Apartado de Torneos e Sorteos:** Creación dun módulo específico para a organización de eventos competitivos e sorteos mensuais. Isto axudará a aumentar o "engagement" e a retención de usuarios, dinamizando a participación activa dentro dos foros da comunidade.
* **Implementación de IA no ChatBot:** Evolución do actual bot de asistencia cara a un sistema baseado en **Intelixencia Artificial Conversacional** (vía API de OpenAI ou similar). O novo ChatBot poderá ofrecer recomendacións personalizadas de xogos baseándose nos gustos do usuario, resolver dúbidas complexas e actuar como un asistente virtual 24/7.
* **Sistema de Reputación e Gamificación (Karma):** Implementación dun sistema de puntos baseado nas interaccións positivas da comunidade. Os usuarios que aporten contido de calidade ou axuden a outros recibirán "Karma", o que lles permitirá desbloquear medallas exclusivas e rangos visibles no seu perfil (como *Experto en RPGs* ou *Guía da Comunidade*). Esta mecánica busca fomentar unha participación respectuosa, útil e activa dentro dos foros.
* **Mencións e Sistema de Citación Avanzado:** Desenvolvemento dunha funcionalidade de mencións directas mediante o uso de `@usuario`, que activará notificacións automáticas para o usuario aludido. Ademais, engadirase un botón de "Citar" para permitir respostas a partes específicas dun comentario. Estas ferramentas son fundamentais para facilitar o seguimento de debates longos e mellorar a cohesión nas conversas dentro dos fíos de discusión.
* **Moderación Inteligente e Filtros de Contido:** Para garantir un ambiente seguro, prevese a integración de filtros automáticos que detecten linguaxe ofensiva ou spam. Isto permitirá que os moderadores humanos se centren en tarefas máis complexas, mentres o sistema asegura 24/7 que se cumpran as normas de convivencia da plataforma.



[**<-Anterior**](../../README.md)
