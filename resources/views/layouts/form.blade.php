<?php foreach ($form as $key => $value): ?>
<div class="form-group row">
    @foreach ($value as $v)

    @php
    if(!empty($v)):
    $val = old($v['name'], $v['value']);
    $col = !empty($v['col']) ? $v['col'] : 6;
    @endphp

    @if ($v['type'] == 'hidden')
    <div class="col-md-{{$col}} d-none" id="{{ $v['name']."_div" }}">
        @else
        <div class="col-md-{{$col}}" id="{{ $v['name']."_div" }}">
            @endif

            @if ($v['type'] == 'text')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <input id={{$v['name']}} type="text" class="form-control @error($v['name']) is-invalid @enderror"
                name={{$v['name']}} value="{{ $val }}" autocomplete={{$v['name']}} {{@$v['other']}}
                >
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'hidden')
            <input id={{$v['name']}} type="hidden" class="form-control" name={{$v['name']}} value="{{ $val }}">
            @elseif($v['type'] == 'datepicker')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <input id={{$v['name']}} type="text" class="form-control @error($v['name']) is-invalid @enderror"
                name={{$v['name']}} value="{{ $val }}" autocomplete={{$v['name']}} {{@$v['other']}}>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @push('scripts')
            <script>
                $(document).ready(function(){
                        $('input[id=<?= $v['name'] ?>]').daterangepicker({
                            singleDatePicker: true,
                            showDropdowns: true,
                            locale: {
                               format: '<?= !empty($v["date-format"]) ? $v["date-format"] : "DD/MM/YYYY"  ?>'
                            }
                        });
                    })
            </script>
            @endpush

            @elseif($v['type'] == 'password')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <input id={{$v['name']}} type="password" class="form-control @error($v['name']) is-invalid @enderror"
                name={{$v['name']}} value="{{ $val }}" autocomplete={{$v['name']}} autofocus {{@$v['other']}}>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'number')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <input id={{$v['name']}} step="any" type="number"
                class="form-control @error($v['name']) is-invalid @enderror" name={{$v['name']}} value="{{ $val }}"
                autocomplete={{$v['name']}} autofocus {{@$v['other']}}>
            <?php if(!empty($v['suggestion'])): ?>
            <small class="form-text text-muted"><?= $v['suggestion'] ?></small>
            <?php endif; ?>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'pincode')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <input id={{$v['name']}} type="number" maxlength="6"
                class="form-control @error($v['name']) is-invalid @enderror" name={{$v['name']}} value="{{ $val }}"
                autocomplete={{$v['name']}} autofocus {{@$v['other']}} oninput={{@$v['onchange']}}>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'phone')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">{{Config::get('constants.countryCode')}}</span>
                </div>
                <input id={{$v['name']}} type="text" class="form-control @error($v['name']) is-invalid @enderror"
                    name={{$v['name']}} value="{{ $val }}" autocomplete={{$v['name']}}>
                <div class="err-{{$v['name']}} invalid-feedback">
                    {{ $errors->first($v['name']) }}
                </div>
            </div>
            @elseif($v['type'] == 'date')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <div class="input-group date">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input id={{$v['name']}} type="date"
                    class=" dateSingle form-control @error($v['name']) is-invalid @enderror" name={{$v['name']}}
                    value="{{ $val }}" autocomplete={{$v['name']}} date-format="{{$v['date-format']}}">
                <div class="err-{{$v['name']}} invalid-feedback">
                    {{ $errors->first($v['name']) }}
                </div>
            </div>
            @elseif($v['type'] == 'email')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input id={{$v['name']}} type="text" class="form-control @error($v['name']) is-invalid @enderror"
                    name={{$v['name']}} value="{{ $val }}" autocomplete={{$v['name']}}>
                <div class="err-{{$v['name']}} invalid-feedback">
                    {{ $errors->first($v['name']) }}
                </div>
            </div>
            @elseif($v['type'] == 'textarea')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <textarea class="form-control @error($v['name']) is-invalid @enderror" id={{$v['name']}} rows="3"
                 placeholder="" name={{$v['name']}}
                autocomplete={{$v['name']}}>{{$val}}</textarea>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'editor')
            <div class="form-group">
                <label for={{$v['name']}}>{{ $v['label'] }}</label>
                <textarea id="{{$v['name']}}" class="form-control textarea" name="{{$v['name']}}" cols="50"
                    rows="10">{{$val}}</textarea>
                <div class="text-danger">
                    {{ $errors->first($v['name']) }}
                </div>
            </div>
            @elseif($v['type'] == 'file')
            <div class="form-group">
                <label for={{$v['name']}}>{{ $v['label'] }}</label>
                <div class="custom-file mb-3">
                    <input id="{{$v['name']}}" type="file"
                        class="custom-file-input form-control  @error($v['name']) is-invalid @enderror"
                        name="{{$v['name']}}" value="{{ $val }}" autocomplete={{$v['name']}}
                        accept="<?= !empty($v['accept']) ? $v['name']  : 'image/png, image/jpeg, image/jpg' ?>">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <div class="text-danger">
                    {{ $errors->first($v['name']) }}
                </div>
            </div>
            @elseif($v['type'] == 'select')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <select name={{$v['name']}} id={{$v['name']}}
                class="form-control  {{ $v['name'] }}  @error($v['name']) is-invalid @enderror"
                autocomplete={{$v['name']}} onchange="{{@$v['onchange']}}" {{@$v['other']}}>
                <?php
                    if(!empty($v['prompt'])){
                        echo "<option value=''>". $v['prompt']."</option>";
                    } ?>

                <?php if(!empty($v['options'])): ?>
                    <?php  foreach ($v['options'] as $rkey => $role): ?>
                        <?php if($val == $rkey): ?>
                        <option value="<?= $rkey ?>" selected><?= $role ?></option>
                        <?php else: ?>
                        <option value="<?= $rkey ?>"><?= $role ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if(!empty($v['options_dynamic'])): ?>
                    <?php  foreach ($v['options_dynamic'] as $rkey => $role): ?>
                        <?php if($val == $role['key']): ?>
                        <option value=<?= $role['key'] ?> selected <?= !empty($role['disabled']) ? 'disabled' : '' ?>><?= $role['value'] ?></option>
                        <?php else: ?>
                        <option value=<?= $role['key'] ?> <?= !empty($role['disabled']) ? 'disabled' : '' ?> ><?= $role['value'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'select_validate')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <select name={{$v['name']}} id={{$v['name']}} onchange={{$v['onchange']}}
                class="form-control @error($v['name']) is-invalid @enderror" autocomplete={{$v['name']}}
                {{@$v['other']}}>
                <?php
                    if(!empty($v['prompt'])){
                        echo "<option value=''>". $v['prompt']."</option>";
                    }
                    foreach ($v['options'] as $rkey => $role):
                        ?>
                @if($val == $rkey)
                <option value="<?= $rkey ?>" selected><?= $role ?></option>
                @else
                <option value="<?= $rkey ?>"><?= $role ?></option>
                @endif

                <?php endforeach; ?>
            </select>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'select1')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <select name={{$v['name']}} id={{$v['name']}} class="form-control @error($v['name']) is-invalid @enderror"
                autocomplete={{$v['name']}} {{@$v['other']}}>
                <?php
                    if(!empty($v['prompt'])){
                        echo "<option value=''>". $v['prompt']."</option>";
                    }
                    ?>
            </select>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'select_with_onchange')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <select name={{$v['name']}} id={{$v['name']}} onchange={{$v['onchange']}}
                class="form-control @error($v['name']) is-invalid @enderror" autocomplete={{$v['name']}}
                {{@$v['other']}}>
                <?php
                    if(!empty($v['prompt'])){
                        echo "<option value=''>". $v['prompt']."</option>";
                    }
                    ?>
            </select>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'radio')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <?php foreach ($v['options'] as $rkey => $role): ?>
            @if($val == $rkey)
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" value=<?= $rkey ?> name={{$v['name']}}
                    id={{$v['name'].$rkey}} checked="">
                <label class="custom-control-label" for={{$v['name'].$rkey}}>{{$role}}</label>
            </div>
            @else
            <div class="custom-control custom-radio">
                <input class="custom-control-input " type="radio" value=<?= $rkey ?> name={{$v['name']}}
                    id={{$v['name'].$rkey}}>
                <label class="custom-control-label" for={{$v['name'].$rkey}}>{{$role}}</label>
            </div>
            @endif
            <?php endforeach; ?>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif ($v['type'] == 'checkbox')
            <label for={{$v['name']}}>{{ $v['label'] }}</label>
            <input type="checkbox" id="{{$v['name']}}" name="{{$v['name']}}" value="{{ $val }}">{{$v['value']}} <br>

            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif ($v['type'] == 'time')
            <label for={{$v['name']}} {{@$v['other']}}>{{ $v['label'] }}</label>
            <input id={{$v['name']}} type="time" class="form-control @error($v['name']) is-invalid @enderror"
                name={{$v['name']}} value="{{ $val }}" autocomplete={{$v['name']}} {{@$v['other']}}>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif ($v['type'] == 'timepicker')
            <label for={{$v['name']}} {{@$v['other']}}>{{ $v['label'] }}</label>
            <input type="text" class="form-control @error($v['name']) is-invalid @enderror" name={{$v['name']}}
                moment-picker={{$v['name']}} format="HH:mm" id={{$v['name']}} ng-model={{$v['name']}}
                ng-model-options="{ updateOn: 'blur' }" value={{ @$val }}>
            <div class="err-{{$v['name']}} invalid-feedback">
                {{ $errors->first($v['name']) }}
            </div>
            @elseif($v['type'] == 'testradio')
            <div class="testradio">
                {{-- <label for={{$v['name']}} {{@$v['other']}}>{{ $v['label'] }</label> --}}
                <div class="custom-control custom-radio testradion">
                </div>
            </div>
            @endif
            <?php if(!empty($v['warn'])): ?>
            <small class="form-text text-danger"><?= $v['warn'] ?></small>
            <?php endif; ?>
            <?php if(!empty($v['info'])): ?>
            <small class="form-text text-secondary"><?= $v['info'] ?></small>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        @endforeach
    </div>
    <?php endforeach; ?>
