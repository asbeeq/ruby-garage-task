
<div class="row">
    <div class="project-task col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0" data-task-id="<?= $task['id'] ?>">
        <div class="row aligned-row">
            <div class="project-task-done col-md-1 col-xs-1 text-center">
                <input type="checkbox" class="is-done" <?php if ($task['is_done'] == 1) echo ' checked' ?>>

            </div>
            <div class="project-task-text col-md-9 col-xs-9">
                <p class="task-text <?php if ($task['is_done']) echo ' done' ?>">
                    <?= $task['name'] ?>
                </p>
                <p class="priority col-md-6">
                    <i class="fa fa-star <?= $task['priority_color'] ?>-star" data-priority-id="<?= $task['priority_id'] ?>"></i>
                    <span><?= $task['priority_name'] ?></span>
                </p>
                <p class="deadline text-right col-md-6">
                    <i class="fa fa-clock-o"></i>
                    <?php
                        $value = 'Click to set deadline';
                        if ($task['deadline']) {
                            $value = date('d.m.Y H:i', strtotime($task['deadline']));
                        }
                    ?>
                    <i class="fa fa-times clear-deadline" aria-hidden="true"></i>
                    <input type='text' class="data-time-deadline" id="datetimepicker-<?= $task['id'] ?>" value="<?= $value ?>" />

                </p>
            </div>
            <div class="project-task-action text-center col-md-2 col-xs-2">
                <div class="edit-task-buttons">
                    <i class="fa fa-sort" aria-hidden="true"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $('#datetimepicker-<?= $task['id'] ?>').datetimepicker({
         lazyInit: true,
         format: 'd.m.Y H:i',
         step: 30,
         minDate:0,
         dayOfWeekStart: 1,
         onChangeDateTime: function(dp,input){
             var id = input.parents('.project-task').data('task-id');
             change_deadline(id, input.val())
         }
     });
     
     var change_deadline = function (id, newTime) {
         $.ajax({
             type: "POST",
             url: 'ajax/changeDeadline-task',
             data: 'task-id=' + id + '&new-deadline=' + newTime,
             success: function (data) {
                 var response = JSON.parse(data);
                 if (!response.status) {
                     console.log('Status edit deadline: ' + response.status);
                 }
             },
             error: function () {
                 console.log('Error edit deadline');
             }
         });
     }
</script>
