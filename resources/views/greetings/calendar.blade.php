<?php

use App\Greetings;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<style>
    .fc-title {
        padding: 4px !important;
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Greetings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <!-- <li class="breadcrumb-item"><a href="{{ route('greetings.index') }}">Greetings</a></li> -->
                    <li class="breadcrumb-item active">Calendar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body p-0">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</section>
@stop

@push('scripts')
<script>
    $(function() {
        var t = $('#greetings_table_data').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('greetings.data') ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: '_image',
                    name: 'image',
                    render: function(data, type, full, meta) {
                        return ' <img src="' + data + '" style="width: 100px;height:70px"> ';
                    },
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: '_date',
                    name: 'date'
                },
                {
                    data: '_status',
                    name: '_status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = "";
                    if (column[0][0] == 3) {
                        input = '<input type="date" style="width:100%">';
                    } else if (column[0][0] == 4) {
                        var input = '<?= Utils::getStatusElement() ?>';
                    } else if (column[0][0] == 2) {
                        input = '<input type="text" style="width:100%">';
                    } else {
                        input = '';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), true, true, true).draw();
                        });
                    t.on('order.dt search.dt', function() {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });
            }
        });
    });

    var calendar;
    $(function() {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
            ele.each(function() {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                }

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject)

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                })

            })
        }

        ini_events($('#external-events div.external-event'))

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        // var Draggable = FullCalendarInteraction.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------
        calendar = new Calendar(calendarEl, {
            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
            displayEventTime: false,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            //Random default events
            events: [
                <?php foreach ($notifications as $key => $value) : ?> {
                        title: `<?= $value['title'] ?>`,
                        start: `<?= date('Y-m-d', strtotime($value['date'])) ?>`,
                        backgroundColor: `<?= $value['color'] ?>`,
                        borderColor: '#f56954' //red
                    },
                <?php endforeach; ?>
            ],
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function(info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            },
            eventSources: [

                // your event source
                {
                    url: '<?= route('greetings.calendar-events-sip') ?>',
                    method: 'POST',
                    extraParams: {
                        "_token": $('#token').val()
                    },
                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                    color: '#3d93cc', // a non-ajax option
                    textColor: 'white' // a non-ajax option
                },
                {
                    url: '<?= route('greetings.calendar-events-insurance') ?>',
                    method: 'POST',
                    extraParams: {
                        "_token": $('#token').val()
                    },
                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                    color: '#f17f30', // a non-ajax option
                    textColor: 'white' // a non-ajax option
                }

                // any other sources...

            ]
        });

        calendar.render();

        /* ADDING EVENTS */
        //Color chooser button
    })
</script>
@endpush