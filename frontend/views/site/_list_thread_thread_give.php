<div class="col-xs-2" style="padding: 0; margin-right: 30px;">
    <button onclick="$('div#comment-boy-<?= $thread_id ?>').slideToggle('fast')" class="btn btn-default">Give Comment</button>
        <div id="comment-boy-<?= $thread_id ?>" class="col-xs-12" style="display: none; padding: 15px; padding-left: 0; padding-right: 0;">
        <input style="width: 100%; !important" class="form-control" type="text" value="Place change with redactor as soon as possible" />
    </div>
</div>
