<?php
$isLoggedIn = isset($_SESSION['usuario']) ? 'true' : 'false';
$userName = (isset($_SESSION['usuario']) && is_object($_SESSION['usuario'])) ? $_SESSION['usuario']->getNombre() : '';
$isLanding = (!isset($_GET['controller']) || $_GET['controller'] == 'Games' && !isset($_GET['action'])) ? 'true' : 'false';
?>

<script>
    window.userSession = {
        isLoggedIn: <?php echo $isLoggedIn; ?>,
        userName: "<?php echo $userName; ?>",
        isLanding: <?php echo $isLanding; ?>
    };
</script>

<div id="chat-window" class="chat-hidden">
    <div class="chat-header">
        <span>Cames</span>
        <div class="header-actions">
            <span id="chat-minimize">−</span>
            <span id="chat-close">×</span>
        </div>
    </div>
    <div id="chat-messages" class="chat-messages">
    </div>
    <div class="chat-input-container">
        <input type="text" id="chat-input" placeholder="Escribe algo...">
        <button id="chat-send">Enviar</button>
    </div>
</div>

<div id="chat-container">
    <div id="chat-tooltip" class="chat-tooltip-hidden"></div>
    
    <div id="chat-bubble">
        <img src="assets/img/robot-vectorial-graident-ai.png" alt="Cames">
    </div>
</div>