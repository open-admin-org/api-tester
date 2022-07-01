<style>
    .param-add,.param {
        margin-bottom: 10px;
    }

    .param-add .form-group,.param .form-group {
        margin: 0;
    }

    .status-label {
        margin: 10px;
    }

    .response-tabs pre {
        border-radius: 0px;
    }

    .param-remove {
        margin-left: 5px !important;
    }

    .param-desc {
        display: block;
        margin-top: 5px;
        margin-bottom: 10px;
        color: #737373;
    }

    .nav-stacked>li {
        border-bottom: 1px solid #f4f4f4;
        margin: 0 !important;
    }

    .nav>li>a {
        padding: 10px 10px;
    }
    .card-header h2{
        font-size:1.5rem;
        margin-bottom:0;
    }

    </style>

<div class="row">
    <div class="col-md-3">

        <div class="card">
            <div class="card-header"><h2 class="">Routes</h2></div>
            <div class="card-body">


                <form action="#" method="post">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Type Url ..." class="form-control filter-routes">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat"><i class="icon-search"></i></button>
                        </span>
                    </div>
                </form>

                <ul class="nav nav-pills nav-stacked routes" style="margin-top: 5px;">
                    @foreach($routes as $route)
                        @php ($color = OpenAdmin\Admin\ApiTester\ApiTester::$methodColors[$route['method']])
                        <li class="route-item w-100"
                            data-uri="{{ $route['uri'] }}"
                            data-method="{{ $route['method'] }}"
                            data-method_color="{{$color}}"
                            data-parameters='{!! $route['parameters'] !!}'>

                            <a href="javascript:void(0)" class="route-link d-flex justify-content-between">
                                <b>{{ $route['uri'] }}</b>
                                <div class="">
                                    <span class="badge bg-{{ $color }}">{{ $route['method'] }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>

    </div>

    <!-- /.col -->
    <div class="col-md-9">


        <div class="card">

            <form id="api-tester-form" method="post" class="form-horizontal api-tester-form"  enctype="multipart/form-data" autocomplete="off" action="{{ route('api-tester-handle') }}">
                <div class="card-header"><h2 class="">Request</h2></div>
                <div class="card-body">

                    <div class="row form-group">
                        <label for="inputEmail3" class="col-sm-2 form-label">Request</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a class="input-group-text method">method</a>
                                </div>
                                <input type="text" name="uri" class="form-control uri">
                                <input type="hidden" name="method" class="form-control method">
                                {{ csrf_field() }}
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputUser" class="col-sm-2 form-label">Login as</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputUser" name="user" placeholder="Enter a user id or token to login with specific user.">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-sm-2 form-label">Parameters</label>

                        <div class="col-sm-10">
                            <div class="params">

                            </div>
                            <a class="btn btn-primary param-add">Add param</a>
                        </div>
                    </div>

                </div>
                  <div class="card-footer" style="margin-bottom: 0px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>

            </form>
        </div>

        <div class="card mt-5">
            <div class="nav-tabs-custom response-tabs d-none">
                <ul class="nav nav-tabs">
                    <li class="nav-item "><a class="nav-link active" data-bs-target="#content" aria-controls="content" data-bs-toggle="tab">Content</a></li>
                    <li class="nav-item "><a class="nav-link " data-bs-target="#headers" aria-controls="header" data-bs-toggle="tab">Headers</a></li>
                    {{--<li><a href="#cookies" data-toggle="tab">Cookies</a></li>--}}
                    <li class="nav-item"><a class="nav-link response-status"></a></li>
                </ul>
                <div class="tab-content card-body">

                    <div class="active tab-pane" id="content">
                        <div class="form-group"><pre><code class="line-numbers"></code></pre></div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="cookies">
                        <div class="form-group"><pre><code class="line-numbers"></code></pre></div>
                    </div>

                    <div class="tab-pane" id="headers">
                        <div class="form-group"><pre><code class="line-numbers"></code></pre></div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>

    </div>
    <!-- /.col -->
</div>


<template class="param-tpl">

    <div class="form-inline param d-flex">

        <div class="form-group me-2">
            <input type="text" name="key[__index__]" class="form-control param-key" style="width: 120px" placeholder="Key"/>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="val[__index__]" class="form-control param-val" style="width: 280px"  placeholder="value"/>
                <span class="input-group-btn">
                  <a type="button" class="btn btn-default btn-light change-val-type"><i class="icon-upload"></i></a>
                </span>
            </div>
        </div>

        <div class="form-group text-danger">
            <i class="btn btn-danger icon-times-circle param-remove"></i>
        </div>
        <br/>
        <div class="form-group param-desc hide p-2">
            <i class="icon-info-circle"></i>&nbsp;
            <span class="text"></span>
            <b class="text-red hide param-required">*</b>
        </div>
    </div>

</template>
<script data-exec-on-popstate>

    (function () {
        var timer;
        document.querySelector('.filter-routes').addEventListener('keyup', function (e) {
            var _this = e.target;
            clearTimeout(timer);
            timer = setTimeout(function () {
                var search = _this.value;
                var regex = new RegExp(search);
                document.querySelectorAll('ul.routes li').forEach(el => {
                    if (!regex.test(el.dataset.uri)) {
                        el.classList.add('d-none');
                    } else {
                        el.classList.remove('d-none');
                    }
                });
            }, 300);
        });

        document.querySelectorAll(".route-item").forEach(el => {

            el.addEventListener("click",function (e) {

                var li = e.currentTarget;
                var a_method = document.querySelector('a.method');
                a_method.innerHTML = li.dataset.method
                a_method.className.replace(/bg-[^\s]+/ ,'');
                a_method.classList.add('bg-'+li.dataset.method_color);
                a_method.classList.add('text-white');

                document.querySelector('.uri').value = li.dataset.uri;
                document.querySelector('.uri').value = li.dataset.uri;
                document.querySelector('input.method').value = li.dataset.method;

                document.querySelectorAll('.param').forEach(el=>{
                    el.remove();
                });

                document.querySelector('.response-tabs').classList.remove('d-none');

                appendParameters(eval(li.dataset.parameters));
            },true)
        });


        function getParamCount() {
            return document.querySelectorAll('.param').length;
        }

        function appendParameters(params) {

            for (var param in params) {

                var html = document.querySelector('template.param-tpl').innerHTML;
                html = html.replace(new RegExp('__index__', 'g'), getParamCount());

                var append = htmlToElement(html);

                append.querySelector('.param-key').value = params[param].name;
                append.querySelector('.param-val').value = params[param].defaultValue;
                append.querySelector('.param-desc').classList.remove('d-none');
                append.querySelector('.param-desc').querySelector('.text').innerHTML = params[param].description;

                if (params[param].required == 'true') {
                    append.querySelector('.param-desc .param-required').classList.remove('d-none');
                }

                if (params[param].type == 'file') {
                    append.querySelector('.param-val').setAttribute('type', 'file');
                    append.querySelector('.change-val-type i').classList.toggle("icon-upload");
                    append.querySelector('.change-val-type i').classList.toggle("icon-pen");
                }

                document.querySelector('.params').append(append);
            }
        }

        document.addEventListener('click',function(event){
            var target = event.target.closest(".change-val-type");
            if (target && this.contains(target)) {

                var type = target.parentNode.previousElementSibling;
                setType = (type.type == 'text') ? 'file' : 'text';
                type.setAttribute('type',setType);
                target.querySelector('i').classList.toggle("icon-upload");
                target.querySelector('i').classList.toggle("icon-pen");
            }
            var target2 = event.target.closest(".param-remove");
            if (target2 && this.contains(target2)) {
                target2.closest('.param').remove();
            }
        });

        document.querySelector('.param-add').addEventListener('click',function (event) {
            var html = document.querySelector('template.param-tpl').innerHTML;
            html = html.replace(new RegExp('__index__', 'g'), getParamCount());
            var append = htmlToElement(html);
            document.querySelector('.params').append(append);
            document.querySelector('.params .param').querySelector('input:first-child').focus();
        });

        function renderResponse(response) {

            console.log(response.language);

            document.querySelector('.response-tabs #content pre code').innerHTML = response.content;
            document.querySelector('.response-tabs #headers pre code').innerHTML = response.headers;
            document.querySelector('.response-tabs #cookies pre code').innerHTML = response.cookies;
            document.querySelectorAll('.response-tabs').forEach(el=>{
                el.classList.remove('d-none');
                el.className.replace(/language-[^\s]+/ ,'');
                el.classList.add('language-'+response.language);
            });

            Prism.highlightAll();

            var statusHolder = document.querySelector('.response-status');
            statusHolder.innerHTML = 'Status:&nbsp;'+ response.status.code+'&nbsp;&nbsp;'+response.status.text;

            if (response.status.code >= 400) {
                statusHolder.classList.remove('text-success');
                statusHolder.classList.add('text-danger');
            } else {
                statusHolder.classList.add('text-success');
                statusHolder.classList.remove('text-danger');
            }
        }


        document.getElementById('api-tester-form').addEventListener('submit', function (event) {
            event.preventDefault();
            var form =  document.getElementById('api-tester-form');
            admin.form.submit(form,function (result){
                if (result.status.text = 'ok') {
                    admin.toastr.success(result.data.message);
                    renderResponse(result.data);
                } else {
                    admin.toastr.error(result.data.message);
                }
            })
        });


    })();
</script>