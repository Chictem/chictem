@extends('voyager::master')

@section('head')
    <script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/jsonarea/jsonarea.min.js"></script>
    <script>var valid_json = [];</script>
@stop

@section('page_header')
    <div class="page-title">
        <i class="voyager-data"></i> @if(isset($dataType->id)){{ 'Edit BREAD for ' . $dataType->name . ' table' }}@elseif(isset($table)){{ 'Create BREAD for ' . $table . ' table' }}@endif
    </div>
@stop

@section('content')

    @if(isset($dataType->name))
        @php $table = $dataType->name @endphp
    @endif

    @php $fieldOptions = isset($dataType) ? $dataType->fieldOptions() : DB::select("DESCRIBE `${table}`"); @endphp

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <form role="form"
                      action="@if(isset($dataType->id)){{ route('voyager.database.update_bread', $dataType->id) }}@else{{ route('voyager.database.store_bread') }}@endif"
                      method="POST">
                    @if(isset($dataType->id))
                        <input type="hidden" value="{{ $dataType->id }}" name="id">
                        {{ method_field("PUT") }}
                    @endif
                    <!-- CSRF TOKEN -->
                    {{ csrf_field() }}

                    <div class="panel panel-primary panel-bordered">

                        <div class="panel-heading">
                            <h3 class="panel-title">Edit the rows for the {{ $table }} table below:</h3>
                        </div>

                        <table id="users" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Field</th>
                                <th>Field Info</th>
                                <th>Visibility</th>
                                <th>Input Type</th>
                                <th>Display Name</th>
                                <th>Optional Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fieldOptions as $data)
                                @if(isset($dataType->id))
                                    <?php $dataRow = App\Models\DataRow::where('data_type_id', '=',
                                            $dataType->id)->where('field', '=', $data->Field)->first(); ?>
                                @endif
                                <tr>
                                    <td><h4><strong>{{ $data->Field }}</strong></h4></td>
                                    <td>
                                        <strong>Type:</strong> <span>{{ $data->Type }}</span><br/>
                                        <strong>Key:</strong> <span>{{ $data->Key }}</span><br/>
                                        <strong>Required:</strong>
                                        @if($data->Null == "NO")
                                            <span>Yes</span>
                                            <input type="hidden" value="1" name="field_required_{{ $data->Field }}"
                                                   checked="checked">
                                        @else
                                            <span>No</span>
                                            <input type="hidden" value="0" name="field_required_{{ $data->Field }}">
                                        @endif
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                               id="field_browse_{{ $data->Field }}"
                                               name="field_browse_{{ $data->Field }}" @if(isset($dataRow->browse) && $dataRow->browse){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->browse)){{ 'checked="checked"' }}@endif>
                                        <label for="field_browse_{{ $data->Field }}">Browse</label><br/>
                                        <input type="checkbox"
                                               id="field_read_{{ $data->Field }}"
                                               name="field_read_{{ $data->Field }}" @if(isset($dataRow->read) && $dataRow->read){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->read)){{ 'checked="checked"' }}@endif>
                                        <label for="field_read_{{ $data->Field }}">Read</label><br/>
                                        <input type="checkbox"
                                               id="field_edit_{{ $data->Field }}"
                                               name="field_edit_{{ $data->Field }}" @if(isset($dataRow->edit) && $dataRow->edit){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->edit)){{ 'checked="checked"' }}@endif>
                                        <label for="field_edit_{{ $data->Field }}">Edit</label><br/>
                                        <input type="checkbox"
                                               id="field_add_{{ $data->Field }}"
                                               name="field_add_{{ $data->Field }}" @if(isset($dataRow->add) && $dataRow->add){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'created_at')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->add)){{ 'checked="checked"' }}@endif>
                                            <label for="field_add_{{ $data->Field }}">Add</label><br/>
                                        <input type="checkbox"
                                               id="field_delete_{{ $data->Field }}"
                                               name="field_delete_{{ $data->Field }}" @if(isset($dataRow->delete) && $dataRow->delete){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->delete)){{ 'checked="checked"' }}@endif>
                                                <label for="field_delete_{{ $data->Field }}">Delete</label><br/>
                                        <input type="checkbox"
                                               id="field_show_{{ $data->Field }}"
                                               name="field_show_{{ $data->Field }}" @if(isset($dataRow->show) && $dataRow->show){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->show)){{ 'checked="checked"' }}@endif>
                                        <label for="field_show_{{ $data->Field }}">Show</label><br/>
                                        <input type="checkbox"
                                               id="field_search_{{ $data->Field }}"
                                               name="field_search_{{ $data->Field }}" @if(isset($dataRow->search) && $dataRow->search){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->search)){{ 'checked="checked"' }}@endif>
                                        <label for="field_search_{{ $data->Field }}">Search</label><br/>
                                    </td>
                                    <input type="hidden" name="field_{{ $data->Field }}" value="{{ $data->Field }}">
                                    <td>
                                        @if($data->Key == 'PRI')
                                            <p>Primary Key</p>
                                            <input type="hidden" value="PRI" name="field_input_type_{{ $data->Field }}">
                                        @elseif($data->Type == 'timestamp')
                                            <p>Timestamp</p>
                                            <input type="hidden" value="timestamp"
                                                   name="field_input_type_{{ $data->Field }}">
                                        @else
                                            <select name="field_input_type_{{ $data->Field }}">
                                                <option value="text" @if(isset($dataRow->type) && $dataRow->type == 'text'){{ 'selected' }}@endif>
                                                    Text Box
                                                </option>
                                                <option value="text_area" @if(isset($dataRow->type) && $dataRow->type == 'text_area'){{ 'selected' }}@endif>
                                                    Text Area
                                                </option>
                                                <option value="rich_text_box" @if(isset($dataRow->type) && $dataRow->type == 'rich_text_box'){{ 'selected' }}@endif>
                                                    Rich Textbox
                                                </option>
                                                <option value="password" @if(isset($dataRow->type) && $dataRow->type == 'password'){{ 'selected' }}@endif>
                                                    Password
                                                </option>
                                                <option value="hidden" @if(isset($dataRow->type) && $dataRow->type == 'hidden'){{ 'selected' }}@endif>
                                                    Hidden
                                                </option>
                                                <option value="checkbox" @if(isset($dataRow->type) && $dataRow->type == 'checkbox'){{ 'selected' }}@endif>
                                                    Check Box
                                                </option>
                                                <option value="radio_btn" @if(isset($dataRow->type) && $dataRow->type == 'radio_btn'){{ 'selected' }}@endif>
                                                    Radio Button
                                                </option>
                                                <option value="select_dropdown" @if(isset($dataRow->type) && $dataRow->type == 'select_dropdown'){{ 'selected' }}@endif>
                                                    Select Dropdown
                                                </option>
                                                </option>
                                                <option value="select_multiple" @if(isset($dataRow->type) && $dataRow->type == 'select_multiple'){{ 'selected' }}@endif>
                                                    Multiple Select
                                                </option>
                                                <option value="file" @if(isset($dataRow->type) && $dataRow->type == 'file'){{ 'selected' }}@endif>
                                                    File
                                                </option>
                                                <option value="image" @if(isset($dataRow->type) && $dataRow->type == 'image'){{ 'selected' }}@endif>
                                                    Image
                                                </option>
                                            </select>
                                        @endif

                                    </td>
                                    <td><input type="text" class="form-control"
                                               value="@if(isset($dataRow->display_name)){{ $dataRow->display_name }}@else{{ ucwords(str_replace('_', ' ', $data->Field)) }}@endif"
                                               name="field_display_name_{{ $data->Field }}"></td>
                                    <td>
                                        <textarea class="form-control json" name="field_details_{{ $data->Field }}"
                                                  id="field_details_{{ $data->Field }}">@if(isset($dataRow->details)){{ $dataRow->details }}@endif</textarea>
                                        <div id="field_details_{{ $data->Field }}_valid" class="alert-success alert"
                                             style="display:none">Valid Json
                                        </div>
                                        <div id="field_details_{{ $data->Field }}_invalid" class="alert-danger alert"
                                             style="display:none">Invalid Json
                                        </div>
                                    </td>
                                </tr>

                                <script>
                                    // do the deal
                                    var myJSONArea = JSONArea(document.getElementById('field_details_{{ $data->Field }}'), {
                                        sourceObjects: [] // optional array of objects for JSONArea to inherit from
                                    });

                                    valid_json["field_details_{{ $data->Field }}"] = false;
                                    console.log(valid_json);

                                    // then here's how you use JSONArea's update event
                                    myJSONArea.getElement().addEventListener('update', function (e) {

                                        if (e.target.value != "") {
                                            valid_json["field_details_{{ $data->Field }}"] = e.detail.isJSON;
                                        }
                                    });

                                    // then here's how you use JSONArea's update event
                                    myJSONArea.getElement().addEventListener('focusout', function (e) {
                                        if (valid_json['field_details_{{ $data->Field }}']) {
                                            $('#field_details_{{ $data->Field }}_valid').show();
                                            $('#field_details_{{ $data->Field }}_invalid').hide();
                                            var ugly = e.target.value;
                                            var obj = JSON.parse(ugly);
                                            var pretty = JSON.stringify(obj, undefined, 4);
                                            document.getElementById('field_details_{{ $data->Field }}').value = pretty;
                                        } else {
                                            $('#field_details_{{ $data->Field }}_valid').hide();
                                            $('#field_details_{{ $data->Field }}_invalid').show();
                                        }
                                    });
                                </script>

                            @endforeach
                            </tbody>
                        </table>

                    </div><!-- .panel -->

                    <div class="panel panel-primary panel-bordered">

                        <div class="panel-heading">
                            <h3 class="panel-title">{{ ucfirst($table) }} BREAD info</h3>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Table Name</label>
                                <input type="text" class="form-control" readonly name="name" placeholder="Name"
                                       value="@if(isset($dataType->name)){{ $dataType->name }}@else{{ $table }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">URL Slug (must be unique)</label>
                                <input type="text" class="form-control" name="slug" placeholder="URL slug (ex. posts)"
                                       value="@if(isset($dataType->slug)){{ $dataType->slug }}@else{{ $slug }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">Display Name (Singular)</label>
                                <input type="text" class="form-control" name="display_name_singular"
                                       placeholder="Display Name (Singular)"
                                       value="@if(isset($dataType->display_name_singular)){{ $dataType->display_name_singular }}@else{{ $display_name }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">Display Name (Plural)</label>
                                <input type="text" class="form-control" name="display_name_plural"
                                       placeholder="Display Name (Plural)"
                                       value="@if(isset($dataType->display_name_plural)){{ $dataType->display_name_plural }}@else{{ $display_name_plural }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">Icon (optional) Use a <a
                                            href="{{ config('voyager.assets_path') . '/fonts/voyager/icons-reference.html' }}"
                                            target="_blank">Voyager Font Class</a></label>
                                <input type="text" class="form-control" name="icon"
                                       placeholder="Icon to use for this Table"
                                       value="@if(isset($dataType->icon)){{ $dataType->icon }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">Model Name (ex. \App\Models\User, if left empty will try and use the table
                                    name)</label>
                                <input type="text" class="form-control" name="model_name" placeholder="Model Class Name"
                                       value="@if(isset($dataType->model_name)){{ $dataType->model_name }}@else{{ $model_name }}@endif">
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="generate_permissions">Generate Permissions</label><br>
                                    @php $checked = (isset($dataType->generate_permissions) && $dataType->generate_permissions == 1) ? true : (isset($generate_permissions) && $generate_permissions) ? true : false; @endphp
                                    <input type="checkbox" name="generate_permissions" class="toggleswitch"
                                           @if($checked) checked @endif>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="server_side">Server-side Pagination</label><br>
                                    @php $checked = (isset($dataType->server_side) && $dataType->server_side == 1) ? true : (isset($server_side) && $server_side) ? true : false; @endphp
                                    <input type="checkbox" name="server_side" class="toggleswitch"
                                           @if($checked) checked @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"
                                          placeholder="Description">@if(isset($dataType->description)){{ $dataType->description }}@endif</textarea>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div><!-- .panel-body -->

                    </div><!-- .panel -->
                </form>
            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- .page-content -->

    <script>
        function prettyPrint() {
            var ugly = document.getElementById('myTextArea').value;
            var obj = JSON.parse(ugly);
            var pretty = JSON.stringify(obj, undefined, 4);
            document.getElementById('myTextArea').value = pretty;
        }
    </script>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>

@stop
