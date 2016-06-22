<!DOCTYPE html>
<html>
    <head>
        <title>To do</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1>To do</h1>
            <br>
            <div class="row">
                <div class="col-sm-1">
                    <button type="button" class="btn btn-primary" id="newTask">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="col-sm-11" style="display:none" id="taskForm">
                    <div class="input-group">
                        <span class="input-group-addon" id="title">*</span>
                        <input type="text" class="form-control" placeholder="Title" aria-describedby="title" id="taskTitle">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="summary"></span>
                        <input type="text" class="form-control" placeholder="Summary" aria-describedby="summary" id="taskSummary">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="priority">
                            <span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
                        </span>
                        <h5><input type="checkbox" aria-label="..." aria-describedby="priority" id="taskPriority"></h5>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="expiration">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        </span>
                        <h5><input type="checkbox" aria-label="..." aria-describedby="expiration" id="taskExpiration"></h5>
                    </div>
                    <div class="input-group" id="taskDatetime" style="display:none">
                        <span class="input-group-addon" id="datetime">Expires</span>
                        <input type="date" class="form-control" aria-describedby="datetime" id="taskDate">
                        <input type="time" class="form-control" aria-describedby="datetime" id="taskTime">
                    </div>
                    <br>
                    <button type="button" class="btn btn-primary" aria-label="Left Align" id="submitTask" disabled>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            save
                    </button>
                    <button type="button" class="btn btn-danger pull-right" aria-label="Right< Align" id="cancelTask">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            cancel
                    </button>
                </div>
            </div>
            <br>
            <div class="panel">
                @foreach ($tasks as $task)
                    <div class="row" task-id="{{ $task['id'] }}">
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-default taskCompleted" aria-label="Left Align" @if ($task['completed'] == 1) disabled @endif>
                            @if ($task['completed'])
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                            @else
                                <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>
                            @endif
                            </button>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-default taskPriority" aria-label="Left Align"  @if ($task['completed'] == 1) disabled @endif>
                            @if ($task['priority'])
                                <span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
                            @endif
                            </button>
                        </div>
                        <div class="col-sm-1">
                        @if ($task['expires_at'] != '')
                            <button type="button" class="btn btn-default taskExpiration" aria-label="Left Align"  @if ($task['completed'] == 1) disabled @endif datetime="{{ $task['expires_at'] }}">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </button>
                        @endif
                        </div>
                        <div class="col-sm-7 vertical-center">
                            <h5><span class="taskTitle">{{ $task['title'] }}</span> <span class="taskSummary" style="font-style: italic">{{ $task['summary'] }}</span></h5>
                        </div>
                        <div class="col-sm-2">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default taskUpdate" aria-label="Left Align" @if ($task['completed'] == 1) disabled @endif>
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default taskDelete" aria-label="Left Align">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function () {
            //var csrf = $('meta[name="csrf-token"]').attr('content');
            //$.ajaxSetup({ headers: { 'csrftoken' : csrf } });

            // Add task button
            $('#newTask').click(function() {
                $(this).prop('disabled', true);
                $('#taskForm').slideDown();
                $('#taskTitle').focus();
                $('#taskForm').attr('createTask', true);
            });
            // Cancel task button
            $('#cancelTask').click(function() {
                resetTask();
            });
            // Test change Title
            $('#taskTitle').on('input', function(e) {
                if ($(this).val() !== '') {
                    $('#submitTask').prop('disabled', false);
                } else {
                    $('#submitTask').prop('disabled', true);
                }
            });

            // Submit new task or update existing one
            $('#submitTask').click(function(){
                var data = {};
                if ($('#taskForm').attr('task-id')) {
                    data.id = $('#taskForm').attr('task-id');
                }

                data.title = $('#taskTitle').val();
                if ($('#taskSummary').val() !== '') {
                    data.summary = $('#taskSummary').val();
                }
                if ($('#taskPriority').prop('checked')) {
                    data.priority = 1;
                }
                if($('#taskDate').val() != '') {
                    data.date = $('#taskDate').val();
                }
                if($('#taskTime').val() != '') {
                    data.time = $('#taskTime').val();
                }

                data._token = $('meta[name="csrf-token"]').attr('content');

                var verb = 'create';
                if ($('#taskForm').attr('updateTask')) {
                    verb = 'update';
                }
                $.ajax({
                    type: "POST",
                    url: "{{ $app['url']->to('/') }}"+'/'+verb,
                    data: data,
                    success: function(response) {
                        console.log(response);
                        resetTask();
                        location.reload();
                    },
                    dataType: 'JSON'
                });
            });

            function resetTask() {
                $('#newTask').prop('disabled', false);
                $('#taskForm').slideUp();
                $('#taskTitle').val('');
                $('#taskSummary').val('');
                $('#taskPriority').removeAttr('checked');
                $('#taskExpiration').removeAttr('checked');
                $('#taskDate').val('');
                $('#taskTime').val('');
                $('#taskDatetime').hide();
                $('#submitTask').prop('disabled', true);
                $('#taskForm').removeAttr('task-id');
                $('#taskForm').removeAttr('createTask');
                $('#taskForm').removeAttr('updateTask');
            }

            function events() {
                // Update
                $('.taskUpdate').click(function() {
                    var row = $(this).parent().parent().parent();
                    $('#newTask').click();
                    $('#taskForm').attr('updateTask', true);
                    $('#taskForm').attr('task-id', row.attr('task-id'));
                    $('#taskTitle').val(row.find('.taskTitle').first().text());
                    $('#taskSummary').val(row.find('.taskSummary').first().text());
                    if (row.find('.taskPriority').first().children().length == 1) {
                        $('#taskPriority').attr('checked', true);
                    } else {
                        $('#taskPriority').attr('checked', false);
                    }
                    if (row.find('.taskExpiration').length > 0) {
                        var datetime = row.find('.taskExpiration').attr('datetime');
                        $('#taskExpiration').click();
                        $('#taskDate').val(datetime.slice(0,10));
                        $('#taskTime').val(datetime.slice(11));
                    } else {
                        if ($('#taskExpiration').prop('checked')) {
                            $('#taskExpiration').removeAttr('checked');
                            $('#taskDate').val('');
                            $('#taskTime').val('');
                            $('#taskDatetime').hide();
                        }
                    }
                    $('#submitTask').prop('disabled', false);
                });

                // Priority flag
                $('.taskPriority').click(function(){
                    var data = {};
                    var row = $(this).parent().parent();
                    data.id = row.attr('task-id');
                    if ($(this).children().length == 1) {
                        data.priority = 0;
                    } else {
                        data.priority = 1;
                    }
                    data._token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ $app['url']->to('/') }}"+'/update',
                        data: data,
                        success: function(response) {
                            location.reload();
                        },
                        dataType: 'JSON'
                    });
                });

                // Check / uncheck task
                $('.taskCompleted').click(function(){
                    var data = {};
                    var row = $(this).parent().parent();
                    data.id = row.attr('task-id');
                    data.completed = 1;
                    data._token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ $app['url']->to('/') }}"+'/update',
                        data: data,
                        success: function(response) {
                            location.reload();
                        },
                        dataType: 'JSON'
                    });
                });
                // Delete task
                $('.taskDelete').click(function(){
                    var data = {};
                    var row = $(this).parent().parent().parent();    ;
                    data.id = row.attr('task-id');
                    var title = row.find('.taskTitle').first().text();
                    if (confirm('Are you sure you want to remove "'+title+'"?')) {
                    data._token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: "POST",
                            url: "{{ $app['url']->to('/') }}"+'/delete',
                            data: data,
                            success: function(response) {
                                row.remove( );
                            },
                            dataType: 'JSON'
                        });
                    }
                });
                // Check / uncheck Expiration
                $('#taskExpiration').change(function(){
                    if ($(this).prop('checked')) {
                        if ($('#taskDate').val() == '') {
                            var rightNow = new Date();
                            var res = rightNow.toISOString().slice(0,10);//.replace(/-/g,"");
                            $('#taskDate').val(res);
                        }
                        $('#taskDatetime').slideDown();
                    } else {
                        $('#taskDatetime').slideUp();
                    }
                });
                // Expiration button
                $('.taskExpiration').click(function() {
                    alert($(this).attr('datetime'));
                });
            }
            events();
        });
    </script>
</html>
