<div class="alert-message-wrapper">
    <div style="padding: 0 25%;">
        <div class="alert-message alert alert-<?= $message['type'] ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $message['text'] ?>
        </div>
    </div>
</div>