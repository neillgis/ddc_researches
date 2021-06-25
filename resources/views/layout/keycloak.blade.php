@extends('layout.main')

@section('contents')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ตัวอย่างการดึงข้อมูล Keycloak API จากที่ HR</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">ตัวอย่างการดึงข้อมูล</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"> สิทธิ์ในการเข้าถึงของคุณ คือ </th>
                        <th scope="col">
                            @if (Gate::allows('keycloak-web', ['manager']))
                                manager
                            @elseif (Gate::allows('keycloak-web', ['admin']))
                                admin
                            @elseif (Gate::allows('keycloak-web', ['departments']))
                                admin departments
                            @else
                                user
                            @endif
                        </th>
                    </tr>
                </thead>
            </table>
            <div class="row">
                <div class="col-4" ><img id="image" height="300" /></div>
            </div>
            <div class="row">
                <div class="col-2">id</div>
                <div class="col-4" id="employee_id"></div>
                <div class="col-2">cid</div>
                <div class="col-4" id="cid"></div>
            </div>
            <div class="row">
                <div class="col-2">dept_id</div>
                <div class="col-4" id="dept_id"></div>
                <div class="col-2">edu_class</div>
                <div class="col-4" id="edu_class"></div>
            </div>
            <div class="row">
                <div class="col-2">nrms_id</div>
                <div class="col-4" id="nrms_id"></div>
                <div class="col-2">orcid_id</div>
                <div class="col-4" id="orcid_id"></div>
            </div>
            <div class="row">
                <div class="col-2">prefix</div>
                <div class="col-4" id="prefix"></div>
            </div>
            <div class="row">
                <div class="col-2">fname_th</div>
                <div class="col-4" id="fname_th"></div>
                <div class="col-2">lname_th</div>
                <div class="col-4" id="lname_th"></div>
            </div>
            <div class="row">
                <div class="col-2">fname_en</div>
                <div class="col-4" id="fname_en"></div>
                <div class="col-2">lname_en</div>
                <div class="col-4" id="lname_en"></div>
            </div>
            <div class="row">
                <div class="col-2">gender</div>
                <div class="col-4" id="gender"></div>
                <div class="col-2">birthdate</div>
                <div class="col-4" id="birthdate"></div>
            </div>
            <div class="row">
                <div class="col-2">age</div>
                <div class="col-4" id="age"></div>
                <div class="col-2">position</div>
                <div class="col-4" id="position"></div>
            </div>
            <div class="row">
                <div class="col-2">dep_address</div>
                <div class="col-4" id="dep_address"></div>
                <div class="col-2">tel</div>
                <div class="col-4" id="tel"></div>
            </div>
            <div class="row">
                <div class="col-2">profile_img</div>
                <div class="col-4" id="profile_img"></div>
                <div class="col-2">email</div>
                <div class="col-4" id="email"></div>
            </div>
            <div class="row">
                <div class="col-2">email_verified_at</div>
                <div class="col-4" id="email_verified_at"></div>
                <div class="col-2">password</div>
                <div class="col-4" id="password"></div>
            </div>
            <div class="row">
                <div class="col-2">remember_token</div>
                <div class="col-4" id="remember_token"></div>
                <div class="col-2">status</div>
                <div class="col-4" id="status"></div>
            </div>
            <div class="row">
                <div class="col-2">created_at</div>
                <div class="col-4" id="created_at"></div>
                <div class="col-2">updated_at</div>
                <div class="col-4" id="updated_at"></div>
            </div>
            <div class="row">
                <div class="col-2">last_login</div>
                <div class="col-4" id="last_login"></div>
                <div class="col-2">researcher_level</div>
                <div class="col-4" id="researcher_level"></div>
            </div>
            <div class="row">
                <div class="col-2">data_auditor</div>
                <div class="col-4" id="data_auditor"></div>
            </div>
        </div><!-- /.container -->
    </section>
    <!-- /.content -->

@endsection

@section('js-custom')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "https://hr.ddc.moph.go.th/api/v2/employee/{{ Auth::user()->preferred_username }}",
                type: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "bearer {{ KeycloakWeb::retrieveToken()['access_token'] }}"
                },
                success: function(result) {
                    //console.log(result)

                    $("#employee_id").text(result.employeeId);
                    $("#cid").text(result.idCard);
                    $("#dept_id").text(result.deptId + '|'+result.deptName);
                    $("#edu_class").text(result.educationLevel);
                    $("#prefix").text(result.title);
                    $("#fname_th").text(result.fname);
                    $("#lname_th").text(result.lname);
                    $("#fname_en").text(result.efname);
                    $("#lname_en").text(result.elname);
                    $("#gender").text(result.sex);
                    $("#birthdate").text(result.birthday);
                    $("#position").text(result.position);
                    $("#tel").text(result.telephone);
                    $("#email").text(result.email);
                }
            });


            $.ajax({
                url: "https://hr.ddc.moph.go.th/api/v2/employee/pic/{{ Auth::user()->preferred_username }}",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "bearer {{ KeycloakWeb::retrieveToken()['access_token'] }}"
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success (data) {
                    const url = window.URL || window.webkitURL;
                    const src = url.createObjectURL(data);
                    $('#image').attr('src', src);
                }
            });
        });

    </script>
@endsection
